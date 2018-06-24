<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class EventsController {
    protected $view_path = 'events';
    protected $item_path = 'events/';

    public function index(Request $request, $id = null) {
        $events = ($id > 0)
            ? Events::where('id', $id)->get()
            : Events::where('id', '>', 0)->paginate(3);

        return view($this->view_path . '/index', [
            'id' => $id ?? 0,
            'events' => $events,
            'has_pagination' => method_exists($events, 'links'),
            'path' => $this->item_path]);
    }
}
