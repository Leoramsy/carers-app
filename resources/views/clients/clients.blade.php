@extends('layouts.client', ['page' => 'Customers' ,'page_slug' => 'details', 'category' => 'customers'])
@section('css_files')
{!! Html::style('css/wizard.css') !!}
@endsection
@section('js_files')
{!! Html::script('js/MomentJS-2.13.0/moment.min.js') !!}
{!! Html::script('js/wizard.js') !!} 
@include('staff.javascript.customer.customers')
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 ">
        <div  id="content" class="card">
            <div class="card-body">   

                <div class="col-md-12" style="padding: 0px">
                    <div class="col-md-4">
                        <b> {!! Form::label('customer', 'Customer:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('customer', $customers, (!is_null($filters) ? $filters['customer_id'] : key($customers)), array('id' => 'customer-select', 'class' => 'form-control input-original', 'data-original' => key($customers))) !!}
                    </div> 
                    <div class="col-md-4">
                        <b>{!! Form::label('payment_terms', 'Terms:', ['class' => 'awesome']) !!}</b>
                        {!! Form::select('payment_terms', $terms, (!is_null($filters) ? $filters['payment_term_id'] : key($terms)), array('id' => 'payment-terms-select', 'class' => 'form-control input-original', 'data-original' => key($terms))) !!}
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
                    <table class="table table-striped" id='customers-table'  cellspacing='0' width='100%'>
                        <thead class="text-primary">                                
                            <tr>
                                <th>&nbsp;</th>
                                <th class='dt-cell-left'>Code</th>
                                <th class='dt-cell-left'>Name</th>
                                <th class='dt-cell-left'>Registered Name</th>
                                <th class='dt-cell-left'>Contact Person</th>
                                <th class='dt-cell-left'>Email</th>
                                <th class='dt-cell-left'>Tel No</th>
                                <th class='dt-cell-left'>Mobile No</th>                                
                                <th class='dt-cell-left'>Terms</th>
                                <th class='dt-cell-center'>Vattable</th>
                                <th class='dt-cell-center'>Active</th>
                            </tr>                           
                        </thead>
                    </table>                    
                    <div id="customers-editor" class="custom-editor">
                        <div id="customer-details">
                            <section>
                                <div class="wizard editor-wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul id="wiz_nav_tab" class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active" style="border: none">
                                                <a class="tab-link" href="#company-tab" data-toggle="tab" aria-controls="company-tab" role="tab" title="Customer Details">
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
                                                        <legend style="text-align: center">Customer Details</legend>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-primary next-step">Next</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.name"></editor-field>
                                                        <editor-field name="customers.code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.registered_name"></editor-field>
                                                        <editor-field name="customers.vat_number"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.registration_number"></editor-field>    
                                                        <editor-field name="customers.pastel_code"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.active"></editor-field>
                                                        <editor-field name="customers.invoice_active"></editor-field>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div id="payment-tab" class="tab-pane" role="tabpanel">
                                                <fieldset class="wizard-navigation">
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-default prev-step">Back</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <legend style="text-align: center">Payment Details</legend>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-primary next-step">Next</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set">                                                   
                                                    <div class="col-md-12">                                                            
                                                        <editor-field name="customers.payment_term_id"></editor-field>
                                                        <editor-field name="customers.deposit"></editor-field>
                                                    </div>                                                    
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.opening_balance"></editor-field>
                                                        <editor-field name="customers.opening_balance_date"></editor-field>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div id="contact-tab" class="tab-pane" role="tabpanel">
                                                <fieldset class="wizard-navigation">
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-default prev-step">Back</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <legend style="text-align: center">Contact Details</legend>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button" class="btn btn-primary next-step">Next</button>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="half-set multi-set" style="margin-bottom: 0px; padding-bottom: 0px;">
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.contact_person"></editor-field>
                                                        <editor-field name="customers.tel_no"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.email"></editor-field>
                                                        <editor-field name="customers.cell_no"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">                                                            
                                                        <editor-field name="customers.fax_no"></editor-field>
                                                    </div>
                                                </fieldset>
                                                <legend>Account Details</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.account_contact_person"></editor-field>
                                                        <editor-field name="customers.account_email"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.account_cc_email"></editor-field>                                                       
                                                    </div>
                                                </fieldset>
                                                <legend>Billing Address</legend>
                                                <fieldset class="half-set multi-set">
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.billing_address_1"></editor-field>
                                                        <editor-field name="customers.billing_address_2"></editor-field>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <editor-field name="customers.billing_address_3"></editor-field>
                                                        <editor-field name="customers.billing_post_code"></editor-field>
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
                                                            <span id="summary_customers_name" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Registered Name: </label>
                                                            <span id="summary_customers_registered_name" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>                                                            
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Company Code: </label>
                                                            <span id="summary_customers_code" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Payment Terms: </label>
                                                            <span id="summary_customers_payment_term_id" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">VAT Number: </label>
                                                            <span id="summary_customers_vat_number" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Invoice Active: </label>
                                                            <span id="summary_customers_invoice_active" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Reg Number: </label>
                                                            <span id="summary_customers_registration_number" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Pastel Code: </label>
                                                            <span id="summary_customers_pastel_code" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>                                                    
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Opening Balance: </label>
                                                            <span id="summary_customers_opening_balance" class="summary_wizard_information">
                                                                <span class="input-mask input-mask-numeric"></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Opening Date: </label>
                                                            <span id="summary_customers_opening_balance_date" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Deposit: </label>
                                                            <span id="summary_customers_deposit" class="summary_wizard_information">
                                                                <span class="input-mask input-mask-numeric"></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Active: </label>
                                                            <span id="summary_customers_active" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <!-- CONTACT SUMMARY -->
                                                <fieldset>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Contact: </label>
                                                            <span id="summary_customers_contact_person" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Tel No: </label>
                                                            <span id="summary_customers_tel_no" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Email: </label>
                                                            <span id="summary_customers_email" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Cell No: </label>
                                                            <span id="summary_customers_cell_no" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row_group">                                                       
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Fax No: </label>
                                                            <span id="summary_customers_fax_no" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Acc Contact: </label>
                                                            <span id="summary_customers_account_contact_person" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>  
                                                    <div class="row_group">                                                       
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Acc Email: </label>
                                                            <span id="summary_customers_account_email" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Acc CC EMail: </label>
                                                            <span id="summary_customers_account_cc_email" class="summary_wizard_information">
                                                                <span></span>
                                                            </span>
                                                        </div>
                                                    </div>  
                                                    <div class="row_group">                                                        
                                                        <div class="col-md-6">
                                                            <label class="col-lg-4">Billing Address: </label>
                                                            <span>
                                                                <span id="summary_customers_billing_address_1" class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                                <span id="summary_customers_billing_address_2" class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                                <span id="summary_customers_billing_address_3" class="summary_wizard_information">
                                                                    <span></span>
                                                                </span>
                                                                <span id="summary_customers_billing_post_code" class="summary_wizard_information">
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
