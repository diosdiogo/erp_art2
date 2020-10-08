@extends('layouts.app')
 @push('script-head')
    <link href="{{asset('assets/plugins/iCheck/all.css') }}" rel="stylesheet">
    <link href="{{asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/dist/css/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/kendo/kendo.common.min.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/kendo/kendo.default.min.css') }}" rel="stylesheet" />
<style>
    .k-state-selected, .k-state-selected:link, .k-state-selected:visited, .k-list > .k-state-selected, .k-list > .k-state-highlight, .k-panel > .k-state-selected, .k-ghost-splitbar-vertical, .k-ghost-splitbar-horizontal, .k-draghandle.k-state-selected:hover, .k-scheduler .k-scheduler-toolbar .k-state-selected, .k-scheduler .k-today.k-state-selected, .k-marquee-color {
        color: #ffffff;
        background-color: #3c8dbc;
        border-color: #3c8dbc;
    }

    .k-state-selected, .k-state-selected:link, .k-state-selected:visited, .k-list > .k-state-selected, .k-list > .k-state-highlight, .k-panel > .k-state-selected, .k-ghost-splitbar-vertical, .k-ghost-splitbar-horizontal, .k-draghandle.k-state-selected:hover, .k-scheduler .k-scheduler-toolbar .k-state-selected, .k-scheduler .k-today.k-state-selected, .k-marquee-color {
        color: #ffffff;
        background-color: #3c8dbc;
        border-color: #3c8dbc;
    }

    #gridtemplate tbody tr:hover {
        background: #3c8dbc;
    }

    .label-black{
        background: #000 !important;
    }
</style>
@endpush
@section('content')
    @yield('content');
@endsection

@push('scripts')
    <script src="{{ asset('assets/dist/js/gridall.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/gridtemplate.js') }}"></script>

    <script>
        $(document).ajaxStart(function () { Pace.restart(); });
    </script>
@endpush

