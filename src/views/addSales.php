<?php

use Helpers\SessionHelper;
SessionHelper::startSession();

//$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
//$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
//unset($_SESSION['error']);
ob_start();
?>

<div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3"><?= $titleAdd ?></h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="<?= BASE_PATH ?>/dashboard">
            <i class="icon-home"></i>
          </a>
        </li>
      <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/sale"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
<li class="nav-item">
          <a href="<?= BASE_PATH ?>/addSale"><?= $titleAdd ?></a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title"> <?=$titleAdd?></h4>
            </div>
          </div>
       <div class="card-body">

       <form id="mainForm" action="<?= BASE_PATH ?>/addSale" method="POST">


 <div class="row ">
      <div data-mdb-input-init class="form-outline">
        <input type="date" name="dateSale" value="<?=  date('Y-m-d') ?>" id="dateSale" class="form-control" required />
        <label class="form-label" for="dateSale">date Sale </label>
        <span  class="error-message" id="error-dateSale"></span> 
      </div>
 <div>
<div class="row ">
      <div data-mdb-input-init class="form-outline">
        <input type="text"
         value=" <?php echo htmlspecialchars($_SESSION['username']); ?>"
         id="username" name="username" class="form-control" readonly required />
         <input type="hidden" 
           value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>"
           id="user_id" name="user_id" required />
         <label class="form-label" for="user_id">user</label>
         <span  class="error-message" id="error-user_id"></span> 
      </div>
</div>
  
<div class="row">
  <div class="col">
      <select name="patient_id" id="patient" class="form-select">
        <option value="" disabled  selected >Select Patient</option>
    
       <?php foreach ($patients as $patient): ?>
        <option value="<?php echo $patient->patient_id ?>" >
        <?= htmlspecialchars($patient->name) ?>
        </option>
    <?php endforeach; ?>
      </select>
      <label for="patient" class="form-label">Patient</label>
      <div class="error-message" id="error-patient_id"></div> 
  </div>
</div>

<div class="row ">
<div data-mdb-input-init class="form-outline">
  <input type="number" name="credit" value="" id="credit" class="form-control"  />
  <label class="form-label" for="credit">credit</label>
  <div  class="error-message" id="error-credit"></div> 
</div>
<div>
<div class="row ">
<div data-mdb-input-init class="form-outline">
<input type="hidden" id="generalTotal" name="total_price" value="" />
</div>
<div>

<div class="row">
<div class="col text-center">
  <button type="button" class="btn btn-success btn-round ms-auto"
   data-toggle="modal" data-target="#addMedicamentModal">
   Add Medicaments
   <i class="fa fa-plus"></i>
</button>
</div>
</div>
</div>
 

<h3>Medicaments</h3>
        <table class="table table-bordered" id="selectedItemsTable">
            <thead>
                <tr>
                    <th>Medicament</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Prescription</th>
                    <th>total</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>

           <!-- Add medicament dynamically here -->
            
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total General</td>
                    <td id="totalGeneral" style="text-align: right; font-weight: bold;">0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
    

  <div class="d-flex justify-content-center mt-4">
 <input type="hidden" id="medicament_data" name="medicament_data" value="[]">
    <button type="submit" name='submit' class="btn btn-primary me-2">Submit</button>
    <button type="button" id ='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>   
  </form>          

</div>
</div>
</div>
</div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="addMedicamentModal" tabindex="-1" role="dialog" aria-labelledby="addMedicamentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicamentModalLabel">Add Medicaments </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="modalForm">
                        <div class="form-group">
                            <label for="modal_medicament_id">Medicament:</label>
                            <select class="form-control" name="medicament_id" id="modal_medicament_id" required>
                        
                                <option value=""> select medicament</option>
                                  <?php foreach ($medicaments as $medicament): ?>
                                    <option value="<?php echo $medicament->medicament_id?>"
                                            data-price="<?php echo $medicament->price; ?>">
                                            <?= htmlspecialchars($medicament->name) ?>
                                    </option>
                                <?php endforeach; ?>
                             
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_quantity">Quantity:</label>
                            <input type="number" class="form-control" id="modal_quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="modal_price">Price:</label>
                            <input type="number" class="form-control" id="modal_price" step="0.01" required readonly>
                        </div>

                        <div class="form-group">
                              <label class="form-label mr-3" for="prescription" style="margin-right: 50px;">prescription:</label>
                              <div class="form-check form-check-inline" >
                                  <input type="radio" id="prescription_yes" name="prescription" value="Yes" class="form-check-input" required />
                                  <label for="prescription_yes" class="form-check-label">Yes</label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input type="radio" id="prescription_no" name="prescription" value="No" class="form-check-input"  required/>
                                  <label for="prescription_no" class="form-check-label">No</label>
                              </div>
                        </div>

                        <div class="form-group">
                            <label for="modal_total">total:</label>
                            <input type="number" class="form-control" name="total" id="modal_total"  required readonly>
                        </div>
                        <button type="button" class="btn btn-primary" id="saveModalData">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
   <!-- Modal Confirmation -->

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog  text-center ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage">sale added with sucessefully ! </br>
                                     do you want to generate invoice ?
                </p>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-success" id="generateInvoiceBtn" data-dismiss="modal">YES</button>
                <button type="button" class="btn btn-danger" >NO</button>
              </div>
        </div>
    </div>
  </div>
  </div>
  </div>
  </div>
    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script src="<?= BASE_PATH ?>/assets/js/sales/addSales.js"></script>






 