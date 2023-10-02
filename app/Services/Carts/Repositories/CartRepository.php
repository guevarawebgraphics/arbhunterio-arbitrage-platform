<?php

namespace App\Services\Carts\Repositories;

use App\Services\Base\Repository;
use App\Services\Carts\Cart;

/**
 * Class CartRepository
 * @package App\Services\Products\Repositories
 * @author Guevara Web Graphics Studio
 */

class CartRepository extends Repository implements CartRepositoryInterface
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }
}
