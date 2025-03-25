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
          <a href="<?= BASE_PATH ?>/supplier"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/supplier"><?= $titleAdd ?></a>
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
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="name"  value="<?= $_SESSION['old_data']['name'] ?? '' ?>" id="name" class="form-control" />
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
        <input type="text" name="phone_number"  value="<?= $_SESSION['old_data']['phone_number'] ?? '' ?>" id="phone_number" class="form-control" />
        <label class="form-label" for="phone_number">phone number</label>

        <?php if (!empty($_SESSION['error_messages']['phone_number'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['phone_number'] as $error): ?>
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
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="address"  value="<?= $_SESSION['old_data']['address'] ?? '' ?>"  name="address" class="form-control" />
    <label class="form-label" for="address">Address</label>

    
    <?php if (!empty($_SESSION['error_messages']['address'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['address'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
    </div>
    <div class="col">
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="email" name="email"  value="<?= $_SESSION['old_data']['email'] ?? '' ?>" class="form-control" />
    <label class="form-label" for="email">Email</label>

    <?php if (!empty($_SESSION['error_messages']['email'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['email'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    </div>
  </div>


  <!-- Text input -->
  <div class="row mb-4">
  
      <div data-mdb-input-init class="form-outline">
        <input type="text" id="entity" name="entity"  value="<?= $_SESSION['old_data']['entity'] ?? '' ?>" class="form-control" />
        <label class="form-label" for="entity">Entity</label>

        <?php if (!empty($_SESSION['error_messages']['entity'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['entity'] as $error): ?>
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
   <?php 
   unset($_SESSION['error_messages']);
   unset($_SESSION['old_data']);
   ?>
  </div>
  </div>
  </div>
 </div>
 </div>
  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="<?= BASE_PATH ?>/assets/js/supplier/addSupplier.js"> </script>

 