<?php

namespace App\Repositories;

interface DeliveryAssignmentRepositoryInterface
{
    public function assignOrder($orderId);
    public function markOrderAsDelivered($assignmentId);
}
