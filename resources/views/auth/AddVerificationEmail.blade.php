<?= $header ?>
<input type="hidden" id="setting_otp_code_time" value="<?php echo $setting[0]['otp_time']; ?>">
<input type="hidden" id="txtLoginDataUserID" value="{{ Session::get('before_session_userid') }}">
<input type="hidden" id="txtLoginDataUserName" value="{{ Session::get('before_session_username') }}">
<input type="hidden" id="txtLoginDataFn_ID" value="{{ Session::get('before_session_fn_id') }}">
<div class="row">
    <div class="col">
        <img class="" src="<?= URL('assets/img/dm.png') ?>" alt="">
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="http://digitalmanager.pk/" target="_blank" class="h1"><b>Digital</b>Manager</a>
                    <br />
                    <a href="#" class="h4">Business Management Software</a>
                </div>
                <div class="card-body">
                    <h4 class="login-box-msg font-weight-bold"> <small class="Code_will_be_expire_after"> <span
                                class="text_otp font-weight-bold"> Code will be expire after </span>
                            <span class="timer hide"><?php $min = Session::get('last_activity') + 60 * $setting[0]['otp_time'] - time();
                            echo "<span class='min'>" . date('i', $min) . '</span>' . ' : ' . "<span class='secs'>" . date('s', $min) . '</span>';
                            ?>
                    </h4>

                    <form id="kt_login_signin_form" action="" class="kt_login_signin_form" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 class="text-center">Enter Verification Code</h3>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-center inputs save-elem"
                                                        autofocus maxlength="1" />
                                                    <input type="text" class="form-control text-center inputs save-elem"
                                                        maxlength="1" />
                                                    <input type="text" class="form-control text-center inputs save-elem"
                                                        maxlength="1" />
                                                    <input type="text" class="form-control text-center inputs save-elem"
                                                        data-last="true" maxlength="1" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <div id="progressBardefult" style="display: none;">
                                    <div id="progressBar1">
                                    </div>
                                    <div id="progress1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <a class="btn btn-primary btnMobCode" id="kt_login_signin_submit" tabindex="320000"><i
                                        class="fa fa-user"></i> Login </span><span
                                        class="fas fa-spinner d-none"></span></a>
                            </div>
                            <div class="col">
                                <a class="btn btn-primary kt_login_resendotp_submit float-right"
                                    id="kt_login_resendotp_submit" tabindex="320000"> <i class="fa fa-refresh"></i>
                                    Resend</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<!-- /.login-box -->
<?= $footer ?>
