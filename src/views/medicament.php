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
          <a href="<?= BASE_PATH ?>/medicament"> <?=$title ?></a>
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
                <a href="<?= BASE_PATH ?>/export-medicaments" class="btn btn-success btn-round">
                    <i class="fa fa-solid fa-file-export"></i>
                    Export
                </a>
                <a href="<?= BASE_PATH ?>/addMedicament" class="btn btn-primary btn-round">
                    <i class="fa fa-plus"></i>
                    Add Medicament
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
                    <th>category</th>
                    <th >reference</th>
                    <th>price</th>
                    <th>QTY</th>
                    <th>laboraty</th>
                    <th>expiry date</th>
                    <th>reimbursable</th>
                    <th>prescription</th>
                    <th>supplier</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                  <th>Name</th>
                    <th>category</th>
                    <th >reference</th>
                    <th>price</th>
                    <th>QTY</th>
                    <th>laboraty</th>
                    <th>expiry date</th>
                    <th>reimbursable</th>
                    <th>prescription</th>
                    <th>supplier</th>
                    <th >Action</th>
                
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($medicaments as $medicament) :?>
                  <tr>
                    <td><?= htmlspecialchars($medicament->name ?? 'Non spécifiée' );?></td>
                   
                    <td>
                         <?php if ($medicament->category_id !== NULL): ?>
                                    <?= htmlspecialchars($medicament->category_name); ?>
                                     <?php else: ?>
                                    <span style="color: red;">Deleted Category</span>
                         <?php endif; ?>
        
                    </td>
                    <td><?= htmlspecialchars($medicament->reference_code ?? '' ); ?></td>
                    <td><?= htmlspecialchars($medicament->price ?? ' '); ?></td>
                    <td><?= htmlspecialchars($medicament->quantity_in_stock ?? ' ' );?></td>
                    <td><?= htmlspecialchars($medicament->laboratory ?? ' ' ); ?></td>
                    <td>
                         <?php if ($medicament->expired_date >= date('Y-m-d')): ?>
                                    <?= htmlspecialchars($medicament->expired_date); ?>
                                     <?php else: ?>
                                    <span style="color: red;"><?= htmlspecialchars($medicament->expired_date); ?></span>
                         <?php endif; ?>
        
                    </td>
                    <td><?= htmlspecialchars($medicament->reimbursable?? ' ' ); ?></td>
                    <td><?= htmlspecialchars($medicament->prescription ?? ' ' ); ?></td>
                    <td>
                    
                         <?php if ($medicament->supplier_id !== NULL): ?>
                                    <?= htmlspecialchars($medicament->supplier_name); ?>
                                <?php else: ?>
                                    <span style="color: red;">Deleted Supplier</span>
                         <?php endif; ?>
                   </td>
                    
                    <td>
                      <div class="form-button-action">
                        <a href="<?= BASE_PATH ?>/editMedicament/<?=$medicament->medicament_id; ?>" 
                        class="btn btn-link btn-primary btn-lg">
                        <i class='fa fa-edit'></i> 
                        </a>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
                  
                        <a href="#" class="btn btn-link btn-danger"
                         onclick="confirmDelete(<?php echo $medicament->medicament_id; ?>)">
                          <i class="fa fa-trash"></i>
                        </a>
                        <?php endif; ?>
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
  

  <script src="<?= BASE_PATH ?>/assets/js/medicament/medicament.js"></script>
   
