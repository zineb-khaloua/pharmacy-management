<?php
use Helpers\SessionHelper;
SessionHelper::startSession();
ob_start();

?>

<div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="op-7 mb-2">Welcome <?php echo $_SESSION['username'] ?> !</h3>
             
                <h4 class="fw-bold mb-3"><?php echo $title ?></h4>
                 </div>
              
              <div class="ms-md-auto py-2 py-md-0">
                <div id="low-stock-notification"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-primary bubble-shadow-small"
                        >
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Patients</p>
                          <h4 class="card-title"><?php echo $patients ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-info bubble-shadow-small"
                        >
                        <i class="fa  fa-capsules"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Expired Medicam</p>
                          <h4 class="card-title"><?php echo $medicaments ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-success bubble-shadow-small"
                        >
                          <i class="fas fa-luggage-cart"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Sales</p>
                          <h6 class="card-title"><?php echo $sales ?></h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Orders</p>
                          <h4 class="card-title"><?php echo $orders ?></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-4">
<div class="col">
<select id="periodSelector" class="form-control mt-4" >
    <option> select period</option>
    <option value="day">day</option>
    <option value="week">week</option>
    <option value="month">month</option>
    <option value="year">year</option>
</select>
</div>
<div class="col">
    <div id="yearContainer" ></div>
    <div id="monthContainer" ></div>
    <div id="weekContainer" ></div>
    <div id="dayContainer" ></div>
    <div type='date' id="datePicker"></div>
</div>
</div>
<canvas id="salesChart"></canvas>
</div>

<script src="<?= BASE_PATH ?>/assets/js/dashboard.js"></script>





    