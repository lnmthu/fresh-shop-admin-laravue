<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function processTransaction($id, Request $request)
    {
        $this->transactionRepository->update(['payment_status' => $request->status], $id);
        $transaction = $this->transactionRepository->findById($id);
        return response()->json(['status' => 'success']);
    }

    public function chargeCard(Request $request)
    {
        $data = $request->all();
        $data['stripe_secret'] = config('app.stripe_secret');
        $this->transactionRepository->chargeCard($data);
    }
}
