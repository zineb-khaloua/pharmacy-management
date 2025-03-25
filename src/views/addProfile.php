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
          <a href="<?= BASE_PATH ?>/profile"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/addProfile"><?= $titleAdd ?></a>
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

       <form action="" method="POST"  enctype="multipart/form-data">
        <h3> Connection Information :</h3>

        <div class="row mb-4">
        <div class="col ">
            <div data-mdb-input-init class="form-outline">
                <!-- Profile Picture Preview -->
                <img id="profileImage" src="https://via.placeholder.com/130" 
                    alt="Profile Picture" class="rounded-circle shadow mb-3 d-none" width="130" height="130">

                <!-- Actual File Input -->
                <input type="file" name="user_picture" id="user_picture_input" accept="image/*" class="form-control" />

               
            </div>
        </div>
    </div>
    <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="username" id="username" class="form-control" />
        <label class="form-label" for="username">username</label>
      </div>
    </div>
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="email" id="email" class="form-control" />
        <label class="form-label" for="email">email </label>
      </div>
    </div>
  </div>
 <!-- Text input -->
  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" id="password_hash"  name="password_hash" class="form-control" />
        <label class="form-label"  for="password_hash">password</label>
      </div>
    </div>
    <div class="col">
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="text" id="role" name="role" class="form-control" />
    <label class="form-label" for="role">role</label>
    </div>
    </div>
  </div>

<h3> Personal Information :</h3>
   <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="name" id="name" class="form-control" />
        <label class="form-label" for="name">Name</label>
      </div>
    </div>
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="registration_number" id="registration_number" class="form-control" />
        <label class="form-label" for="registration_number">Registration number </label>
      </div>
    </div>
  </div>
 <!-- Text input -->
  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" id="phone_number"  name="phone_number" class="form-control" />
        <label class="form-label"  for="phone_number">Phone</label>
      </div>
    </div>
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" id="salary" name="salary" class="form-control" />
        <label class="form-label" for="salary">Salary($)</label>
      </div>
    </div>
  </div>
  <!-- Text input -->
  <div class="row mb-4">
    
    <div class="col">
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="date" id="hire_date" value="<?= date('Y-m-d')?>" name="hire_date" class="form-control" />
    <label class="form-label" for="hire_date">Hire date </label>
    </div>
    </div>
    <div class="col">
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="date" id="date_birth" value="<?= date('Y-m-d')?>" name="date_birth" class="form-control" />
    <label class="form-label" for="date_birth">date of birth </label>
    </div>
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

<script src="<?= BASE_PATH ?>/assets/js/profile/addProfile.js"></script>






 