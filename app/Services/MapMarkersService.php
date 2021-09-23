<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 16:49
 */

namespace App\Services;

use App\Repositories\MapMarkersRepository;
use Illuminate\Support\Facades\Auth;


class MapMarkersService
{
    public $mapMarkersRepository;

    public function __construct(MapMarkersRepository $mapMarkersRepository)
    {
        $this->mapMarkersRepository = $mapMarkersRepository;
    }

    public function save($name, $markers)
    {
        try {
            return $this->mapMarkersRepository->create(['markers' => $markers, 'name' => $name]);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getList()
    {
        try {
            return $this->mapMarkersRepository->getMarkers();
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getMarker($id)
    {
        try {
            return $this->mapMarkersRepository->getMarker($id);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
