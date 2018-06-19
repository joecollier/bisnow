@extends('base')
@section('title', 'EVENTS')
@section('content')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url : "/tracking/news_views"
            });
        });
    </script>

    <div id="events-container">
        @foreach ($events as $events_item)
        <link href="{{ asset('css/events.css') }}" rel="stylesheet">
        <div class="events-item">
            <div class="events-item-name">{{ $events_item->name }}</div>
            <div class="events-item-description">{!! $events_item->description !!}</div>
        </div>
        @if($events_item->id == count($events))
        <div class="item-last">&nbsp;</div>
        @endif
        @endforeach
    </div>

    <div id="events-links" class="links">
        {{ $events->links() }}
    </div>
@endsection