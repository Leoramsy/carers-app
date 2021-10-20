@extends('layouts.app', ['page' => 'Clients' ,'page_slug' => 'client_details', 'category' => 'clients'])
@section('css_files')
{!! Html::style('css/wizard.css') !!}
@endsection
@section('js_files')
{!! Html::script('js/MomentJS-2.13.0/moment.min.js') !!}
{!! Html::script('js/wizard.js') !!} 
@include('clients.javascript.page.clients')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div  id="content" class="card">
            <div class="card-body">   

                <div class="col-md-12" style="padding: 0px">
                    <div class="col-md-4">
                        <b> {!! Form::label('client', 'Client:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('client', $clients, (!is_null($filters) ? $filters['client_id'] : key($clients)), array('id' => 'client-select', 'class' => 'form-control input-original', 'data-original' => key($clients))) !!}
                    </div> 
                    <div class="col-md-4">
                        <b>{!! Form::label('genders', 'Gender:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('genders', $genders, (!is_null($filters) ? $filters['gender_id'] : key($genders)), array('id' => 'genders-select', 'class' => 'form-control input-original', 'data-original' => key($genders))) !!}
                    </div>  
                    <div class="col-md-4">
                        <b>{!! Form::label('active', 'Active:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('active', $active, (!is_null($filters) ? $filters['active_id'] : key($active)), array('id' => 'active-select', 'class' => 'form-control input-original', 'data-original' => key($active))) !!}
                    </div>                      
                </div>             
            </div>
        </div>
        <div class="card"> 
            <div id="content" class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id='clients-table'  cellspacing='0' width='100%'>
                        <thead class="text-primary">                                
                            <tr>
                                <th>&nbsp;</th>                                
                                <th class='dt-cell-left'>Name</th>
                                <th class='dt-cell-left'>Surname</th>
                                <th class='dt-cell-left'>Gender</th>
                                <th class='dt-cell-left'>Phone Number</th>
                                <th class='dt-cell-left'>Address 1</th>
                                <th class='dt-cell-left'>Email </th>                                
                                <th class='dt-cell-left'>Accomodation Notes</th>                                
                                <th class='dt-cell-center'>Active</th>
                            </tr>                           
                        </thead>
                    </table> 
                    <!--
                    <div id="clients-editor" class="custom-editor">
                        <div id="client-details">
                            <section>
                                <div class="wizard editor-wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul id="wiz_nav_tab" class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active" style="border: none">
                                                <a class="tab-link" href="#company-tab" data-toggle="tab" aria-controls="company-tab" role="tab" title="Client Details">
                                                    <span class="round-tab">
                                                        <i class="fas fa-users"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li role="presentation" class="disabled" style="border: none">
                                                <a class="tab-link" href="#payment-tab" data-toggle="tab" aria-controls="payment-tab" role="tab" title="Payment Details">
                                                    <span class="round-tab">
                                                        <i class="far fa-credit-card"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li role="presentation" class="disabled" style="border: none">
                                                <a class="tab-link" href="#contact-tab" data-toggle="tab" aria-controls="contact-tab" role="tab" title="Contact Details">
                                                    <span class="round-tab">
                                                        <i class="far fa-address-book"></i>
                                                    </span>
                                                </a>
                                            </li>

                                            <li role="presentation" class="disabled" style="border: none">
                                                <a class="tab-link" href="#complete-tab" data-toggle="tab" aria-controls="complete-tab" role="tab" title="Complete">
                                                    <span class="round-tab">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <form role="form">
                                        <div class="tab-content">
                                            <div id="company-tab" class="tab-pane active" role="tabpanel">
                                                <fieldset class="wizard-navigation">
                                                    <div class="col-md-offset-3 col-md-6">
                                                        <legend style="text-align: center">Client Details</legend>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-primary next-step">Next</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.name"></editor-field>
                                                        <editor-field name="clients.code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.registered_name"></editor-field>
                                                        <editor-field name="clients.vat_number"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.registration_number"></editor-field>    
                                                        <editor-field name="clients.pastel_code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.active"></editor-field>
                                                        <editor-field name="clients.invoice_active"></editor-field>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div id="payment-tab" class="tab-pane" role="tabpanel">
                                                <fieldset class="wizard-navigation">
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-default prev-step">Back</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <legend style="text-align: center">Clients Notes</legend>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-primary next-step">Next</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set">                                                   
                                                    <div class="col-md-12">                                                            
                                                        <editor-field name="clients.gender_id"></editor-field>
                                                        <editor-field name="clients.deposit"></editor-field>
                                                    </div>                                                    
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.opening_balance"></editor-field>
                                                        <editor-field name="clients.opening_balance_date"></editor-field>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div id="contact-tab" class="tab-pane" role="tabpanel">
                                                <fieldset class="wizard-navigation">
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-default prev-step">Back</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <legend style="text-align: center">Next of Kin Details</legend>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-primary next-step">Next</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set" style="margin-bottom: 0px; padding-bottom: 0px;">
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.contact_person"></editor-field>
                                                        <editor-field name="clients.tel_no"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.email"></editor-field>
                                                        <editor-field name="clients.cell_no"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">                                                            
                                                        <editor-field name="clients.fax_no"></editor-field>
                                                    </div>
                                                </fieldset>
                                                <legend>Account Details</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.account_contact_person"></editor-field>
                                                        <editor-field name="clients.account_email"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.account_cc_email"></editor-field>                                                       
                                                    </div>
                                                </fieldset>
                                                <legend>Billing Address</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.billing_address_1"></editor-field>
                                                        <editor-field name="clients.billing_address_2"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="clients.billing_address_3"></editor-field>
                                                        <editor-field name="clients.billing_post_code"></editor-field>
                                                    </div>
                                                </fieldset>                                                
                                            </div>
                                            <div  id="complete-tab" class="tab-pane comlete-tab-pane" role="tabpanel">
                                                <fieldset class="wizard-navigation">
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-default prev-step">Back</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <legend style="text-align: center">Summary</legend>                                                        
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button id="editor-save-btn" type="button" class="btn btn-primary">Save</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set">
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Company Name: </label>
                                                            <span id="summary_clients_name" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Registered Name: </label>
                                                            <span id="summary_clients_registered_name" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>                                                            
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Company Code: </label>
                                                            <span id="summary_clients_code" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Payment Terms: </label>
                                                            <span id="summary_clients_gender_id" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">VAT Number: </label>
                                                            <span id="summary_clients_vat_number" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Invoice Active: </label>
                                                            <span id="summary_clients_invoice_active" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Reg Number: </label>
                                                            <span id="summary_clients_registration_number" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Pastel Code: </label>
                                                            <span id="summary_clients_pastel_code" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Opening Balance: </label>
                                                            <span id="summary_clients_opening_balance" class="summary_wizard_information">
                                                                <span class="input-mask input-mask-numeric"></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Opening Date: </label>
                                                            <span id="summary_clients_opening_balance_date" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Deposit: </label>
                                                            <span id="summary_clients_deposit" class="summary_wizard_information">
                                                                <span class="input-mask input-mask-numeric"></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Active: </label>
                                                            <span id="summary_clients_active" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                //<!-- CONTACT SUMMARY 
                                                <fieldset>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Contact: </label>
                                                            <span id="summary_clients_contact_person" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Tel No: </label>
                                                            <span id="summary_clients_tel_no" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Email: </label>
                                                            <span id="summary_clients_email" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Cell No: </label>
                                                            <span id="summary_clients_cell_no" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">                                                       
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Fax No: </label>
                                                            <span id="summary_clients_fax_no" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Acc Contact: </label>
                                                            <span id="summary_clients_account_contact_person" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>  
                                                    <div class="row_group">                                                       
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Acc Email: </label>
                                                            <span id="summary_clients_account_email" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Acc CC EMail: </label>
                                                            <span id="summary_clients_account_cc_email" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>  
                                                    <div class="row_group">                                                        
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Billing Address: </label>
                                                            <span>
                                                                <span id="summary_clients_billing_address_1" class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                                <span id="summary_clients_billing_address_2" class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                                <span id="summary_clients_billing_address_3" class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                                <span id="summary_clients_billing_post_code" class="summary_wizard_information">
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
                    </div> -->  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
