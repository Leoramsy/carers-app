<!-- Modal -->
<div id="credit-comments-modal" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-dialog-centered" role="document"  style="max-width: 900px; width: 900px">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-light">Schedule <span id="credit-schedule-header"></span> Comments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="credit-comments-form" class="mb-2">
                        <div class="col-md-12">                          
                            {!! Form::hidden('credit_schedule_id', 0, array('id' => 'credit-schedule-id', 'class' => 'form-control input-original', 'readonly' => 'true')) !!}  
                            <div id="comments_detail" style="display: none; max-height: 400px;  overflow: auto;">
                            </div>
                            <div id="comments-placeholder" style="display: none">                            
                                <!-- LOADING ICON -->
                                <div class="col-md-3 offset-md-5" style="padding-left: 0px;">                                
                                    <i class="fa fa-spinner fa-spin fa-3x fa-fw" style="text-align: center; font-size: 80px"></i>
                                </div>
                                <div class="col-md-12 text-center">
                                    <span>Loading comments, please wait...</span>                                
                                </div>
                            </div> 
                            <div id="no-comments" style="display: none">                            
                                <!-- LOADING ICON -->
                                <div class="col-md-3 offset-md-5" style="padding-left: 0px;">                                
                                    <i class="fas fa-comment-slash" style="text-align: center; font-size: 80px"></i>
                                </div>
                                <div class="col-md-12 text-center">
                                    <span>No comments to display</span>                                
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-top: 10px">  
                            <span id="comments-count" style="display: none; float: right;font-size: 11px;">0 Comments</span>
                            @can('schedule_updates')
                            <textarea class="form-control  input-original" id="comment-box" cols="50" rows="10" placeholder="Type in a comment here..."></textarea>                     
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer col-md-12">
                <div class="col-md-10" style="padding-left: 35px;">
                    @can('schedule_updates')<button id='credit-comments-add' class="btn" style="float: left">Add Comment</button>@endcan
                    <button id='credit-comments-refresh'  class="btn" style="float: left">Refresh</button>         
                </div>
                <div class="col-md-2" style="padding-right: 30px;">
                    <button id='credit-comments-cancel' type="button" class="btn" data-dismiss="modal" style="float: right">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

