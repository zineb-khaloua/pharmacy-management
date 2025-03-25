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
          <a href="<?= BASE_PATH ?>/category"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/editCategory/<?php echo $id;?>"><?= $titleEdit ?></a>
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
       <input type="hidden" name="id" value="<?php echo $id;?>">

  <!-- 2 column grid layout with text inputs for the first and last names -->
  <div class="row mb-4">
    
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="name" value="<?php echo $category->name?>" id="name" class="form-control" />
        <label class="form-label" for="name">Name</label>

        <?php if (!empty($_SESSION['error_messages']['name'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['name'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
      </div>

      <div data-mdb-input-init class="form-outline">
        <input type="text" name="description" value="<?php echo $category->description?>" id="description" class="form-control" />
        <label class="form-label" for="description">description</label>

        <?php if (!empty($_SESSION['error_messages']['description'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['description'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
      </div>

  </div>
 


  <!-- Submit button -->
  <div class="d-flex justify-content-center">
    <button type="submit" name='submit' class="btn btn-primary me-2">modify</button>
 
    <button type="button" id ='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>
   </form>
   <?php 
   unset($_SESSION['error_messages']);
   ?>
  </div>
  </div>
  </div>
 </div>
 </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="<?= BASE_PATH ?>/assets/js/category/editCategory.js"></script>