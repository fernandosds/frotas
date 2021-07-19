<?php

namespace App\Http\Controllers\Iscas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tracker;
use App\Services\Iscas\TrackerService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;
use DB;

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
                return response()->json(['status' => 'validation_error', 'errors' => "Código do dispositivo inválido"], 404);
            }
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'status' => 'device'], 500);
        }
    }

    public function getTracker(Request $request)
    {
        $data = Tracker::where("model", "LIKE", "%{$request->input('query')}%")->get();

        return response()->json($data);
    }
}
