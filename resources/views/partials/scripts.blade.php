{{-- Template main scripts --}}
<script src="{{ asset('js/template') }}/jquery.min.js"></script>
<script src="{{ asset('js/template') }}/popper.min.js"></script>
<script src="{{ asset('js/template') }}/bootstrap.min.js"></script>
<script src="{{ asset('js/template') }}/perfect-scrollbar.jquery.min.js"></script>
<script src="{{ asset('js/template') }}/dashboard.js"></script>
<script src="{{ asset('js/template') }}/theme.js"></script>
<script src="{{ asset('js/template') }}/chartjs.min.js"></script>
<script src="{{ asset('js/template') }}/bootstrap-notify.js"></script>
{{-- Included packages --}}
{!! Html::script('packages/moment-2.24.0/moment.min.js') !!}
{!! Html::script('packages/Select2-4.0.3/js/select2.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
@if(app()->environment('production'))
{!! Html::script('packages/DataTables-Merged/datatables.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
@else
{!! Html::script('packages/DataTables-1.10.24/js/jquery.dataTables.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/DataTables-1.10.24/js/dataTables.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/DateTime-1.0.2/js/dataTables.dateTime.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/Buttons-1.7.0/js/dataTables.buttons.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/Buttons-1.7.0/js/buttons.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/Select-1.3.2/js/dataTables.select.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/Select-1.3.2/js/select.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/Editor-2.0.0/js/dataTables.editor.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
{!! Html::script('packages/Editor-2.0.0/js/editor.bootstrap4.'.(config('app.debug') ? '' : 'min.') . 'js') !!}
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
{!! Html::script('packages/FieldType-Select2-1.6.2/js/editor.select2.js') !!}
<!-- carers: Package Specific -->
{!! Html::script('js/packages/custom.editor.bootstrap.js') !!}
{{-- Global scripts --}}
<script src="{{ asset('js/main') }}/global.js"></script>
<!-- Timeout logic -->
{{-- Add page specific scripts --}}
@yield('scripts')
<script src="{{ asset('js/main') }}/post-load.js"></script>
