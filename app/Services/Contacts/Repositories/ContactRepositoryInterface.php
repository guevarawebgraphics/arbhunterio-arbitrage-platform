<?php

namespace App\Services\Contacts\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class ContactRepositoryInterface
 * @package App\Services\Contacts\Repositories
 * @author Bryan James Dela Luya
 */

interface ContactRepositoryInterface extends RepositoryInterface
{
    function fetchContacts();

    function addContact(array $data);

    function sendEmail(array $params);
}
