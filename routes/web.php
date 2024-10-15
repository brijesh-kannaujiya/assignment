<?php

use App\Http\Controllers\DeliveryAssignmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
 
Route::get('/orders/{orderId}/assign', [DeliveryAssignmentController::class, 'assignOrder']);
Route::get('/assignments/{assignmentId}/deliver', [DeliveryAssignmentController::class, 'markOrderAsDelivered']);
