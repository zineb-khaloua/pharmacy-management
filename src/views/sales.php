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
          <a href="<?= BASE_PATH ?>/sales"> <?=$title ?></a>
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
                  <a href="<?= BASE_PATH ?>/export-sales" class="btn btn-success btn-round">
                      <i class="fa fa-solid fa-file-export"></i>
                      Export
                  </a>
                  <a href="<?= BASE_PATH ?>/addSale" class="btn btn-primary btn-round">
                      <i class="fa fa-plus"></i>
                      Add Sale
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
                    
                  <th>#sale</th>
                    <th>date</th>
                    <th>credit</th> 
                    <th>patient</th>
                    <th>user</th> 
                    <th>Total</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#sale</th>
                    <th>date</th>
                    <th>credit</th>
                    <th>patient</th>
                    <th>user</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                      

                        <?php foreach ($sales as $sale ): ?>
                          <tr>
                          
                            <td><?= htmlspecialchars($sale->sales_id); ?></td>
                            <td><?= htmlspecialchars($sale->sale_date ?? 'Non spécifiée'); ?></td>
                            <td><?= htmlspecialchars($sale->credit ?? 'Non spécifiée'); ?></td>
                            <td>
                            <?php if ($sale->patient_id !== NULL): ?>
                                    <?= htmlspecialchars($sale->patient_name); ?>
                                <?php else: ?>
                                    <span style="color: red;">Deleted Patient</span>
                                <?php endif; ?>
                           </td>
                            <td>
                                <?php if ($sale->user_id !== NULL): ?>
                                    <?= htmlspecialchars($sale->user_name); ?>
                                <?php else: ?>
                                    <span style="color: red;">Deleted User</span>
                                <?php endif; ?>
                            </td> 
                            <td><?= htmlspecialchars($sale->total_price ?? 'Non spécifiée'); ?></td>
                            <td>
                                <div class="form-button-action">
                                  
                                  <a onclick="showSaleDetails(<?= $sale->sales_id; ?>)" 
                                    class="btn btn-sm btn-success">
                                    <i class="fa fa-light fa-eye"></i>
                                  </a>
                                  <a href="<?= BASE_PATH ?>/editSale/<?= $sale->sales_id; ?>" 
                                    class="btn btn-sm btn-primary">
                                    <i class='fa fa-edit'></i>  
                                  </a>
                                  
                                  <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
                  
                                  <a href="#" class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete(<?= $sale->sales_id; ?>)">
                                    <i class="fa fa-trash"></i>
                                  </a>
                                  <?php endif; ?>
                                  <a href="#" class="btn btn-sm btn-warning" 
                                    onclick="generateInvoice(<?= $sale->sales_id;?>)">
                                    <i class="fa fa-thin fa-file-invoice"></i>                                                                                                                   
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


  <!-- --Modal--- -->

<div class="modal fade" id="saleDetailsModal" tabindex="-1" role="dialog" aria-labelledby="saleDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleDetailsModalLabel">Détails de la vente</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Medicament </th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Prescription</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="saleDetailsTableBody">
                        <!-- -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_PATH ?>/assets/js/sales/sales.js"></script>