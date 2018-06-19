<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController {
    protected $view_path = 'news';
    protected $item_path = 'news/';

    public function index(Request $request, $id = null) {
        // if ($id > 0) {
        //     $news = News::where('id', $id)->get();
        // }

        $news = ($id > 0)
            ? News::where('id', $id)->get()
            : News::where('id', '>', 0)->paginate(3);

        return view($this->view_path . '/index', [
            'news' => $news,
            'has_pagination' => method_exists($news, 'links'),
            'path' => $this->item_path]);
    }
}