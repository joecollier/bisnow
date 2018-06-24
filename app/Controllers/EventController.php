<?php

namespace App\Controllers;

class EventController {
    protected $view_path = 'home';
    protected $item_path = 'home/';

    public function index() {
        return view($this->view_path . '/index', ['path' => $this->item_path]);
    }
}