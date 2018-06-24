<?php

namespace App\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController
{
    protected $view_path = 'news';
    protected $item_path = 'news/';

    public function index(Request $request, $id = null) {
        $news = ($id > 0)
            ? News::where('id', $id)->get()
            : News::where('id', '>', 0)->paginate(3);

        return view($this->view_path . '/index', [
            'id' => $id ?? 0,
            'news' => $news,
            'has_pagination' => method_exists($news, 'links'),
            'path' => $this->item_path]);
    }
}
