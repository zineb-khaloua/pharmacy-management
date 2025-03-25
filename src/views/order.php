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
          <a href="<?= BASE_PATH ?>/order"> <?=$title ?></a>
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
        <a href="<?= BASE_PATH ?>/export-orders" class="btn btn-success btn-round">
            <i class="fa fa-solid fa-file-export"></i>
            Export
        </a>
        <a href="<?= BASE_PATH ?>/addOrder" class="btn btn-primary btn-round">
            <i class="fa fa-plus"></i>
            Add Order
        </a>
    </div>
</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table
                id="add-row"
                class="display table table-striped table-sm"
              >
                <thead>
                  <tr>
                    
                  <th>#order</th>
                    <th >date</th>
                    <th>delivery</th>
                    <th>Total</th>
                    <th>urgent</th>
                    <th>deadline</th>
                    <th>status</th>
                    <th>supplier</th>
                    <th>user</th>
                    <th >Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>#order</th>
                    <th >date</th>
                    <th>delivery</th>
                    <th>Total</th>
                    <th>urgent</th>
                    <th>deadline</th>
                    <th>status</th>
                    <th>supplier</th>
                    <th>user</th>
                    <th >Action</th>
                
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach($orders as $order) :?>
                  <tr>
                    <td><?= htmlspecialchars($order->order_id ?? 'Non spécifiée' );?></td>
                    <td><?= htmlspecialchars($order->order_date ?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($order->delivery_date ?? 'Non spécifiée'); ?></td>
                    <td><?= htmlspecialchars($order->total_amount ?? 0);?></td>
                    <td><?= htmlspecialchars($order->urgent ?? 'Non spécifiée' ); ?></td>
                    <td><?= htmlspecialchars($order->deadline?? 'Non spécifiée' ); ?></td>
                    <td>
                    <select class="status-dropdown" data-order-id="<?= $order->order_id; ?>" 
                    onchange="updateSelectColor(this)" 
                    <?= $order->status == 'completed' ? 'disabled' : ''; ?>>
                        <option   value="pending" <?= $order->status == 'pending' ? 'selected' : ''; ?>>pending</option>
                        <option  value="completed" <?= $order->status == 'completed' ? 'selected' : ''; ?>>completed</option>
                        <option   value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : ''; ?>>cancelled</option>
                    </select>
                    </td>
                    <td>
                                <?php if ($order->supplier_id !== NULL): ?>
                                    <?= htmlspecialchars($order->supplier_name); ?>
                                <?php else: ?>
                                    <span style="color: red;">Deleted Supplier</span>
                                <?php endif; ?>
                     </td> 
                    <td>
                                <?php if ($order->user_id !== NULL): ?>
                                    <?= htmlspecialchars($order->user_name); ?>
                                <?php else: ?>
                                    <span style="color: red;">Deleted User</span>
                                <?php endif; ?>
                     </td>
                    <td>
                      <div class="form-button-action">
                      <a onclick="showOrderDetails(<?= $order->order_id; ?>)" 
                                    class="btn btn-sm btn-success">
                                    <i class="fa fa-light fa-eye"></i>
                      </a>
                        <a href="<?= BASE_PATH ?>/editOrder/<?=$order->order_id; ?>" 
                        class="btn btn-sm btn-primary btn-lg">
                        <i class='fa fa-edit'></i> 
                        </a>
                        
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?> 
                  
                        <a href="#" class="btn btn-sm btn-danger"
                         onclick="confirmDelete(<?php echo $order->order_id; ?>)">
                          <i class="fa fa-trash"></i>
                        </a>
                        <?php endif; ?>
                        <a href="#" class="btn btn-sm btn-warning" 
                                    onclick="generateInvoice(<?= $order->order_id;?>)">
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


  
  <!-- ******************Modal******************** -->
 
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Details</h5>
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
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="orderDetailsTableBody">
                        <!-- Les détails de la vente seront chargés ici -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

 


<script src="<?= BASE_PATH ?>/assets/js/order/order.js"></script>
    