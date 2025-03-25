<?php
use Helpers\SessionHelper;
SessionHelper::startSession();
ob_start();
?>

<form action="<?= BASE_PATH ?>/updatePharmacy/<?= htmlspecialchars($pharmacy->pharmacy_id) ?>"  class="mt-4" method="POST" enctype="multipart/form-data">

<div class="settings-container mt-3 mb-3">
       <div class="profile-pic-container">
       <img src="<?= !empty($pharmacy->logo) ? BASE_PATH . '/' . $pharmacy->logo . '?t=' . time() : 'https://via.placeholder.com/130' ?>" 
     alt="Logo Picture" 
     class="profile-pic" 
     id="profileImage">
    <label for="logoUpload" class="upload-btn">
        <i class="fa fa-camera"></i>
    </label>

    <input type="file" name="logo" id="logoUpload" class="d-none" accept="image/*" onchange="loadProfileImage(event)">
</div>

<?php  if(!empty($_SESSION['error_messages']['logo'])) : ?>
    <div class='text-danger'>
        <?php foreach($_SESSION['error_messages']['logo'] as $error) : ?> 
            <span> <?php htmlspecialchars('*'. $error) ?></span> 
        <?php endforeach;  ?>

    </div>
<?php endif; ?>
            <div class="mb-3">
                <input type="text" name='name' value="<?php echo $pharmacy->name; ?>" class="form-control" >     
            </div>

            <?php if(!empty($_SESSION['error_messages']['name'])): ?>
                <div class='text-danger'>
                  <?php foreach($_SESSION['error_messages']['name'] as $error):?>
                  <span> <?= htmlspecialchars('*'. $error) ?></span>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <input type="email" name='email'  value="<?php echo $pharmacy->email; ?>" class="form-control" >
            </div>
            <?php if(!empty($_SESSION['error_messages']['email'])): ?>
                <div class='text-danger'>
                  <?php foreach($_SESSION['error_messages']['email'] as $error):?>
                  <span> <?= htmlspecialchars('*'. $error) ?></span>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <input type="text" name='phone_number' value="<?php echo $pharmacy->phone_number; ?>" class="form-control" >
            </div>
            <?php  if(!empty($_SESSION['error_messages']['phone_number'])) : ?>
                <div class='text-danger'>
                    <?php foreach($_SESSION['error_messages']['phone_number'] as $error) : ?> 
                        <span> <?= htmlspecialchars('*'.$error) ?></span> 
                    <?php endforeach;  ?>

                </div>
            <?php endif; ?>
            <div class="mb-3">
                <input type="text" name='address'  value="<?php echo$pharmacy->address; ?>"  class="form-control" >
            </div>
            <?php  if(!empty($_SESSION['error_messages']['address'])) : ?>
                <div class='text-danger'>
                    <?php foreach($_SESSION['error_messages']['address'] as $error) : ?> 
                        <span> <?= htmlspecialchars('*'. $error) ?></span> 
                    <?php endforeach;  ?>

                </div>
            <?php endif; ?>
            <div class="mb-3">
                <input type="text" name='opening_hours' value="<?php echo $pharmacy->opening_hours; ?>" class="form-control" >
            
        </div>
            <?php  if(!empty($_SESSION['error_messages']['opening_hours'])) : ?>
                <div class='text-danger'>
                    <?php foreach($_SESSION['error_messages']['opening_hours'] as $error) : ?> 
                        <span> <?= htmlspecialchars('*'. $error) ?></span> 
                    <?php endforeach;  ?>

                </div>
            <?php endif; ?>
           
           
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success btn-custom">update</button>
                <button type="reset" id="cancel-btn" class="btn btn-danger btn-custom">Cancel</button>
            </div>
        </form>
        <?php unset($_SESSION['error_messages']) ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="<?= BASE_PATH ?>/pharmacy/pharmacy.js"></script>