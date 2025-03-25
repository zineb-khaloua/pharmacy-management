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
          <a href="<?= BASE_PATH ?>/medicament"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/editMedicament"><?= $titleEdit?></a>
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

       <form action="" method="POST">
 <!-- Text input -->

   <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="name" value="<?php echo $medicament->name ?>" id="name" class="form-control" />
        <label class="form-label" for="name">Name</label>
        
        <?php if (!empty($_SESSION['error_messages']['name'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['name'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
      </div>
    </div>
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="reference_code" value="<?php echo $medicament->reference_code ?>" id="reference_code" class="form-control" />
        <label class="form-label" for="reference_code">reference code </label>
        <?php if (!empty($_SESSION['error_messages']['reference_code'])): ?>
    <div class="text-danger">
        <?php foreach ($_SESSION['error_messages']['reference_code'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?> 
      </div>
    </div>
  </div>

     <!-- Dropdowns -->

  <div class="row mb-4">
  <div class="col">
      
      <select name="category_id" id="category" class="form-select">
      <option value="<?php echo $medicament->category_id ?>" selected><?php echo $medicament->category_name ?></option>
        <?php foreach ($categories  as $category): ?>

        <option value="<?php echo $category->category_id?>">
        <?= htmlspecialchars($category->name) ?> 
        </option>

       <?php endforeach; ?>
      </select>
      <label for="category" class="form-label">Category:
        <?php if ($medicament->category_id === NULL): ?>
        <span style="color: red;">(* Deleted Category)</span>
    <?php endif; ?>
      </label>
    </div>
    <div class="col">
    
      <select name="supplier_id" id="supplier" class="form-select">
     
      <option value="<?php echo $medicament->supplier_id ?>" selected><?php echo $medicament->supplier_name ?></option>
      
   
       <?php foreach ($suppliers as $supplier): ?>
        <option value="<?php echo $supplier->supplier_id?>">
            <?= htmlspecialchars($supplier->name) ?>
        </option>
    <?php endforeach; ?>
      </select>
      <label for="supplier" class="form-label">Supplier :
        <?php if ($medicament->supplier_id === NULL): ?>
        <span style="color: red;">(* Deleted Supplier)</span>
    <?php endif; ?>
      </label>
    </div>
  </div>
 <!-- Text input -->
  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="number" value="<?php echo $medicament->price ?>" name="price" id="price" class="form-control" />
        <label class="form-label" for="price">price</label>
        <?php if (!empty($_SESSION['error_messages']['price'])): ?>
    <div class="text-danger">
        <?php foreach ($_SESSION['error_messages']['price'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?> 
      </div>
    </div>
    <div class="col">
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="number" value="<?php echo  $medicament->quantity_in_stock ?>" name="quantity_in_stock" " id="quantity_in_stock" class="form-control" />
    <label class="form-label" for="quantity_in_stock">quantity in stock</label>
    <?php if (!empty($_SESSION['error_messages']['quantity_in_stock'])): ?>
    <div class="text-danger">
        <?php foreach ($_SESSION['error_messages']['quantity_in_stock'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?> 
  </div>
    </div>
  </div>


  <!-- Text input -->
  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" value="<?php echo $medicament->laboratory?>" id="laboratory" name="laboratory" class="form-control" />
        <label class="form-label" for="laboratory">laboratory</label>
        <?php if (!empty($_SESSION['error_messages']['laboratory'])): ?>
    <div class="text-danger">
        <?php foreach ($_SESSION['error_messages']['laboratory'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
      </div>
    </div>
    <div class="col">

<input type="date" name="expired_date" value="<?php echo $medicament->expired_date?>" id="name" class="form-control" />
<label for="expired_date" class="form-label">expired date</label>

<?php if (!empty($_SESSION['error_messages']['expired_date'])): ?>
    <div class="text-danger">
        <?php foreach ($_SESSION['error_messages']['expired_date'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>

  </div>

   <!-- Text input -->
   <div class="row mb-4 align-items-center">
  <!-- Reimbursable Section -->
  <div class="col-md-6">
    <label class="form-label">Reimbursable</label>
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="reimbursable_yes" 
               name="reimbursable" value="Yes" 
               <?= (isset($medicament->Reimbursable) && strtolower(trim($medicament->Reimbursable)) === 'yes') ? 'checked' : '' ?>>
        <label class="form-check-label" for="reimbursable_yes">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="reimbursable_no" 
               name="reimbursable" value="No"  
               <?= (isset($medicament->Reimbursable) && strtolower(trim($medicament->Reimbursable)) === 'no') ? 'checked' : '' ?>>
        <label class="form-check-label" for="reimbursable_no">No</label>
    </div>
    <?php if (!empty($_SESSION['error_messages']['reimbursable'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['reimbursable'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>



  <!-- Prescription Section -->

  <div class="col-md-6">
    <label class="form-label">Prescription</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="prescription_true"
               name="prescription" value="Yes"
               <?= (!empty($medicament->prescription) && strtolower($medicament->prescription) == 'yes') ? 'checked' : '' ?>>
        <label class="form-check-label" for="prescription_true">Yes</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" id="prescription_false" 
               name="prescription" value="No"
               <?= (!empty($medicament->prescription) && strtolower($medicament->prescription) == 'no') ? 'checked' : '' ?>>
        <label class="form-check-label" for="prescription_false">No</label>
    </div>

    <?php if (!empty($_SESSION['error_messages']['prescription'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['prescription'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</div>


 
  

  <!-- Submit button -->
  <div class="d-flex justify-content-center">
    <button type="submit" name='submit' class="btn btn-primary me-2">Submit</button>
   
    <button type="button" id ='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>
   </form>
  </div>
  </div>
  </div>
 </div>
 </div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?= BASE_PATH ?>/assets/js/medicament/editMedicament.js"> </script>