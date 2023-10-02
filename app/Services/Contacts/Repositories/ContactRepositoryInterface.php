<?php

namespace App\Services\Contacts\Repositories;

use App\Services\Base\RepositoryInterface;

/**
 * Class ContactRepositoryInterface
 * @package App\Services\Contacts\Repositories
 * @author Guevara Web Graphics Studio
 */

interface ContactRepositoryInterface extends RepositoryInterface
{
    function fetchContacts();

    function addContact(array $data);

    function sendEmail(array $params);
}
