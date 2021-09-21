@if(Auth::user()->hasRole(\App\Models\MYSQL\Access\Role::CAPTURE))
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Monthly Invoice Value</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="invoice-schedules-value" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Monthly Invoice Count</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="invoice-schedules" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Monthly Credit Note Value</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="credit-note-schedules-value" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>    
<div class="col-12">
    <div class="card card-chart">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-6 text-left">                        
                    <h3 class="card-title">Monthly Credit Note Count</h3>
                </div>                    
            </div>
        </div>
        <div class="card-body">
            <div class="chart-area" style="height: 250px">
                <div id="credit-note-schedules" class="col-md-12"></div>
            </div>                               
        </div>
    </div>
</div>
@endif