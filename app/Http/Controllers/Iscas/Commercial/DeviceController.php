<?php

namespace App\Http\Controllers\Iscas\Commercial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->checked == "isca") {
            $arr_devices[] = [
                'quantity'          => $request->quantity,
                'technologie_id'    => $request->technologie_id,
                'technologie_name'  => $request->technologie_name,
                'product'           => 'Isca',
                'value'             => $request->value,
                'total'             => $request->value * $request->quantity
            ];
        } else {
            $arr_devices[] = [
                'quantity'          => $request->quantity,
                'technologie_id'    => '-',
                'technologie_name'  => '-----------------',
                'product'           => 'Disp. Movel',
                'value'             => $request->value,
                'total'             => $request->value * $request->quantity
            ];
        }

        if ($request->session()->has('devices')) {
            $arr_devices = array_merge($request->session()->get('devices'), $arr_devices);
        }

        $request->session()->put('devices', $arr_devices);

        $total = 0;
        foreach ($arr_devices as $item) {
            $total += $item['total'];
        }

        return view('commercial.contract.list_device', ['devices' => $arr_devices, 'total' => $total]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function remove(Request $request)
    {

        $arr_devices = $request->session()->get('devices');

        unset($arr_devices[$request->input('id')]);

        $request->session()->put('devices', $arr_devices);

        $total = 0;
        foreach ($arr_devices as $item) {
            $total += $item['total'];
        }

        return view('commercial.contract.list_device', ['devices' => $arr_devices, 'total' => $total]);
    }
}
