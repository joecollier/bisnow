@extends('base')
@section('title', 'NEWS')
@section('content')
    <div id="news-container">
        @foreach ($news as $news_item)
        <link href="{{ asset('css/news.css') }}" rel="stylesheet">
        <div class="news-item">
            <div class="news-item-title">{{ $news_item->title }}</div>
            <div class="news-item-html">{!! $news_item->html_body !!}</div>
        </div>
        @if($news_item->id == count($news))
        <div class="item-last">&nbsp;</div>
        @endif
        @endforeach
    </div>
@endsection
@section('links')
    <div id="footer-links">
        @if($has_pagination)
        {{ $news->links() }}
        @endif
    </div>
@endsection