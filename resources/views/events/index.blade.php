@extends('base')
@section('title', 'EVENTS')
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
    @if($has_pagination)
    {{ $events->links() }}
    @endif
</div>
@endsection