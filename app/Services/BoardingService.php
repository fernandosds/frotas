<?php
/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 12:25
 */

namespace App\Services;


use App\Repositories\BoardingRepository;

class BoardingService
{

    /**
     * UserService constructor.
     * @param BoardingRepository $boarding
     */
    public function __construct(BoardingRepository $boarding)
    {
        $this->boarding = $boarding;
    }

    /**
     * @param Int $limit
     * @return mixed
     */
    public function paginate(Int $limit = 15)
    {
        return $this->boarding->paginate($limit);
    }

}