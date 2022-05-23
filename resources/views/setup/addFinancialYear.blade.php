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
                                          <a class="nav-link {{ $dataentry }}" href="#AddFinancialYear"
                                              data-toggle="tab">Add/Update</a>
                                      </li>
                                      <li class="nav-item">
                                          <a class="nav-link {{ $viewall }}" href="#ViewAll" data-toggle="tab"
                                              id="txtViewAllQuery">View All</a>
                                      </li>
                                  </ul>
                              </div>
                          </div><!-- /.card-header -->
                          <div class="card-body">
                              <div class="tab-content p-0">
                                  <!-- Morris chart - Sales -->
                                  <div class="chart tab-pane {{ $dataentry }}" id="AddFinancialYear">
                                      @if ($errors->any())
                                          <div class="alert alert-danger">
                                              <ul>
                                                  @foreach ($errors->all() as $error)
                                                      <li>{{ $error }}</li>
                                                  @endforeach
                                              </ul>
                                          </div>
                                      @endif
                                      <div class="row d-none">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="txtFinancialYearID">ID</label>
                                                  <input id="txtFinancialYearID"
                                                      class="form-control save-elem"
                                                      type="text" name="financialyear_id">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="txtFinancialYearSdate">Start Date</label>
                                                  <input id="txtFinancialYearSdate"
                                                      class="form-control datepicker validate-save save-elem date-reset"
                                                      type="text" name="financialyear_start_date">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="txtFinancialYearEdate">End Date</label>
                                                  <input id="txtFinancialYearEdate"
                                                      class="form-control datepicker validate-save save-elem date-reset"
                                                      type="text" name="financialyear_end_date">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="txtFinancialYearName">Name</label>
                                                  <input id="txtFinancialYearName"
                                                      class="form-control validate-save save-elem" type="text"
                                                      name="financialyear_name">
                                                  <input id="vouchertypehidden" class="form-control" type="hidden"
                                                      value="new">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-4">
                                              <div class="form-group">
                                                  <label for="txtFinancialYearRemarks">Remarks</label>
                                                  <input id="txtFinancialYearRemarks" class="form-control save-elem"
                                                      type="text" name="financialyear_remarks">
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
                          </div><!-- /.card-body -->
                          <div class="card-footer">
                              <div class="row">
                                  <div class="col">
                                      <a class="btn btn-flat btn-success btnSave" data-toggle="tooltip"
                                          title="Please Click To Save Setting Or Press F10!"><i
                                              class="fa fa-save"></i> Save F10</a>
                                      <a class="btn btn-flat btn-warning btnReset" data-toggle="tooltip"
                                          title="Please Click To Reset Setting Or Press F5!"><i
                                              class="fas fa-sync-alt"></i> Reset F5</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
