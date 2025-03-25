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
          <a href="<?= BASE_PATH ?>/userSetting/<?= htmlspecialchars($user['user_id']) ?>"> <?php echo  $title ?> </a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          
          <div class="card-body">

<form action="<?= BASE_PATH ?>/userSetting/<?= htmlspecialchars($user['user_id']) ?>"  class="mt-4" method="POST" enctype="multipart/form-data">

<div class="settings-container mt-3 mb-3 margin-auto">
        <!-- Profile Picture -->
        <div class="profile-pic-container">
    <img src="<?= !empty($user['user_picture']) ? BASE_PATH . '/' . $user['user_picture'] : 'https://via.placeholder.com/130' ?>" 
         alt="Profile Picture" 
         class="profile-pic"  
         id="profileImage">
    <label for="profileUpload" class="upload-btn">
        <i class="fa fa-camera"></i>
    </label>
    <input type="file" name='user_picture' id="profileUpload" class="d-none" accept="image/*" onchange="loadProfileImage(event)">
   
  </div>
 <?php if(!empty($_SESSION['error_messages']['user_picture'])): ?>
    <div class='text-danger'>
      <?php foreach($_SESSION['error_messages']['user_picture'] as $error):?>
      <span> <?= htmlspecialchars('*'. $error) ?></span>
     <?php endforeach; ?>
    </div>
<?php endif; ?>
        <!-- User Settings Form -->

     
            <div class="mb-3">
                <input type="text" name='username' value="<?=$user['username']?>" class="form-control" placeholder="Full Name">
            <?php if(!empty($_SESSION['error_messages']['username'])):?>
             <div class='text-danger'>
             <?php foreach( $_SESSION['error_messages']['username'] as $error) : ?>
             <span> <?= htmlspecialchars('*'.$error)?></span>
             <?php endforeach;?>
             </div>
             <?php endif;?>
            </div>
            
            <div class="mb-3">
                <input type="email" name='email' value="<?=$user['email']?>" class="form-control" placeholder="Email">
           

                <?php if(!empty($_SESSION['error_messages']['email'])): ?>
                  <div class='text-danger'>
                    <?php foreach($_SESSION['error_messages']['email'] as $error):?>
                    <span> <?= htmlspecialchars('*'. $error) ?></span>
                  <?php endforeach; ?>
                  </div>
              <?php endif; ?>
           
              </div>
            <div class="mb-3">
                <input type="password" name='new_password' class="form-control" placeholder="New Password">
                <?php if(!empty($_SESSION['error_messages']['new_password'])): ?>
                <div class='text-danger'>
                  <?php foreach($_SESSION['error_messages']['new_password'] as $error):?>
                  <span> <?= htmlspecialchars('*'. $error) ?></span>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>

          
              </div>
            <div class="mb-3">
                <input type="text" name='role'  value="<?=$user['role']?>" class="form-control" placeholder="New Password" readonly>
                <?php if(!empty($_SESSION['error_messages']['role'])): ?>
                <div class='text-danger'>
                  <?php foreach($_SESSION['error_messages']['role'] as $error):?>
                  <span> <?= htmlspecialchars('*'. $error) ?></span>
                <?php endforeach; ?>
                </div>
               <?php endif; ?>
            
              </div>
           
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success btn-custom">update</button>
                <button type="reset" id="cancel-btn" class="btn btn-danger btn-custom">Cancel</button>
            </div>
            </div> 
        </form>
        <?php unset($_SESSION['error_messages']); ?>
    </div>
  </div>
  </div>
  </div>
 </div>
 </div>
    <script src="<?= BASE_PATH ?>/assets/js/user/userSetting.js"></script>
  