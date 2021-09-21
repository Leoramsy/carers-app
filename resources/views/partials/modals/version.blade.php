<!-- Modal -->
<div id="version-modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 700px">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">carers Portal : Version {{(is_null($version) ? "-" : $version->system . '.' . $version->major . '.' . $version->minor)}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding-top: 10px; max-height: 500px; overflow-y: auto;">
                <div class="panel-group">
                    @foreach($versions AS $version)
                    <div class="new-panel new-panel-default" style="margin-bottom: 5px">
                        <div style="background-color: #f5f5f5;padding:5px;color:#1B75B9 !important;font-size:16px;font-weight:bold;letter-spacing:1px;word-spacing:3px;text-decoration:none;">
                            <h4 class="new-panel-title">
                                <a class="parent-version" data-toggle="collapse" href="#collapse-{{$version->id}}">
                                    <div class='row'>
                                        <div class='col-9'>
                                            <span class='mr-1'>
                                                @if(!is_null(auth()->user()->version_id) && $version->id > auth()->user()->version_id || is_null(auth()->user()->version_id) && $loop->first)
                                                <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                                                @else
                                                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                                @endif
                                            </span>
                                            Version: {{(is_null($version) ? "-" : $version->system . '.' . $version->major . '.' . $version->minor)}} @if(strlen($version->description) > 0) - @endif {{$version->description}} 
                                        </div>
                                        <div class='col-3 text-right'>
                                            <span class="version_date">({{$version->version_date->format('d/m/Y')}})</span>
                                        </div>
                                    </div>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-{{$version->id}}" class="panel-collapse collapse {{ !is_null(auth()->user()->version_id) && $version->id > auth()->user()->version_id || is_null(auth()->user()->version_id) && $loop->first ? 'show' : ''}}">
                            <ul class="list-group" style="color: #666666;margin-bottom: 0px">
                                <!-- <li class="list-group-item">One</li> -->
                                @foreach($version->versionEntries AS $version_entry)
                                <li class="child-version list-group-item" style=" padding: 5px 10px;"><i class="fa fa-circle" style="font-size: 6px; vertical-align: middle"aria-hidden="true"></i>  {{$version_entry->description}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button id="version_modal_submit" type="button" class="btn btn-default" data-dismiss="modal">Got it!</button>
                <button id="version_modal_close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
