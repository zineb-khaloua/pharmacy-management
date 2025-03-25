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
          <a href="<?= BASE_PATH ?>/patient"> <?=$title ?></a>
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
        <a href="<?= BASE_PATH ?>/addPatient"
                class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i>
                Add Patient
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
                    <th>Name</th>
                    <th >National ID</th>
                    <th>Date Birth</th>
                    <th>Adresse</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th >Name</th>
                    <th >National ID</th>
                    <th>Date Birth</th>
                    <th>Adresse</th>
                    <th>Phone </th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($patients as $patient) :?>
                  <tr>
                    <td><?= htmlspecialchars($patient->name ?? 'Non spécifiée' );?></td>
                    <td><?= htmlspecialchars($patient->National_ID ?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($patient->dob ?? 'Non spécifiée'); ?></td>
                    <td><?= htmlspecialchars($patient->address ?? 'Non spécifiée' );?></td>
                    <td><?= htmlspecialchars($patient->phone_number ?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($patient->email?? 'Non spécifiée' ); ?></td>
                    <td>
                      <div class="form-button-action">
                        <a href="<?= BASE_PATH ?>/editPatient/<?= $patient ->patient_id; ?>" 
                        class="btn btn-link btn-primary btn-lg">
                        <i class='fa fa-edit'></i> 
                        </a>

                        <a href="#" class="btn btn-link btn-danger"
                         onclick="confirmDelete(<?php echo $patient->patient_id; ?>)">
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
  <script src="<?= BASE_PATH ?>/assets/js/patient/patient.js"></script>
  
    