<?php

namespace App\Http\Controllers\Iscas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Iscas\TrackerService;
use Illuminate\Support\Facades\Auth;

class TrackerController extends Controller
{
    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    private $trackerService;
    private $data;

    /**
     * TrackertController constructor.
     * @param TrackerService $trackerService
     */
    public function __construct(TrackerService $trackerService)
    {
        $this->trackerService = $trackerService;

        $this->data = [
            'icon' => 'flaticon2-contract',
            'title' => 'Tracker',
        ];
    }

    /**
     * @param BoardingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findTrackerByModel(String $tracker)
    {
        try {
            $tracker =  $this->trackerService->findTrackerByModel($tracker);
            if (!$tracker) {
                return response()->json(['status' => 'error', 'errors' => "Informe o codigo autenticador"], 404);
            }
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => 'device'], 500);
        }
    }
}
