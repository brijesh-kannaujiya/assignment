<?php
namespace App\Http\Controllers;

use App\Repositories\DeliveryAssignmentRepositoryInterface;
use Illuminate\Http\Request;

class DeliveryAssignmentController extends Controller
{
    protected $repository;

    public function __construct(DeliveryAssignmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
 
    public function assignOrder(Request $request, $orderId)
    {
        $assignment = $this->repository->assignOrder($orderId);

        if ($assignment) {
            return response()->json(['message' => 'Order assigned successfully', 'assignment' => $assignment], 200);
        }

        return response()->json(['message' => 'No available personnel to handle this order'], 400);
    }

    
    public function markOrderAsDelivered(Request $request, $assignmentId)
    { 
        $assignment = $this->repository->markOrderAsDelivered($assignmentId);

        if ($assignment) {
            return response()->json(['message' => 'Order marked as delivered', 'assignment' => $assignment], 200);
        }
        return response()->json(['message' => 'Assignment not found'], 404);
    }
}
