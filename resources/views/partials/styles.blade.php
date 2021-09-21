{{-- Template main styling --}}
{{-- Included packages --}}
{!! Html::style('packages/bootstrap-4.2.1/css/bootstrap.css?v='. config('app.css_version')) !!}
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/template') }}/dashboard.css">
{!! Html::style('packages/Select2-4.0.3/css/select2.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('packages/Select2-4.0.3/css/select2-bootstrap.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
@if(app()->environment('production'))
{!! Html::style('packages/DataTables-Merged/datatables.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
@else
{!! Html::style('packages/DataTables-1.10.24/css/dataTables.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('packages/DateTime-1.0.2/css/dataTables.dateTime.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('packages/Buttons-1.7.0/css/buttons.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('packages/Select-1.3.2/css/select.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
{!! Html::style('packages/Editor-2.0.0/css/editor.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'css') !!}
@endif
{!! Html::style('packages/font-awesome-4.7.0/css/font-awesome.min.css?v='. config('app.css_version')) !!}
<!-- carers: Package Specific -->
{!! Html::style('css/packages/bootstrap.css?v='. config('app.css_version')) !!}
{!! Html::style('css/packages/datatable.custom.css?v='. config('app.css_version')) !!}
{!! Html::style('css/packages/carers.datatables.css?v='. config('app.css_version')) !!}
{!! Html::style('css/packages/carers.datatables.buttons.css?v='. config('app.css_version')) !!}
{!!  Html::style('css/packages/editor.modal.css?v='. config('app.css_version')) !!}
{!! Html::style('css/packages/editor.multi-columns.css?v='. config('app.css_version')) !!}
<!-- carers: Global general -->
{!! Html::style('fonts/Lato/latofonts.css?v='. config('app.css_version')) !!}
{!! Html::style('css/main.css?v='. config('app.css_version')) !!}
<!-- carers: Page Specific -->
@yield('css_files')

