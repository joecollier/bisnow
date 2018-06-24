<?php

namespace App\Controllers;

use App\Models\Views;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageViewsController
{
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
        // $end_time = Carbon::now()->toDateString();
        // $start_time = Carbon::now()->subDays(7)->toDateString();

        var_dump(Carbon::now()->subDays(7)->toDateString());

        $trackings = Tracking::where('date', '>=', Carbon::now()->subDays(7)->toDateString());
        var_dump(json_encode($trackings));
    }

    protected function getItemTypeFromPathname($pathname = '')
    {
        return explode('/', $pathname)[1] ?? '';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pathname = $request->get('pathname');

        $this->getItemTypeFromPathname($pathname);

        $values = [
            'url' => $request->get('url') ?? 'http://',
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'session_id' => $this->getSessionId(),
            'item_type' => $this->getItemTypeFromPathname($pathname),
            'item_id' => (int) $request->get('id'),
            'email' => '',
            'marketing_tracking_code' => ''
        ];

        $pageviews = new Views();
        $pageviews->fill($values);
        $pageviews->save();
    }
}
