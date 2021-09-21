<!-- Modal -->
<div id="legacy-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-light">Migrate Legacy Account</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="legacy-form" class="mb-2" method="POST" action="{{ route('link.legacy.account') }}">
                    <div id="step-1-form">
                        <div class="form-group row">
                            <div class="col-8 offset-2">
                                <h4 class="text-center">Current Login Details</h4>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="legacy_username" class="col-2 offset-2 col-form-label text-md-right">
                                Username:
                            </label>
                            <div class="col-6">
                                <input id="legacy-username" type="text" class="form-control @error('legacy_username') is-invalid @enderror" name="legacy_username"  placeholder="Legacy Username" value="" required autocomplete="username" autofocus>
                                @error('legacy_username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="legacy_password" class="col-2 offset-2 col-form-label text-md-right">
                                Password:
                            </label>
                            <div class="col-6">
                                <input id="legacy-password" type="password" class="form-control @error('legacy_password') is-invalid @enderror" name="legacy_password"  placeholder="Legacy Password" value="" required autocomplete="current-password">
                                @error('legacy_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id='legacy-ok' type="submit" class="btn" form="legacy-form">Verify Account</button>
                <button id='legacy-cancel' type="button" class="btn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>