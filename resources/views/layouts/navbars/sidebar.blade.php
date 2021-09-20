<div class="sidebar">
    <div class="sidebar-wrapper ps ps--active-x">
        <div class="logo">
            <a  href="/"><img src="/images/mfactors_white_logo.png" class="simple-text logo-normal"></a>            
        </div>
        <ul  id="accordion" class="nav">   
           
            <li class="{{ ($page_slug ?? ' ') == 'schedules' ? 'active' : ''}}">
                <a href="{{ route('home') }}" aria-expanded="false" aria-controls="balances">
                    <i class="fas fa-balance-scale"></i>
                    <p class="sidebar-category">
                      Schedules
                    </p>
                </a>
            </li>
            
            
            <li class="{{ ($category ?? ' ') == 'visits' ? 'active' : ''}}">
                <a href="{{ route('home') }}" aria-expanded="false" aria-controls="reports">
                    <i class="fas fa-chart-line"></i>
                    <p class="sidebar-category">
                        Visits
                    </p>
                </a>
            </li>
            
            <li class="{{ ($page_slug ?? ' ') == 'clients' ? 'active' : ''}}">
                <a href="{{ route('home') }}" aria-expanded="false" aria-controls="invoices">
                    <i class="fas fa-receipt"></i>
                    <p class="sidebar-category">
                        Clients
                    </p>
                </a>
            </li>
            
            <li class="{{ ($page_slug ?? ' ') == 'carers' ? 'active' : ''}}">
                <a href="{{ route('home') }}" aria-expanded="false" aria-controls="credit_notes">
                    <i class="far fa-credit-card"></i>
                    <p class="sidebar-category">
                       Carers
                    </p>
                </a>
            </li>
            
            <li class="{{ ($page_slug ?? ' ') == 'invoices' ? 'active' : ''}}">
                <a href="{{ route('home') }}" aria-expanded="false" aria-controls="invoices">
                    <i class="fas fa-receipt"></i>
                    <p class="sidebar-category">
                        Invoices
                    </p>
                </a>
            </li>
            
            <li class="{{ ($page_slug ?? ' ') == 'payments' ? 'active' : ''}}">
                <a href="{{ route('home') }}" aria-expanded="false" aria-controls="credit_notes">
                    <i class="far fa-credit-card"></i>
                    <p class="sidebar-category">
                       Payments
                    </p>
                </a>
            </li>
            
            <li class="{{ ($category ?? ' ') == 'admin' ? 'active' : ''}}">
                <a data-toggle="collapse" href="#admin" aria-expanded="false" aria-controls="admin">
                    <i class="fas fa-sliders-h"></i>
                    <p class="sidebar-category">
                        Admin
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse {{ ($category ?? ' ') == 'admin' ? 'show' : ''}}" id="admin">
                    <ul class="nav">  
                        
                        <li class="{{ ($page_slug ?? ' ') == 'compliance' ? 'active' : ''}}"> 
                            <a href="{{ route('home') }}" title="Compliance">
                                <span class="sidebar-mini-icon">Com</span>
                                <span class="sidebar-normal">Compliance</span>
                            </a>
                        </li>
                        
                        <li class="{{ ($page_slug ?? ' ') == 'services' ? 'active' : ''}}">
                            <a href="{{ route('home') }}" title="Services">
                                <span class="sidebar-mini-icon">SER</span>
                                <span class="sidebar-normal">Services</span>
                            </a>
                        </li>
                        
                        <li class="{{ ($page_slug ?? ' ') == 'settings' ? 'active' : ''}}">
                            <a href="{{ route('home') }}" title="Settings">
                                <span class="sidebar-mini-icon">SER</span>
                                <span class="sidebar-normal">Settings</span>
                            </a>                          
                        </li> 
                        
                        <li class="{{ ($page_slug ?? ' ') == 'admin_settings' ? 'active' : ''}}">
                            <a href="{{ route('home') }}" title="Settings">
                                <span class="sidebar-mini-icon">Set</span>
                                <span class="sidebar-normal">Settings</span>
                            </a>                          
                        </li>   
                        
                        <li class="{{ ($page_slug ?? ' ') == 'access' ? 'active' : ''}}">
                            <a href="{{ route('home') }}" title="Users">
                                <span class="sidebar-mini-icon">Use</span>
                                <span class="sidebar-normal">Users</span>
                            </a>                          
                        </li>
                        
                    </ul>
                </div>
            </li>
            
        </ul>
    </div>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
        </div>
    </div>
    <div class="ps__rail-y" style="top: 0px; height: 879px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 840px;">
        </div>
    </div>
</div>

