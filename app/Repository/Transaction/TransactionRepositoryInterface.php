<?php

namespace App\Repository\Transaction;

use App\Repository\RepositoryInterface;

interface TransactionRepositoryInterface extends RepositoryInterface
{
    public function cancelTransaction($id);
    public function confirmTransaction($id);
}
