@extends('layouts.app', ['page_slug' => 'clients', 'category' => 'clients', 'page' => 'Client Details'])
@section('css_files')
    {!! Html::style('css/wizard.css') !!}
@endsection
@section('scripts')
    {!! Html::script('js/wizard.js') !!}
    @include('clients/javascript/editor/details')
    @include('clients/javascript/datatables/details')
    @include('clients/javascript/page/details')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="clients-table" class="table table-striped table-sm dataTable no-footer" width="100%">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class='dt-cell-left'>Name</th>
                                <th class='dt-cell-left'>Surname</th>
                                <th class='dt-cell-left'>Email</th>
                                <th class='dt-cell-center'>Active</th>
                                <th class='dt-cell-center'>Image</th>
                            </tr>
                            </thead>
                        </table>
                        <div id="clients-editor" class="custom-editor" style="display: block">
                            <div id="clients-wizard">
                                <section>
                                    <div class="wizard editor-wizard">
                                        <div class="wizard-inner">
                                            <div class="connecting-line"></div>
                                            <ul id="wiz_nav_tab" class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active" style="border: none">
                                                    <a class="tab-link" href="#details-tab" data-toggle="tab"
                                                       aria-controls="details-tab" role="tab" title="Client Details">
                                                    <span class="round-tab">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    </a>
                                                </li>
                                                <li role="presentation" class="disabled" style="border: none">
                                                    <a class="tab-link" href="#access-tab" data-toggle="tab"
                                                       aria-controls="access-tab" role="tab" title="Login Details">
                                                    <span class="round-tab">
                                                        <i class="fas fa-unlock-alt"></i>
                                                    </span>
                                                    </a>
                                                </li>
                                                <li role="presentation" class="disabled" style="border: none">
                                                    <a class="tab-link" href="#address-tab" data-toggle="tab"
                                                       aria-controls="address-tab" role="tab" title="Address Details">
                                                    <span class="round-tab">
                                                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                                    </span>
                                                    </a>
                                                </li>
                                                <li role="presentation" class="disabled" style="border: none">
                                                    <a class="tab-link" href="#complete-tab" data-toggle="tab"
                                                       aria-controls="complete-tab" role="tab" title="Complete">
                                                    <span class="round-tab">
                                                        <i class="far fa-check-circle"></i>
                                                    </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <form role="form">
                                            <div class="tab-content">
                                                <div id="details-tab" class="tab-pane active" role="tabpanel">
                                                    <fieldset class="wizard-navigation row">
                                                        <div class="col-md-3">
                                                            &nbsp;
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend style="text-align: center">Client Details</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary next-step">
                                                                Next
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.name"></editor-field>
                                                            <editor-field name="clients.surname"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.gender_id"></editor-field>
                                                            <editor-field
                                                                name="clients.date_of_birth"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="clients.employee_number"></editor-field>
                                                            <editor-field
                                                                name="clients.health_care_number"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="clients.start_date"></editor-field>
                                                            <editor-field name="clients.end_date"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.active"></editor-field>
                                                            <editor-field name="clients.phone_number"></editor-field>
                                                        </div>   
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.username"></editor-field>
                                                            <editor-field name="clients.email"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.password"></editor-field>
                                                            <editor-field name="clients.password_confirmation"></editor-field>
                                                        </div>
                                                    </fieldset>  
                                                </div>
                                                <div id="access-tab" class="tab-pane" role="tabpanel">
                                                    <fieldset class="wizard-navigation row">
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-default prev-step">
                                                                Back
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend style="text-align: center">Contact Details</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary next-step">
                                                                Next
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.address_1"></editor-field>
                                                            <editor-field name="clients.address_2"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.city"></editor-field>
                                                            <editor-field name="clients.county"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.post_code"></editor-field>
                                                            <editor-field name="clients.phone_1"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">                                                            
                                                            <editor-field name="clients.phone_2"></editor-field>
                                                            <editor-field name="clients.image"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">                                                            
                                                            <editor-field name="clients.access_to_home"></editor-field>
                                                            <editor-field name="clients.door_code"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">                                                            
                                                            <editor-field name="clients.general_notes"></editor-field>
                                                            <editor-field name="clients.accomodation_notes"></editor-field>
                                                        </div>
                                                    </fieldset>                                                   
                                                </div>
                                                <div id="address-tab" class="tab-pane" role="tabpanel">
                                                    <fieldset class="wizard-navigation row">
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-default prev-step">
                                                                Back
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend style="text-align: center">Next of Kin</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary next-step">
                                                                Next
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.address_1"></editor-field>
                                                            <editor-field name="clients.address_2"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.address_3"></editor-field>
                                                            <editor-field name="clients.county"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="clients.post_code"></editor-field>
                                                        </div>
                                                    </fieldset>
                                                    <legend>Next of Kin</legend>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="clients.next_of_kin"></editor-field>
                                                            <editor-field
                                                                name="clients.next_of_kin_relationship"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="clients.next_of_kin_phone"></editor-field>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="complete-tab" class="tab-pane" role="tabpanel">
                                                    <fieldset class="wizard-navigation row">
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-default prev-step">
                                                                Back
                                                            </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <legend style="text-align: center">Summary</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button id="details-save-btn" type="button"
                                                                    class="btn btn-primary">Save
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="row_group">
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Name: </label>
                                                                <span id="summary_clients_name"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Surname: </label>
                                                                <span id="summary_clients_surname"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row_group">
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Username: </label>
                                                                <span id="summary_clients_username"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Email: </label>
                                                                <span id="summary_clients_email"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row_group">
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Address: </label>
                                                                <span>
                                                                    <span id="summary_clients_address_1"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                    <span id="summary_clients_address_2"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                    <span id="summary_clients_address_3"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                    <span id="summary_clients_post_code"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                <span id="summary_clients_county"
                                                                      class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
