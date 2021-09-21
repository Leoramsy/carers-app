{{-- include('partials/modals/feedback') --}}
<div id="overlay-container" class="contentOverlay" style="display: none;">
    
</div>
@include('partials/modals/legacy')
@include('partials/modals/session')
@can('super_admin')
@include('partials/modals/version')
@endcan
{{-- 
    The yield is here so that when a certain modal is needed on a specific page. 
    We can simply call (AT)section('modals') <HTML> (AT)endsection and it will place it here with all other modals 
--}}
@yield('modals')