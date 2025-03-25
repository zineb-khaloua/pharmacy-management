<?php

use Helpers\SessionHelper;
SessionHelper::startSession();
ob_start();
?>

<div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3"><?= $titleEdit ?></h3>
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
          <a href="<?= BASE_PATH ?>/editSale"><?= $titleEdit?></a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title"> <?=$titleEdit?></h4>
            </div>
          </div>
          <div class="card-body">

       <form action="<?= BASE_PATH ?>/editSale/<?php echo $sales->sales_id ?>" method="POST">
        
    <input type="hidden" name="sale_id" value="<?= $sales->sale_id ?>">
    
 <!-- Text input -->
 <div class="row ">
<div data-mdb-input-init class="form-outline">
  <input type="datetime-local" name="dateSale" value="<?php echo $sales->sale_date ?>" id="dateSale" class="form-control"  />
  <label class="form-label" for="dateSale">date Sale:</label>

  <?php if (!empty($_SESSION['error_messages']['sale_date'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['error_messages']['sale_date'] as $error): ?>
                        <span><?= htmlspecialchars('*'.$error) ?></span>
                    <?php endforeach; ?>
                </div>
 <?php endif; ?>
</div>
</div>


<div class="row ">
<div data-mdb-input-init class="form-outline">
  <input type="text"
   value="<?php echo $sales->user_name ?>"
   id="username" name="username" class="form-control" readonly />
   <input type="hidden" 
    value="<?php echo $sales->user_id ?>"
     id="user_id" name="user_id" />
   <label class="form-label" for="user_id">user:  
    <?php if ($sales->user_id === NULL): ?>
        <span style="color: red;">(* Deleted User)</span>
    <?php endif; ?></label>
</div>
</div>

<!-- Text input -->

<div class="row">
<div class="col">
<select name="patient_id" id="patient" class="form-control">
  <option value="<?php echo $sales->patient_id ?>" selected><?php echo $sales->patient_name ?></option>

 <?php foreach ($patients as $patient): ?>
  <option value="<?php echo $patient->patient_id?>">
      <?= htmlspecialchars($patient->name) ?>
  </option>
<?php endforeach; ?>
</select>
<label for="patient_id" class="form-label">Patient:</label>
<?php if ($sales->patient_id === NULL): ?>
        <span style="color: red;">(* Deleted Patient)</span>
<?php endif; ?></label>
</div>
</div> 

<div class="row ">
<div data-mdb-input-init class="form-outline">
<input type="number" value="<?php echo $sales->credit ?>" name="credit" id="credit" class="form-control"  />
<label class="form-label" for="credit">credit:</label>

</div>
</div>
<div class="row ">
<div data-mdb-input-init class="form-outline">
<input type="number" value="<?php echo $sales->total_price ?>" name="total_price" id="generalTotal" class="form-control" readonly />
<label class="form-label text-dark fw-bold fs-5 " for="total_price"> <strong > General Total: </strong> </label>
<?php if (!empty($_SESSION['error_messages']['total_price'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['error_messages']['total_price'] as $error): ?>
                        <span><?= htmlspecialchars('*'.$error) ?></span>
                    <?php endforeach; ?>
                </div>
 <?php endif; ?>
</div>
</div>


<?php $counter = 1; ?>
<?php foreach ($items as $item): ?>
    <h5 class="mt-5" >Medicament <?= $counter ?>:</h5>
    <input type="hidden" name="items[<?= $item->item_id ?>][item_id]" value="<?= $item->item_id ?>">
   
    <div class="row mb-4">
        <div class="col">
        <select class="form-control" name="items[<?= $item->item_id ?>][medicament_id]" id="medicament_id_<?= $item->item_id ?>">
               <option value="" selected disabled><?= $item->medicament_name ?></option>
                <?php foreach ($medicaments as $medicament): ?>
                    <option value="<?= $medicament->medicament_id ?>" data-price="<?= $medicament->price; ?>" <?= $medicament->medicament_id == $item->medicament_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($medicament->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="medicament_id_<?= $item->item_id ?>">Medicament:</label>
            <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['medicament_id'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['medicament_id'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
        </div>
        <div class="col">
        <input type="number" name="items[<?= $item->item_id ?>][quantity]" value="<?= $item->quantity ?>" class="form-control" id="quantity_<?= $item->item_id ?>"  oninput="calculateItemTotal(<?= $item->item_id ?>)" min="1">
        <label for="quantity_<?= $item->item_id ?>">Quantity:</label>

        <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['quantity'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['quantity'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
        <input type="number" name="items[<?= $item->item_id ?>][price]" value="<?= $item->price ?>" class="form-control" id="price_<?= $item->item_id ?>" oninput="calculateItemTotal(<?= $item->item_id ?>)"  >
          <label for="price_<?= $item->item_id ?>">Price:</label>
          <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['price'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['price'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
        </div>
        <div class="col">
            <label class="form-label me-3" for="prescription_<?= $item->item_id ?>">Prescription:</label>
            <div class="form-check form-check-inline"  >

            <input type="radio" id="prescription_yes_<?= $item->item_id ?>" name="items[<?= $item->item_id ?>][prescription]" value="Yes" <?= strtolower($item->prescription ?? '') === 'yes' ? 'checked' : '' ?> class="form-check-input" >
                <label for="prescription_yes_<?= $item->item_id ?>" class="form-check-label">Yes</label>
            </div>
            <div class="form-check form-check-inline">

            
            <input type="radio" id="prescription_no_<?= $item->item_id ?>" name="items[<?= $item->item_id ?>][prescription]" value="No" <?= strtolower($item->prescription ?? '') === 'no' ? 'checked' : '' ?> class="form-check-input">
            <label for="prescription_no_<?= $item->item_id ?>" class="form-check-label">No</label>
            </div>
        </div>
        <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['prescription'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['prescription'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="row mb-4">
        <div class="col">
        <input type="number" name="items[<?= $item->item_id ?>][total]" value="<?= $item->total ?>" class="form-control" id="total_<?= $item->item_id ?>"  >
        <label for="total_<?= $item->item_id ?>">Total:</label>
        <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['total'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['total'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
        </div>
    </div>
    <?php $counter++; ?>
<?php endforeach; ?>


<div class="row">
<div class="col text-center">
 <!-- Bouton pour ouvrir le modal -->
  <button type="button" class="btn btn-success btn-round ms-auto"
   data-toggle="modal" data-target="#addMedicamentModal">
   Add Medicaments
   <i class="fa fa-plus"></i>
</button>
</div>
</div>



<!-- Tableau pour afficher les IDs, quantités et prix sélectionnés -->
<h3>Medicaments</h3>
        <table class="table table-bordered" id="selectedItemsTable">
            <thead>
                <tr>
                    <th>Medicament</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Prescription</th>
                    <th>total</th>
                </tr>
            </thead>
            <tbody>
          
                <!-- Les lignes seront ajoutées dynamiquement ici -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold;">Total General</td>
                    <td id="totalGeneral" style="text-align: right; font-weight: bold;">0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
  <div class="d-flex justify-content-center mb-2">
  <input type="hidden" id="medicament_data" name="medicament_data" value="[]">
    <button type="submit" name='submit' class="btn btn-primary me-4 ">Submit</button>
    <button type="button" id='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>
  </form>
  <?php unset($_SESSION['error_messages']); ?>
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
                              <option value="" >select medicament </option>
                            <!-- Add suppliers  dynamically here -->
                                  <?php foreach ($medicaments as $medicament): ?>
                                    <option value="<?php echo $medicament->medicament_id?>"
                                            data-price="<?php echo $medicament->price; ?>">
                                            <?= htmlspecialchars($medicament->name) ?>
                                    </option>
                                <?php endforeach; ?>
                                <!-- Ajoutez d'autres options selon vos besoins -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="modal_quantity">Quantity:</label>
                            <input type="number" class="form-control" id="modal_quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="modal_price">Price:</label>
                            <input type="number" class="form-control" id="modal_price" step="0.01" required>
                        </div>

                        <div class="form-group">
                              <label class="form-label mr-3" for="prescription" style="margin-right: 50px;">prescription:</label>
                              <div class="form-check form-check-inline" >
                                  <input type="radio" id="prescription_yes" name="prescription" value="Yes" class="form-check-input" required/>
                                  <label for="prescription_yes" class="form-check-label">Yes</label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input type="radio" id="prescription_no" name="prescription" value="No" class="form-check-input" required />
                                  <label for="prescription_no" class="form-check-label">No</label>
                              </div>
                        </div>

                        <div class="form-group">
                            <label for="modal_total">total:</label>
                            <input type="number" class="form-control" name="total" id="modal_total"   readonly required>
                        </div>
                        <button type="button" class="btn btn-primary" id="saveModalData">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script src="<?= BASE_PATH ?>/assets/js/sales/editSales.js"></script>