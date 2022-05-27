<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                {{ $title }}
                            </h3>
                            <div class="card-tools">
                                <?php $dataentry = '';
                                $viewall = '';
                                if ((int) ($setting_configur[0]['defination_behaviour'] = 2)) {
                                    $dataentry = 'active';
                                } else {
                                    $viewall = 'active';
                                } ?>
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $dataentry }}" href="#AddUser"
                                            data-toggle="tab" id="txtUpdateOrInsert"></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $viewall }}" href="#ViewAll" data-toggle="tab"
                                            id="txtViewAllQuery">View All</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane {{ $dataentry }}" id="AddUser">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                            <form class="form-group" id="txtUserForm" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col d-none">
                                                        <input id="txtUserID" class="form-control save-elem" type="text"
                                                            name="uid">
                                                        <input id="txtUserDate"
                                                            class="form-control datepicker validate-save save-elem date-reset"
                                                            type="text" name="date">
                                                        <input id="vouchertypehidden" class="form-control"
                                                            type="hidden" value="new">
                                                    </div>
                                                </div>

                                                <div class="row mt-0">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Login Information
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row mt-0">
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserName">User Name</label>
                                                                            <span class="asterisk">&#42;</span>
                                                                            <input id="txtUserName"
                                                                                class="form-control reset-elem save-elem"
                                                                                type="text" name="uname"
                                                                                data-toggle="tooltip"
                                                                                title="Please enter User Name...!!!"
                                                                                value="{{ old('uname') }}">
                                                                            @if ($errors->has('uname'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('uname') }}
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserFullName">Full
                                                                                Name</label>
                                                                            <span class="asterisk">&#42;</span>
                                                                            <input id="txtUserFullName"
                                                                                class="form-control reset-elem save-elem"
                                                                                type="text" name="fullname"
                                                                                data-toggle="tooltip"
                                                                                title="Please enter Full Name...!!!">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserEmail">E-Mail</label>
                                                                            <span class="asterisk">&#42;</span>
                                                                            <input id="txtUserEmail"
                                                                                class="form-control reset-elem save-elem"
                                                                                type="text" name="email"
                                                                                data-toggle="tooltip"
                                                                                title="Please enter E-Mail...!!!">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserMobile">Mobile</label>
                                                                            <input id="txtUserMobile"
                                                                                class="form-control reset-elem save-elem"
                                                                                type="text" name="mobile"
                                                                                data-toggle="tooltip"
                                                                                title="Type Mobile...!!!">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Company Information
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserRoleGroup">User
                                                                                Rights Group</label>
                                                                            <span class="asterisk">&#42;</span>
                                                                            <span
                                                                                class="text-message-select2 txtRolegroup-dropdown-text-message"></span>
                                                                            <div class="input-group">
                                                                                <select
                                                                                    class="form-control select2 reset-elem save-elem"
                                                                                    name="rgid" id="txtUserRoleGroup">
                                                                                </select>
                                                                                <div class="input-group-prepend"
                                                                                    id="txtUserRefreshRoleGroupdropdown">
                                                                                    <span
                                                                                        class="btn input-group-text"><i
                                                                                            class="fas fa-sync-alt"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserFinancialYear">Financial
                                                                                Year</label>
                                                                            <span
                                                                                class="text-message-select2 txtFinancialYear-dropdown-text-message"></span>
                                                                            <div class="input-group">
                                                                                <select
                                                                                    class="form-control select2 reset-elem save-elem"
                                                                                    name="user_can_login_fn"
                                                                                    id="txtUserFinancialYear"
                                                                                    multiple="true"
                                                                                    data-placeholder="Choose Financial Year">
                                                                                </select>
                                                                                <div class="input-group-prepend"
                                                                                    id="txtUserRefreshFinancialYeardropdown">
                                                                                    <span
                                                                                        class="btn input-group-text"><i
                                                                                            class="fas fa-sync-alt"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserLevel3">Level3</label>
                                                                            <span
                                                                                class="text-message-select2 txtLevel3-dropdown-text-message"></span>
                                                                            <div class="input-group">
                                                                                <select
                                                                                    class="form-control select2 reset-elem save-elem"
                                                                                    name="level3_id" id="txtUserLevel3"
                                                                                    multiple="true"
                                                                                    data-placeholder="Choose Level3">
                                                                                </select>
                                                                                <div class="input-group-prepend"
                                                                                    id="txtUserRefreshLevel3dropdown">
                                                                                    <span
                                                                                        class="btn input-group-text"><i
                                                                                            class="fas fa-sync-alt"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserReportToAdmin">Report
                                                                                To Senior User</label>
                                                                            <span
                                                                                class="text-message-select2 txtUser-dropdown-text-message"></span>
                                                                            <div class="input-group">
                                                                                <select
                                                                                    class="form-control select2 reset-elem save-elem"
                                                                                    name="report_to_user"
                                                                                    id="txtUserReportToAdmin"
                                                                                    data-placeholder="Choose Report To">
                                                                                </select>
                                                                                <div class="input-group-prepend"
                                                                                    id="txtUserRefreshUserdropdown">
                                                                                    <span
                                                                                        class="btn input-group-text"><i
                                                                                            class="fas fa-sync-alt"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                                                        <div class="form-group">
                                                                            <label for="txtUserLevel3">Active?</label>
                                                                            <div class="input-group">
                                                                                <input 
                                                                                type="checkbox" 
                                                                                checked
                                                                                data-toggle="toggle" data-on="Yes"
                                                                                data-off="No" data-onstyle="success"
                                                                                data-offstyle="danger"
                                                                                data-width="20%" name="is_secure" class="reset-elem save-elem">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <img src="{{ url('assets/img/blank.png') }}"
                                                                class="img-fluid rounded save-elem uploadphoto"
                                                                name="photo" id="itemImageDisplay" alt="Header Image"
                                                                tabindex="-12">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-5">
                                                        <div class="col">
                                                            <input type="file" id="itemImage"
                                                                class="form-control form-control-sm itemImage save-elem upload_photo" name="photo"/>
                                                        </div>
                                                        <div class="col">
                                                            <div class="float-right">
                                                                <a class="btn btn-danger" id="removeImg">
                                                                    Delete Photo <i class="fa fa-trash"></i> </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chart tab-pane {{ $viewall }}" id="ViewAll">
                                    <div class="row">
                                        <div class="col">
                                            <table class="table table-light" id="{{ $etype . 'table' }}">
                                                <tbody id="{{ $etype . 'tableBody' }}" class="report-rows saleRows">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-flat btn-success btnSave" data-toggle="tooltip"
                                        title="Please Click To Save Setting Or Press F10!"><i
                                            class="fa fa-save"></i> Save F10</button>
                                    <a class="btn btn-flat btn-warning btnReset" data-toggle="tooltip"
                                        title="Please Click To Reset Setting Or Press F5!"><i
                                            class="fas fa-sync-alt"></i> Reset F5</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
