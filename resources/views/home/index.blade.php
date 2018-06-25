@extends('base')
@section('title', 'HOME')
@section('content')
<script type="text/javascript">
    $(document).ready(function() {
        var pathname = window.location.pathname; // Returns path only
        var url  = window.location.href;     // Returns full URL

        console.log(url);
        console.log(pathname);

        $.ajax({
            headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST', // Type of response and matches what we said in the route
            url: '/pageviews', // This is the url we gave in the route
            data: { // a JSON object to send back
                'url' : url,
                'pathname' : pathname
            },

            success: function(response){ // What to do if we succeed
                console.log(response);
            }
        });
    });
</script>
@endsection
@section('links')
    <div id="footer-links">&nbsp;</div>
@endsection