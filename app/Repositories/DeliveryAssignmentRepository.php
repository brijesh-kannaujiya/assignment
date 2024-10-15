<?php

namespace App\Repositories;

use App\Models\DeliveryPersonnel;
use App\Models\Order;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;

class DeliveryAssignmentRepository implements DeliveryAssignmentRepositoryInterface
{

    public function assignOrder($orderId)
    {

        $order = Order::find($orderId);
        if (!$order) return null;

        if ($order->urgency_level == 'urgent') {
            $availablePersonnel = $this->getAvailablePersonnel(['expert'], $order);
        } elseif ($order->urgency_level == 'standard') {
            $availablePersonnel = $this->getAvailablePersonnel(['intermediate', 'expert'], $order);
        } else {
            $availablePersonnel = $this->getAvailablePersonnel(['beginner'], $order);
            if ($availablePersonnel->isEmpty()) {
                $availablePersonnel = $this->getAvailablePersonnel(['beginner', 'intermediate', 'expert'], $order);
            }
        }

        $personnel = $this->selectInRoundRobin($availablePersonnel);

        if ($personnel && $this->canHandleOrder($personnel, $order)) {
            return $this->createAssignment($personnel, $order);
        }

        return null;
    }


    protected function getAvailablePersonnel($skillLevels, $order)
    {
        return DeliveryPersonnel::whereIn('skill_level', $skillLevels)
            ->where('current_orders', '<', DB::raw('max_orders'))
            ->orderBy('current_orders', 'asc')
            ->get();
    }


    protected function selectInRoundRobin($availablePersonnel)
    {
        if ($availablePersonnel->isEmpty()) return null;
        $lastAssigned = DeliveryPersonnel::orderBy('last_assigned_at', 'desc')->first();

        $nextPersonnel = $availablePersonnel->filter(function ($personnel) use ($lastAssigned) {
            return $personnel->id > ($lastAssigned->id ?? 0); // Get personnel with higher IDs than the last one
        })->first();

        if (!$nextPersonnel) {
            $nextPersonnel = $availablePersonnel->first();
        }

        return $nextPersonnel;
    }


    protected function canHandleOrder($personnel, $order)
    {
        if ($personnel->current_orders >= $personnel->max_orders) {
            return false;
        }

        if ($order->urgency_level == 'urgent' && $personnel->skill_level != 'expert') {
            return false;
        }
        if ($order->urgency_level == 'standard' && !in_array($personnel->skill_level, ['intermediate', 'expert'])) {
            return false;
        }
        if ($order->urgency_level == 'low' && !in_array($personnel->skill_level, ['beginner', 'intermediate', 'expert'])) {
            return false;
        }

        return true;
    }


    protected function createAssignment($personnel, $order)
    {
        $assignment = Assignment::create([
            'delivery_person_id' => $personnel->id,
            'order_id' => $order->id,
            'assigned_at' => now()
        ]);

        $personnel->increment('current_orders');

        $personnel->update(['last_assigned_at' => now()]);

        $order->update(['status' => 'assigned']);

        return $assignment;
    }


    public function markOrderAsDelivered($assignmentId)
    {
        $assignment = Assignment::find($assignmentId);
        if (!$assignment) return null; 
        if ($assignment->order->status === 'delivered') {
            return response()->json(['message' => 'Order has already been delivered.'], 400);
        }
        $assignment->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
        
        $assignment->order->status = 'delivered';
        $assignment->order->save();

        $personnel = $assignment->deliveryPersonnel;
        $personnel->decrement('current_orders');
        return $assignment;
    }
}
