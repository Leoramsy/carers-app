<!-- Modal -->
<div id="session-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Session Timeout</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>                
            </div>
            <div class="modal-body">
                <div id='clock-display' style="display: none">
                    <h2>Your session is about to time out...</h2>
                    <div class="hero-circle">
                        <div class="hero-display">
                            <h2 id="clock-value"></h2>
                        </div>
                    </div>
                </div>
                <div id='error-display' style="display: none">
                    <p>
                        Your session has expired. You will be automatically redirected to the login page in 5 seconds. Alternatively you can <a href="{{route('login')}}">click here</a> to login again
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <div id='clock-controls' style="display: none">
                    <a id='session-refresh' role="submit" class="btn" onclick="refreshSession()" data-dismiss="modal" style="color: white;">Stay</a>
                    <a id='session-logout' role="submit" class="btn" onclick="document.getElementById('logout-form').submit();" style="color: white;">Logout</a>                
                </div>
                <div id='error-controls' style="display: none">
                    <a id='session-login' role="submit" class="btn" onclick="document.getElementById('logout-form').submit();" style="color: white;">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

