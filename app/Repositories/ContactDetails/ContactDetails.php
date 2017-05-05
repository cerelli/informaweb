<?php
namespace App\Repositories\ContactDetails;

use App\Models\Contact_detail;
use App\Repositories\ContactDetails\ContactDetailsInterface;

class ContactDetails implements ContactDetailsInterface
{

    public function getAllOfContact($contactId)
    {
        return Contact_detail::all();
    }
}