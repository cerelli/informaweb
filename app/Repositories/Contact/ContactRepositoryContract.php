<?php
namespace App\Repositories\Contact;

interface ContactRepositoryContract
{
    public function getContactDetails($contact_id);
}
