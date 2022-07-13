<?php

/**
 * Created by PhpStorm.
 * User: Paulo Sérgio
 * Date: 16/12/2020
 * Time: 16:49
 */

namespace App\Services;

use App\Repositories\MapMarkersSantanderRepository;
use Exception;
use Illuminate\Support\Facades\Auth;


class MapMarkersSantanderService
{
    public $mapMarkersRepository;

    public function __construct(MapMarkersSantanderRepository $mapMarkersRepository)
    {
        $this->mapMarkersRepository = $mapMarkersRepository;
    }

    public function save($data)
    {
        try {
            return $this->mapMarkersRepository->create($data);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id, $name)
    {
        try {
            $marker = $this->getMarker($id);
            if ((isset($marker) && $marker->name != $name) || !isset($marker)) {
                throw new Exception('Cerca inválida');
            }
            return $this->mapMarkersRepository->delete($id);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getList()
    {
        try {
            return $this->mapMarkersRepository->getMarkers();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getMarker($id)
    {
        try {
            return $this->mapMarkersRepository->getMarker($id);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
