<?php

use Helpers\SessionHelper;
SessionHelper::startSession();
ob_start();
?>

<div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3"><?= $title ?></h3>
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
          <a href="<?= BASE_PATH ?>/authenInfo"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/addUser"><?= $editTitle?></a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title"> <?=$editTitle?></h4>
            </div>
          </div>
          <div class="card-body">

          <form  action="" method="POST" enctype="multipart/form-data">
       <h3> Connection Information :</h3>

<div class="row mb-4">
<div class="col d-flex flex-column align-items-center ">
    <div data-mdb-input-init class="form-outline text-center mb-4">
      
    <div class="profile-pic-container">
    <img src="<?= !empty($user['user_picture']) ? BASE_PATH . '/' . $user['user_picture'] . '?t=' . time() : 'https://via.placeholder.com/130' ?>" 
     alt="Profile Picture" 
     class="profile-pic"  
     id="profileImage">
    <label for="profileUpload" class="upload-btn">
        <i class="fa fa-camera"></i>
    </label>
    <input type="file" name='user_picture' id="profileUpload" class="d-none" accept="image/*" onchange="loadProfileImage(event)">

    </div>
    <?php if (!empty($_SESSION['error_messages']['user_picture'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['user_picture'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
               <?php endif; ?>
</div>
</div>
<div class="row mb-4">
<div class="col">
<div data-mdb-input-init class="form-outline">
<input type="text" name="username"  value="<?php echo $user['username'] ?>" id="username" class="form-control" />
<label class="form-label" for="username">username</label>

<?php if (!empty($_SESSION['error_messages']['username'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['username'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
 <?php endif; ?>
</div>
</div>
<div class="col">
<div data-mdb-input-init class="form-outline">
<input type="text" name="email" value="<?php echo $user['email'] ?>"  id="email" class="form-control" />
<label class="form-label" for="email">email </label>
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
<div class="row mb-4">
<div class="col">
<div data-mdb-input-init class="form-outline">
<input type="text" id="password_hash"    name="password_hash" class="form-control" placeholder="new password"/>
<label class="form-label"  for="password_hash">password</label>
<?php if (!empty($_SESSION['error_messages']['password_hash'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['password_hash'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
               <?php endif; ?>
</div>
</div>
<div class="col">
<div data-mdb-input-init class="form-outline mb-4">
<input type="text" id="role" value="<?php echo $user['role'] ?>"  name="role" class="form-control" />
<label class="form-label" for="role">role</label>
<?php if (!empty($_SESSION['error_messages']['role'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['role'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
    <?php endif; ?>
</div>
</div>
</div>
       <h3> personal Information :</h3>

  <div class="row mb-4">
    <div class="col">
      <div data-mdb-input-init class="form-outline">
        <input type="text" name="name" value="<?php echo $user['name']  ?>" id="Name" class="form-control" />
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
        <input type="text" name="registration_number" value="<?php echo $user['registration_number'] ?>" id="National_ID" class="form-control" />
        <label class="form-label" for="registration_number">registration ID</label>

        <?php if (!empty($_SESSION['error_messages']['registration_number'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['registration_number'] as $error): ?>
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
    <input type="text" name="phone_number" value="<?php echo $user['phone_number'] ?>"  class="form-control" />
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
   
    <div class="col">
    <div data-mdb-input-init class="form-outline">
        <input type="text" id="salary"  value="<?php echo  $user['salary'] ?>" name="salary" class="form-control" />
        <label class="form-label" for="salary">Salary($)</label>

        <?php if (!empty($_SESSION['error_messages']['salary'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['salary'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
       <?php endif; ?> 
      </div>
    </div>
  </div>


  <div class="row mb-4">
    
    <div class="col">
    <div data-mdb-input-init class="form-outline mb-4">
    <input type="date" id="hire_date"  value="<?php echo  $user['hire_date']?>" name="hire_date" class="form-control" />
    <label class="form-label" for="hire_date">Hire date </label>

    <?php if (!empty($_SESSION['error_messages']['hire_date'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['hire_date'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
       <?php endif; ?>
    </div>
    </div>

   <div class="col">
   <div data-mdb-input-init class="form-outline mb-4">
   <input type="date" id="date_birth"  value="<?php echo  $user['date_birth']?>" name="date_birth" class="form-control" />
    <label class="form-label" for="date_birth">date of birth </label>

    <?php if (!empty($_SESSION['error_messages']['date_birth'])): ?>
            <div class="text-danger">
                <?php foreach ($_SESSION['error_messages']['date_birth'] as $error): ?>
                    <span><?= htmlspecialchars('*'.$error) ?></span>
                <?php endforeach; ?>
            </div>
       <?php endif; ?>
   </div>
   </div>
  </div>

 

  <div class="d-flex justify-content-center">
    <button type="submit" name='submit' class="btn btn-primary me-2">submit</button>
   
    <button type="button" id ='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>
   </form>
   <?php 
   unset( $_SESSION['error_messages']);
   
   ?>
  </div>
  </div>
  </div>
 </div>
 </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="<?= BASE_PATH ?>/assets/js/user/editUser.js"></script>






 