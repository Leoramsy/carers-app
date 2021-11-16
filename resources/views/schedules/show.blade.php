@extends('layouts.app', ['page' => 'Schedules' ,'page_slug' => 'schedules', 'category' => 'schedules'])
@section('css_files')
    {!! Html::style('packages/fullcalendar-scheduler-5.10.0/main.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
@endsection
@section('scripts')
    {!! Html::script('packages/fullcalendar-scheduler-5.10.0/main.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
@include('schedules.javascript.page.schedules')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div  id="content" class="card">
            <div class="card-body">
                <div id="calender-div" class="col-md-12">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
