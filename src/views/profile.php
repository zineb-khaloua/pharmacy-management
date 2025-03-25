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
          <a href="<?= BASE_PATH ?>/profile"> <?=$title ?></a>
        </li>
      </ul>
    </div>

    <div class="row">
      
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">

          <div class="d-flex align-items-center">
    <h4 class="card-title"><?= $title ?></h4>
    <div class="ms-auto d-flex gap-2">
        <a href="<?= BASE_PATH ?>/export-patients" class="btn btn-success btn-round">
            <i class="fa fa-solid fa-file-export"></i>
            Export
        </a>
        
        <a href="<?= BASE_PATH ?>/addProfile"
                class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i>
                Add Profile
        </a>
      
    </div>
</div>

          
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="add-row"
                class="display table table-striped table-hover"
              >
                <thead>
                  <tr>
                    <th>name</th>
                    <th >registration NB</th>
                    <th>phone</th>
                    <th>email</th>
                    <th>salary</th>
                    <th>hire date</th>
                    <th >date birth</th>
                    <th >action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>name</th>
                    <th >registration NB</th>
                    <th>phone</th>
                    <th>email</th>
                    <th>salary</th>
                    <th>hire date</th>
                    <th >date birth</th>
                    <th >action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($profils as $profile) :?>
                  <tr>
                    <td><?= htmlspecialchars($profile->name  );?></td>
                    <td><?= htmlspecialchars($profile->registration_number ?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($profile->phone_number ?? 'Non spécifiée'); ?></td>
                    <td><?= htmlspecialchars($profile->email ?? 'Non spécifiée' );?></td>
                    <td><?= htmlspecialchars($profile->salary ?? 'Non spécifiée' ); ?></td>
                     <td><?= htmlspecialchars($profile->hire_date?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($profile-> date_birth?? 'Non spécifiée' ); ?></td>
                   
                    <td>
                      <div class="form-button-action">
                        <a href="<?= BASE_PATH ?>/editProfile/<?= $profile->user_id; ?>" 
                        class="btn btn-link btn-primary btn-lg">
                        <i class='fa fa-edit'></i> 
                        </a>

                        <a href="#" class="btn btn-link btn-danger"
                         onclick="confirmDelete(<?php echo $profile->user_id; ?>)">
                          <i class="fa fa-trash"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= BASE_PATH ?>/assets/js/profile/profile.js"></script>