<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Laravue\Models\User;
use App\Repository\Order\OrderRepositoryInterface;
use App\Repository\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderRepository;
    private $transactionRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, TransactionRepositoryInterface $transactionRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $orders = $this->orderRepository->getAllPaginate($params);
        return OrderResource::collection($orders);
    }

    public function getAllDeleted()
    {
        $orders = $this->orderRepository->getAllDeleted();
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $order = $this->orderRepository->findById($id);
        return new OrderResource($order);
    }

    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $order = $this->orderRepository->store($data);
        $payment = $this->transactionRepository->store($order->toArray());
        return new OrderResource($order);
    }

    public function processOrder($id, Request $request)
    {
        $this->orderRepository->update($id, ['status' => $request->status]);
        $order = $this->orderRepository->findById($id);
        return new OrderResource($order);
    }

    public function destroy($id)
    {
        $order = $this->orderRepository->delete($id);
        return response()->json(['status' => 'success', 'message' => 'order deleted']);
    }
}
