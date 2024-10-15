<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Repositories\DeliveryAssignmentRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AssignOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign all pending orders to delivery personnel';


    protected $deliveryAssignmentRepository;

    // Inject the DeliveryAssignmentRepository
    public function __construct(DeliveryAssignmentRepository $deliveryAssignmentRepository)
    {
        parent::__construct();
        $this->deliveryAssignmentRepository = $deliveryAssignmentRepository;
    }



    
    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        $pendingOrders = Order::where('status', 'pending')->get();
 
        if ($pendingOrders->isEmpty()) {
            $this->info('No pending orders to assign.');
            Log::info('No pending orders to assign.');
            return;
        }
 
        Log::info('Order assignment process started.', ['total_orders' => $pendingOrders->count()]);
 
        foreach ($pendingOrders as $order) {
            $assignment = $this->deliveryAssignmentRepository->assignOrder($order->id);

            if ($assignment) {
                $message = 'Order ID ' . $order->id . ' successfully assigned to Delivery Person ID ' . $assignment->delivery_person_id;
                $this->info($message);
                Log::info($message, [
                    'order_id' => $order->id,
                    'delivery_person_id' => $assignment->delivery_person_id,
                    'order_details' => $order->toArray(),
                ]);
            } else {
                $warning = 'Order ID ' . $order->id . ' could not be assigned due to lack of available personnel.';
                $this->warn($warning);
                Log::warning($warning, ['order_id' => $order->id]);
            }
        }

        $this->info('Order assignment process completed.');
        Log::info('Order assignment process completed.');
    }

}
