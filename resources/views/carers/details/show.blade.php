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
                                <th class='dt-cell-center'>Active</th>
                                <th class='dt-cell-center'>Image</th>
                            </tr>
                            </thead>
                        </table>
                        <div id="carers-editor" class="custom-editor">
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
                                                        <i class="fas fa-map-marked-alt"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li role="presentation" class="disabled" style="border: none">
                                                <a class="tab-link" href="#relationship-tab" data-toggle="tab"
                                                   aria-controls="relationship-tab" role="tab" title="Next of Kin">
                                                    <span class="round-tab">
                                                        <i class="fas fa-heartbeat"></i>
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
                                                        <editor-field name="carers.institution_id"></editor-field>
                                                        <editor-field name="carers.student_number"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.student_type_id"></editor-field>
                                                        <editor-field name="carers.initials"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.title_id"></editor-field>
                                                        <editor-field name="carers.name"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.middle_name"></editor-field>
                                                        <editor-field name="carers.surname"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.date_registered"></editor-field>
                                                        <editor-field name="carers.date_of_birth"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.gender_id"></editor-field>
                                                        <editor-field name="carers.equity_id"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.nationality_id"></editor-field>
                                                        <editor-field
                                                            name="carers.resident_status_id"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.language_id"></editor-field>
                                                        <editor-field name="carers.socio_status_id"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.active"></editor-field>
                                                        <editor-field name="carers.id_type"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.id_number"></editor-field>
                                                        <editor-field
                                                            name="carers.identification_type_id"></editor-field>
                                                        <editor-field
                                                            name="carers.alternative_id_number"></editor-field>
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
                                                        <editor-field name="carers.telephone_number"></editor-field>
                                                        <editor-field name="carers.cell_number"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.fax_number"></editor-field>
                                                        <editor-field name="carers.email"></editor-field>
                                                    </div>
                                                </fieldset>
                                                <legend>Home Address</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.home_address_1"></editor-field>
                                                        <editor-field name="carers.home_address_2"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.home_address_3"></editor-field>
                                                        <editor-field name="carers.home_post_code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field
                                                            name="carers.home_municipality_id"></editor-field>
                                                        <editor-field name="carers.home_province_id"></editor-field>
                                                    </div>
                                                </fieldset>
                                                <legend>Postal Address</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.postal_address_1"></editor-field>
                                                        <editor-field name="carers.postal_address_2"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.postal_address_3"></editor-field>
                                                        <editor-field name="carers.postal_post_code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field
                                                            name="carers.postal_municipality_id"></editor-field>
                                                        <editor-field
                                                            name="carers.postal_province_id"></editor-field>
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
                                                        <editor-field name="carers.telephone_number"></editor-field>
                                                        <editor-field name="carers.cell_number"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.fax_number"></editor-field>
                                                        <editor-field name="carers.email"></editor-field>
                                                    </div>
                                                </fieldset>
                                                <legend>Home Address</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.home_address_1"></editor-field>
                                                        <editor-field name="carers.home_address_2"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.home_address_3"></editor-field>
                                                        <editor-field name="carers.home_post_code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field
                                                            name="carers.home_municipality_id"></editor-field>
                                                        <editor-field name="carers.home_province_id"></editor-field>
                                                    </div>
                                                </fieldset>
                                                <legend>Postal Address</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.postal_address_1"></editor-field>
                                                        <editor-field name="carers.postal_address_2"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.postal_address_3"></editor-field>
                                                        <editor-field name="carers.postal_post_code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field
                                                            name="carers.postal_municipality_id"></editor-field>
                                                        <editor-field
                                                            name="carers.postal_province_id"></editor-field>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div id="relationship-tab" class="tab-pane" role="tabpanel">
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
                                                        <button id="editor-save-btn" type="button"
                                                                class="btn btn-primary">Save
                                                        </button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.seeing_id"></editor-field>
                                                        <editor-field name="carers.hearing_id"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.communicating_id"></editor-field>
                                                        <editor-field name="carers.walking_id"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="carers.remembering_id"></editor-field>
                                                        <editor-field name="carers.selfcare_id"></editor-field>
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
@endsection
