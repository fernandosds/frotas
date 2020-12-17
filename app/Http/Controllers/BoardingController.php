<?php

namespace App\Http\Controllers;

use App\Services\BoardingService;
use Illuminate\Http\Request;

class BoardingController extends Controller
{

    /**
     * @var BoardingService
     */
    private $boardingService;

    /**
     * BoardingController constructor.
     * @param BoardingService $boardingService
     */
    public function __construct(BoardingService $boardingService)
    {
        $this->boardingService = $boardingService;

        $this->data = [
            'icon' => 'fa fa-shipping-fast',
            'title' => 'Embarque',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['boardings'] = $this->boardingService->paginate();

        return response()->view('boardings.list', $data);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function new()
    {

        $data = $this->data;
        return response()->view('boardings.new', $data);
    }



}
