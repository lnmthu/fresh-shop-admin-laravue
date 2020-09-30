<?php

namespace App\Repositories\Transaction;

use App\Repositories\RepositoryInterface;

interface TransactionRepositoryInterface extends RepositoryInterface
{
    // public function cancelTransaction($id);
    // public function confirmTransaction($id);
    public function chargeCard(array $attributes);
}
