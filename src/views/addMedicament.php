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
          <a href="<?= BASE_PATH ?>/medicament"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/addMedicament"><?= $titleAdd ?></a>
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

       <form action="" method="POST">



   <div class="row mb-4">
    <div class="col">
     
    <div  data-mdb-input-init class="form-outline">
    <input type="text" name="name" value="<?= $_SESSION['old_data']['name'] ?? '' ?>" id="name" class="form-control" />
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
        <input type="text" name="reference_code" id="reference_code" 
        class="form-control" 
        value="<?= htmlspecialchars($reference_code) ?>" readonly />
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

  <div class="row mb-4">
  <div class="col">
  <select name="category_id" id="category" class="form-select">
    <option value="" disabled <?= empty($_SESSION['old_data']['category_id']) ? 'selected' : ''; ?>>Select Category</option>
    <?php foreach ($categories as $category): ?>
      <option value="<?= $category->category_id ?>" 
        <?= (isset($_SESSION['old_data']['category_id']) && $_SESSION['old_data']['category_id'] == $category->category_id) ? 'selected' : ''; ?>>
        <?= htmlspecialchars($category->name) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <label for="category" class="form-label">Category</label>
  <?php if (!empty($_SESSION['error_messages']['category_id'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['category_id'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

    <div class="col">
  <select name="supplier_id" id="supplier" class="form-select">
    <option value="" disabled <?= empty($_SESSION['old_data']['supplier_id']) ? 'selected' : ''; ?>>Select Supplier</option>
    <?php foreach ($suppliers as $supplier): ?>
      <option value="<?= $supplier->supplier_id ?>" 
        <?= (isset($_SESSION['old_data']['supplier_id']) && $_SESSION['old_data']['supplier_id'] == $supplier->supplier_id) ? 'selected' : ''; ?>>
        <?= htmlspecialchars($supplier->name) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <label for="supplier" class="form-label">Supplier</label>
  <?php if (!empty($_SESSION['error_messages']['supplier_id'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['supplier_id'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

  </div>

  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="number" value="<?= $_SESSION['old_data']['price'] ?? '' ?>" id="price" name="price" class="form-control" />
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
    <input type="number" id="quantity_in_stock" value="<?= $_SESSION['old_data']['quantity_in_stock'] ?? '' ?>"  name="quantity_in_stock" class="form-control" />
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

  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" id="laboratory" value="<?= $_SESSION['old_data']['laboratory'] ?? '' ?>" name="laboratory" class="form-control" />
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

    <input type="date" name="expired_date" value="<?= $_SESSION['old_data']['expired_date'] ?? date('Y-m-d') ?>" id="name" class="form-control" />
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

 
   <div class="row mb-4 align-items-center">
 
   <div class="col-md-6">
  <label class="form-label">Reimbursable</label>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="reimbursable_yes" name="reimbursable" value="YES" 
      <?= (isset($_SESSION['old_data']['reimbursable']) && $_SESSION['old_data']['reimbursable'] == 'YES') ? 'checked' : ''; ?> />
    <label class="form-check-label" for="reimbursable_yes">YES</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="reimbursable_no" name="reimbursable" value="NO" 
      <?= (isset($_SESSION['old_data']['reimbursable']) && $_SESSION['old_data']['reimbursable'] == 'NO') ? 'checked' : ''; ?> />
    <label class="form-check-label" for="reimbursable_no">NO</label>
  </div>
  <?php if (!empty($_SESSION['error_messages']['reimbursable'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['reimbursable'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


 
<div class="col-md-6">
  <label class="form-label">Prescription</label>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="prescription_true" name="prescription" value="YES" 
      <?= (isset($_SESSION['old_data']['prescription']) && $_SESSION['old_data']['prescription'] == 'YES') ? 'checked' : ''; ?> />
    <label class="form-check-label" for="prescription_true">YES</label>
  </div>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="prescription_false" name="prescription" value="NO" 
      <?= (isset($_SESSION['old_data']['prescription']) && $_SESSION['old_data']['prescription'] == 'NO') ? 'checked' : ''; ?> />
    <label class="form-check-label" for="prescription_false">NO</label>
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


  <div class="d-flex justify-content-center mt-4">
    <button type="submit" name='submit' class="btn btn-primary me-2">Submit</button>
    <button type="button" id='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>
</form>
<?php 
unset($_SESSION['error_messages']); 
unset($_SESSION['old_data']);
?>
  </div>
  </div>
  </div>
 </div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?= BASE_PATH ?>/assets/js/medicament/addMedicament.js"></script>
