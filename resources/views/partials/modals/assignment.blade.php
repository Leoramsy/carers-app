<!-- Modal -->
<div id="assignment-modal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-dialog-centered" role="document"  style="max-width: 900px; width: 900px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-light">Assign Clients</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignment-form" class="mb-2" method="POST" action="{{ route('local.admin.access.users.assign') }}">
                    <div class="container">
                        {!! Form::hidden('user_id', 0, array('id' => 'user-id', 'class' => 'form-control input-original', 'readonly' => 'true')) !!}                        
                        <div class="row">
                            <select name="assignment-select[]" multiple="multiple" title="assignment-select[]">
                                @foreach($client_list AS $client)
                                <option value="{{$client->id}}">{{$client->id}} - {{ $client->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id='assignment-ok' type="submit" class="btn" form="assignment-form">Assign</button>
                <button id='assignment-cancel' type="button" class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

