<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class EventsController {
    protected $view_path = 'events';
    protected $item_path = 'events/';

    public function index(Request $request, $id = null) {
        // if ($id > 0) {
        //     $events = events::where('id', $id)->get();
        // }

        $events = ($id > 0)
            ? Events::where('id', $id)->get()
            : Events::where('id', '>', 0)->paginate(3);

        // var_dump($events);

        return view($this->view_path . '/index', [
            'events' => $events,
            'path' => $this->item_path]);
    }
}