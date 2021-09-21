@if(Auth::user()->hasRole(\App\Models\MYSQL\Access\Role::REPORTING))
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Monthly Sales vs Receipts</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="sales-vs-receipts" class="col-md-12"></div>
            </div>                
        </div>
    </div>        
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Monthly Sales vs Receipts per Debtor</h3>
                </div> 
                <div class="col-sm-6">                        
                    <div class="col-md-8" style="float: right;">
                        {!! Form::label('debtor_code', 'Debtor Code', ['class' => 'awesome', 'style' => 'font-weight: bold;']) !!}
                        <select id="debtor-select">
                            @foreach($debtor_list AS $debtor)
                            <option value="{{$debtor->id}}">{{ $debtor->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="sales-vs-receipts-per-debtor" class="col-md-12"></div>
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
                    <h3 class="card-title">Days Outstanding Receipts</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="outstanding-receipts" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Days Outstanding Sales</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="outstanding-sales" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Client Monthly Credit Note Percentage</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="credit-notes-percentage" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>
@endif