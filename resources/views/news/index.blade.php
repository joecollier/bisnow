@extends('base')
@section('title', 'NEWS')
@section('content')
    @foreach ($news as $news_item)
    <div class="news-item">
        <div class="news-item-title">{{ $news_item->title }}</div>
        <div class="news-item-html">{!! $news_item->html_body !!}</div>
    </div>
    @endforeach
@endsection