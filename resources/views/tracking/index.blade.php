@extends('base')
@section('title', 'HOME')
@section('content')
    <div id="tracking-content">
        <div id="tracking-content-json">{{ $tracking_json }}</div>
        <div id="tracking-content-csv">
            <a href="tracking/csv"><div>DOWNLOAD TRACKING CSV</div></a>
        </div>
    </div>
@endsection
@section('links')
<div id="footer-links">&nbsp;</div>
@endsection