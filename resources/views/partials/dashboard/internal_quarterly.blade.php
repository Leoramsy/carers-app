<div class="col-4">
    <div class="card card-chart" style="height: 380px">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-12 text-left">                        
                    <h3 class="card-title">Client Risk</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <div id="client-risk-pie" class="col-md-12"></div>
            </div>                
        </div>
    </div>
</div>
<div class="col-8">
    <div class="card card-chart" style="height: 380px">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Client Risk by Debtor</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body" style="padding-top: 0;">
            <div class="nav nav-tabs">
                <li  class="active"><a data-toggle="tab" href="#low-risk-tab">Low Risk</a></li>
                <li><a data-toggle="tab" href="#medium-risk-tab">Medium Risk</a></li>
                <li><a data-toggle="tab" href="#high-risk-tab">High Risk</a></li>
            </div>   
            <div class="tab-content" style="padding-top: 10px;">
                <div id="low-risk-tab" class="tab-pane fade in active">
                    @if (count($client_risk['table_dataset']['LOW']) > 0)
                    @foreach($client_risk['table_dataset']['LOW'] AS $debtor)
                    {!! Form::label('debtor_code', $debtor->debtor_code, ['class' => 'awesome col-md-1']) !!}
                    @endforeach
                    @else
                    {!! Form::label('debtor_code', 'No debtors found for this Risk Group', ['class' => 'awesome col-md-12 text-center']) !!}
                    @endif
                </div>
                <div id="medium-risk-tab" class="tab-pane fade">
                    @if (count($client_risk['table_dataset']['MEDIUM']) > 0)
                    @foreach($client_risk['table_dataset']['MEDIUM'] AS $debtor)
                    {!! Form::label('debtor_code', $debtor->debtor_code, ['class' => 'awesome col-md-1']) !!}
                    @endforeach
                    @else
                    {!! Form::label('debtor_code', 'No debtors found for this Risk Group', ['class' => 'awesome col-md-12 text-center']) !!}
                    @endif
                </div>
                <div id="high-risk-tab" class="tab-pane fade">
                    @if (count($client_risk['table_dataset']['HIGH']) > 0)
                    @foreach($client_risk['table_dataset']['HIGH'] AS $debtor)
                    {!! Form::label('debtor_code', $debtor->debtor_code, ['class' => 'awesome col-md-1']) !!}
                    @endforeach
                    @else
                    {!! Form::label('debtor_code', 'No debtors found for this Risk Group', ['class' => 'awesome col-md-12 text-center']) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-4">
    <div class="card card-chart" style="height: 380px">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-12 text-left">                        
                    <h3 class="card-title">Outstanding Debtor Balances</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <div id="outstanding-balances" class="col-md-12"></div>
            </div>                
        </div>
    </div>
</div>
<div class="col-8">
    <div class="card card-chart" style="height: 380px">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Outstanding Balances by Debtor</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="outstanding-debtor-balances" class="col-md-12"></div>
            </div>
            <div>
                <center>
                    {!! Form::button('Select All', array('id' => 'btn-all-debtors', 'class' => 'btn btn-style', 'style' => 'font-weight: normal; padding: 10px 10px;font-size: 12px;')) !!}
                    {!! Form::button('Select None', array('id' => 'btn-no-debtors', 'class' => 'btn btn-style', 'style' => 'font-weight: normal; padding: 10px 10px;font-size: 12px;')) !!}
                </center>
            </div>                
        </div>
    </div>
</div> 
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Moving Average Receipts</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="moving-average-receipts" class="col-md-12"></div>
            </div>                
        </div>
    </div>        
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Moving Average Sales</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="moving-average-sales" class="col-md-12"></div>
            </div>                
        </div>
    </div>        
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Client Quarterly Credit Note Percentage</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="quarterly-credit-notes-percentage" class="col-md-12"></div>
            </div>                
        </div>
    </div>        
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Quarterly Collect on Book</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="quarterly-book-collections" class="col-md-12"></div>
            </div>                
        </div>
    </div>        
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Quarterly Collect on Exposure</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="quarterly-exposure-collections" class="col-md-12"></div>
            </div>                
        </div>
    </div>        
</div>