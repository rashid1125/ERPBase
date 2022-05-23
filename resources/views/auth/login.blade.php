<?= $header ?>
<div class="row">
    <div class="col">
        <img class="" src="<?= URL('assets/img/dm.png') ?>" alt="">
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="container login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="http://digitalmanager.pk/" target="_blank" class="h1"><b>Digital</b>Manager</a>
                    <a href="#" class="h4">Business Management Software</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form id="login_form" action="" class="" method="post">
                        <div class="form-group mb-3">
                            <select class="form-control select2" data-toggle="tooltip" title="Please Choose Current Financial Year!"  id="txtfinancialyear">
                                <option value="" disabled selected>Current Financialyear</option>
                                @foreach ($financialyears as $financialyear)
                                    <option value="{{ $financialyear->financialyear_id }}">{{ $financialyear->financialyear_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="User Name" data-toggle="tooltip"
                                title="Please Type User Name!" id="txtUsername" autocomplete>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="User Password"
                                data-toggle="tooltip" title="Please Type User Password!" id="txtPassowrd" autocomplete>
                            <div class="input-group-append glyphicon22-eye-open2">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <!-- /.col -->
                            <div class="col">
                                <a class="btn btn-primary btn-block btnSignin" disabled><i
                                        class="fas fa-sign-in-alt"></i> Sign In</a>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <div class="row mt-2 d-none">
                        <div class="col">
                            <p class="mb-1">
                                <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#modal-default">
                                    I forgot my password
                                </button>
                            </p>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- /.login-box -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Forget Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- /.login-logo -->
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <a href="http://digitalmanager.pk/" target="_blank"
                                class="h1"><b>Digital</b>Manager</a>
                            <br>
                            <a href="#" class="h4">Business Management Software</a>
                        </div>
                        <div class="card-body">
                            <p class="login-box-msg">Sign in to start your session</p>

                            <form id="login_form" action="" class="" method="post">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="User Email"
                                        data-toggle="tooltip" title="Please Type User E-Mail!" id="txtEmail">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col">
                                        <a class="btn btn-primary btn-block btnResetPassword">Reset Password</a>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?= $footer ?>
