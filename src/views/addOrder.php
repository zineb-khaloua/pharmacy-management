<?php

use Helpers\SessionHelper;
SessionHelper::startSession();
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
          <a href="<?= BASE_PATH ?>/order"> <?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/addOrder"><?= $titleAdd ?></a>
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

          <form id="mainForm" action="<?= BASE_PATH ?>/addOrder" method="POST">

         

<div class="row mb-4">

        <div class="col">
              <div data-mdb-input-init class="form-outline">
                <input type="date" value="<?=  date('Y-m-d') ?>" name="date_order" id="date_order" class="form-control"  />
                <label class="form-label" for="date_order">date order </label>
                <span  class="error-message" id="error-date_order"></span> 
              </div>
        </div>
        <div class="col">
            <div data-mdb-input-init class="form-outline mb-4">
            <input type="date" id="date_delivery" value="<?=  date('Y-m-d') ?>" name="date_delivery" class="form-control" />
            <label class="form-label" for="date_delivery">date delivery</label>
              <span  class="error-message" id="error-date_delivery"></span>
           </div>
        </div>
</div>


<div class="row mb-4">
     <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="date" id="deadline" value="<?=  date('Y-m-d') ?>" name="deadline" class="form-control" />
        <label class="form-label" for="Deadline">Deadline</label>
      </div>
      <span  class="error-message" id="error-deadline"></span> 
    </div>

    <div class="col">
    <div class="form-outline mb-4 d-flex align-items-center">
        <label class="form-label mr-3" for="urgent" style="margin-right: 50px;">Urgent</label>
        <div class="form-check form-check-inline" >
            <input type="radio" id="urgent_yes" name="urgent" value="Yes" class="form-check-input" />
            <label for="urgent_yes" class="form-check-label">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="urgent_no" name="urgent" value="No" class="form-check-input" />
              <label for="urgent_no" class="form-check-label">No</label>

        </div>
        <span  class="error-message" id="error-urgent"></span> 
    </div>
</div>
</div>


<div class="row mb-4">
  <div class="col">
    <div data-mdb-input-init class="form-outline ">
    <input type="text" value="pending"  id="status" name="status" class="form-control" readonly />    
    <label class="form-label" for="status">Status</label>
   
    <span  class="error-message" id="error-status"></span> 

    </div>
    </div> 
  </div>


  <div class="row mb-4">
  <div class="col">
  <select name="supplier_id" id="supplier" class="form-select">
    <option value="" disabled selected>Select Supplier</option>
    <?php foreach ($suppliers as $supplier): ?>
      <option value="<?= $supplier->supplier_id ?>">
          <?= htmlspecialchars($supplier->name) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <label for="supplier" class="form-label">Supplier</label>
  <span class="error-message" id="error-supplier_id"></span>
</div>


    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text"
        value=" <?php echo htmlspecialchars($_SESSION['username']); ?>"
        id="username" name="username" class="form-control" readonly />
        <input type="hidden" 
           value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>"
           id="user_id" name="user_id" />
        <label class="form-label" for="user">user</label>
      </div>
    </div>
  </div>

  <div class=" row mb-4 ">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
      <input type="hidden" id="generalTotal" name="total_amount" value="0.00">
      </div>
   </div>
</div>


 <div class="row mb-4">
<div class="col text-center">

    <button type="button" class="btn btn-success btn-round ms-auto"
      data-toggle="modal" data-target="#addMedicamentModal">
      Add Medicaments
      <i class="fa fa-plus"></i>
    </button>
</div>
</div>


<div class="card-body">
<div class="table-responsive">

<h3>Medicaments</h3>
       <table class="table table-bordered" id="selectedItemsTable">
           <thead>
               <tr>
                   <th>Medicament</th>
                   <th>Quantity</th>
                   <th>Price</th>
                   <th>total</th>
                   <th>Action</th>
               </tr>
           </thead>
           <tbody>

            <!-- Add medicament dynamically here -->
             
           </tbody>
           <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Total General</td>
                    <td id="totalGeneral" style="text-align: right; font-weight: bold;">0.00</td>
                </tr>
            </tfoot>
       </table>
   </div>
   </div>

   
  <span class="error-message mb-4" id="error-medicament_data"></span>
 <div class="d-flex justify-content-center mb-4">
  
 <input type="hidden" id="medicament_data" name="medicament_data" value="[]">
   <button type="submit" name='submit' class="btn btn-primary me-2">Submit</button>
   <button type="button" id='cancel-btn' class="btn btn-danger">Cancel</button>
 </div>

</form>          

  </div>
  </div>
  </div>
 </div>
 </div>

   <!----- Modal for data medicaments -- -->
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
                         <option value="">select medicament</option>
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
                           <input type="number" class="form-control" id="modal_price"  readonly required>
                       </div>
                       <div class="form-group">
                           <label for="modal_total">total:</label>
                           <input type="number" class="form-control" id="modal_total" readonly required>
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
                <p id="modalMessage">order added with sucessefully ! </br>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script src="<?= BASE_PATH ?>/assets/js/order/addOrder.js"></script>