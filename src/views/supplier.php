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
          <a href="<?= BASE_PATH ?>/supplier"> <?=$title ?></a>
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
                  <a href="<?= BASE_PATH ?>/export-suppliers" class="btn btn-success btn-round">
                      <i class="fa fa-solid fa-file-export"></i>
                      Export
                  </a>
                  <a href="<?= BASE_PATH ?>/addSupplier" class="btn btn-primary btn-round">
                      <i class="fa fa-plus"></i>
                      Add Supplier
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
                    <th >phone</th>
                    <th>address</th>
                    <th>Email</th>
                    <th>entity</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th >phone</th>
                    <th>address</th>
                    <th>Email</th>
                    <th>entity</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($suppliers as $supplier) :?>
                  <tr>
                    <td><?= htmlspecialchars($supplier->name ?? 'Non spécifiée' );?></td>
                    <td><?= htmlspecialchars($supplier->phone_number ?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($supplier->address ?? 'Non spécifiée' );?></td>
                    <td><?= htmlspecialchars($supplier->email?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($supplier->entity ?? 'Non spécifiée' ); ?></td>
                    <td>
                      <div class="form-button-action">
                        <a href="<?= BASE_PATH ?>/editSupplier/<?= $supplier ->supplier_id; ?>" 
                        class="btn btn-link btn-primary btn-lg">
                        <i class='fa fa-edit'></i> 
                        </a>

                        <a href="#" class="btn btn-link btn-danger"
                         onclick="confirmDelete(<?php echo $supplier->supplier_id; ?>)">
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
  
<script src="<?= BASE_PATH ?>/assets/js/supplier/supplier.js"> </script>

