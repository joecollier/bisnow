@extends('base')
@section('title', 'NEWS')
@section('content')
<script type="text/javascript">
    $(document).ready(function() {
        var pathname = window.location.pathname; // Returns path only
        var url  = window.location.href;     // Returns full URL

        $.ajax({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST', // Type of response and matches what we said in the route
            url: '/pageviews', // This is the url we gave in the route
            data: { // a JSON object to send back
                'url' : url,
                'pathname' : pathname,
                'id' : {{ $id }}
            },

            success: function(response){ // What to do if we succeed
                console.log(response);
            }
        });
    });
</script>
<div id="news-container">
    @foreach ($news as $news_item)
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
    <div class="news-item">
        <div class="news-item-title bg-primary">{{ $news_item->title }}</div>
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