<?php

namespace App\Repository\Transaction;

use App\Laravue\Models\Transaction;
use App\Repository\BaseRepository;
use Illuminate\Support\Str;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function store(array $attributes)
    {
        $attributes['payment_code'] = '#' . Str::random(5) . sha1(time());
        $attributes['order_id'] = $attributes['id'];
        $transaction = $this->model->create($attributes);
        return $transaction;
    }

    public function cancelTransaction($id)
    {
        return $this->update($id, ['payment_status' => 2]);
    }

    public function confirmTransaction($id)
    {
        return $this->update($id, ['payment_status' => 1]);
    }
}
