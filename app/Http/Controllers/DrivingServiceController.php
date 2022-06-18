<?php

namespace App\Http\Controllers;

use App\Models\DrivingService;
use App\Http\Resources\DrivingService as ResourceDrivingService;
use Illuminate\Http\Request;

class DrivingServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia(
            'DrivingService/Index',
            [
                'drivings' => ResourceDrivingService::collection(
                    DrivingService::with('user')->orderBy('day', 'desc')->get()
                )
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'time' => 'required',
            'day' => 'required',
        ]);

        $driving = new DrivingService;

        $driving->day = $request->day;
        $driving->time = $request->time;
        $driving->user_id = auth()->user()->id;
        $driving->save();

        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DrivingService $drivingService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Http\Response
     */
    public function destroy(DrivingService $drivingService)
    {
        $this->authorize('delete', $drivingService);
        $drivingService->delete();
        return redirect()->back();
    }
}
