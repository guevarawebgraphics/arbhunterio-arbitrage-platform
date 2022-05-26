<?php

namespace App\Services\CouponCodes\Repositories;

use App\Services\Base\Repository;
use App\Services\CouponCodes\CouponCode;

/**
 * Class CouponCodeRepository
 * @package App\Services\CouponCodes\Repositories
 * @author Bryan James Dela Luya
 */

class CouponCodeRepository extends Repository implements CouponCodeRepositoryInterface
{
    public function __construct(CouponCode $model)
    {
        $this->model = $model;
    }

    public function fetchAll() 
    {
        return $this->model->all();
    }

    public function addData(array $input) 
    {
        return $this->create($input);
    }

    public function updateData(int $id, array $input) 
    {
        $data = $this->model->find($id);
        $data->fill($input)->save();
    }
}
