@extends('base')
@section('title', 'HOME')
@section('content')
    HOME

<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: 'GET',
            url : "/tracking/website_views"
        });
    });
</script>

@endsection
@section('links')
    <div id="footer-links">&nbsp;</div>
@endsection