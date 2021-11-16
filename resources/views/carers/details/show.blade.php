@extends('layouts.app', ['page_slug' => 'carers', 'category' => 'carers', 'page' => 'Carer Details'])
@section('css_files')
    {!! Html::style('css/wizard.css') !!}
@endsection
@section('scripts')
    {!! Html::script('js/wizard.js') !!}
    @include('carers/javascript/editor/details')
    @include('carers/javascript/datatables/details')
    @include('carers/javascript/page/details')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="carers-table" class="table table-striped table-sm dataTable no-footer" width="100%">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class='dt-cell-left'>Name</th>
                                <th class='dt-cell-left'>Surname</th>
                                <th class='dt-cell-left'>Email</th>
                                <th class='dt-cell-left'>Username</th>
                                <th class='dt-cell-left'>Address</th>
                                <th class='dt-cell-center'>Active</th>
                            </tr>
                            </thead>
                        </table>
                        <div id="carers-editor" class="custom-editor" style="display: block">
                            <div id="carers-wizard">
                                <section>
                                    <div class="wizard editor-wizard">
                                        <div class="wizard-inner">
                                            <div class="connecting-line"></div>
                                            <ul id="wiz_nav_tab" class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active" style="border: none">
                                                    <a class="tab-link" href="#details-tab" data-toggle="tab"
                                                       aria-controls="details-tab" role="tab" title="Carer Details">
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
                                                            <legend style="text-align: center">Carer Details</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary next-step">
                                                                Next
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="carers.name"></editor-field>
                                                            <editor-field name="carers.surname"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="carer_details.gender_id"></editor-field>
                                                            <editor-field
                                                                name="carer_details.date_of_birth"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="carer_details.employee_number"></editor-field>
                                                            <editor-field
                                                                name="carer_details.health_care_number"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="carer_details.start_date"></editor-field>
                                                            <editor-field name="carer_details.end_date"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="carers.active"></editor-field>
                                                            <editor-field name="carer_details.phone_number"></editor-field>
                                                        </div>
                                                        <!--
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="carers.image"></editor-field>
                                                        </div>
                                                        -->
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
                                                            <legend style="text-align: center">Login Details</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary next-step">
                                                                Next
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="carers.username"></editor-field>
                                                            <editor-field name="carers.email"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="carers.password"></editor-field>
                                                            <editor-field
                                                                name="carers.password_confirmation"></editor-field>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="full-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="carer_roles[].role_id"></editor-field>
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
                                                            <legend style="text-align: center">Address Details</legend>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="button" class="btn btn-primary next-step">
                                                                Next
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field name="carer_details.address_1"></editor-field>
                                                            <editor-field name="carer_details.address_2"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="carer_details.address_3"></editor-field>
                                                            <editor-field name="carer_details.county"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field name="carer_details.post_code"></editor-field>
                                                        </div>
                                                    </fieldset>
                                                    <legend>Next of Kin</legend>
                                                    <fieldset class="half-set multi-set">
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="carer_details.next_of_kin"></editor-field>
                                                            <editor-field
                                                                name="carer_details.next_of_kin_relationship"></editor-field>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <editor-field
                                                                name="carer_details.next_of_kin_phone"></editor-field>
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
                                                                <span id="summary_carers_name"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Surname: </label>
                                                                <span id="summary_carers_surname"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row_group">
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Username: </label>
                                                                <span id="summary_carers_username"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Email: </label>
                                                                <span id="summary_carers_email"
                                                                      class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="row_group">
                                                            <div class="col-md-6">
                                                                <label class="col-lg-4">Address: </label>
                                                                <span>
                                                                    <span id="summary_carer_details_address_1"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                    <span id="summary_carer_details_address_2"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                    <span id="summary_carer_details_address_3"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                    <span id="summary_carer_details_post_code"
                                                                          class="summary_wizard_information">
                                                                        <span></span>
                                                                    </span>
                                                                <span id="summary_carer_details_county"
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
