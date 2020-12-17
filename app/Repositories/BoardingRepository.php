<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Repositories;


use App\Models\Boarding;

class BoardingRepository extends AbstractRepository
{

    /**
     * UserRepository constructor.
     * @param Boarding $model
     */
    public function __construct(Boarding $model)
    {
        $this->model = $model;
    }

}