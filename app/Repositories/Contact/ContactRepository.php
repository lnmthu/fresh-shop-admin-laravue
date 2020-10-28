<?php

namespace App\Repositories\Contact;

use App\Repositories\BaseRepository;
use App\Laravue\Models\Contact;
use App\Repositories\Contact\ContactInterface;

class ContactRepository extends BaseRepository implements ContactInterface
{
    protected $model;
    public function __construct(Contact $contact)
    {
        $this->model = $contact;
        parent::__construct($contact);
    }
}
