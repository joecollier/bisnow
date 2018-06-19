<?php

namespace App\Controllers;

use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrackingController
{
    protected $view_type = 'website_views';

    protected function getSessionId()
    {
        if (empty(session_id())) {
            session_start();
        }

        return session_id();
    }

    protected function getNewViewCountByDateTypeAndSessionId($date, $type, $session_id)
    {
        $tracking = Tracking::where('date', $date)
            ->where('type', $type)
            ->where('session_id', $session_id)
            ->orderBy('id', 'desc');

        if ($tracking->first()) {
            $tracking_last_view_count = $tracking->first()->toArray()['value'];

            $tracking_view_count_inc = ($tracking_last_view_count > 0)
                ? $tracking_last_view_count + 1
                : 1;

            return $tracking_view_count_inc;
        }

        return 1;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tracking = new Tracking();

        $date = Carbon::now()->toDateString();
        $session_id = $this->getSessionId();
        $type = $request->get('type');
        $view_count_inc = $this->getNewViewCountByDateTypeAndSessionId($date, $type, $session_id);

        $values = [];
        $values['date'] = $date;
        $values['session_id'] = $session_id;
        $values['type'] = $type;
        $values['value'] = $view_count_inc;

        $tracking->fill($values);
        $tracking->save();

        die();

        echo json_encode($request->request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo json_encode($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelsTracking  $modelsTracking
     * @return \Illuminate\Http\Response
     */
    // public function show(ModelsTracking $modelsTracking)
    // {
    //     //
    // }
}
