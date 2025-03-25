<?php

use Helpers\SessionHelper;
SessionHelper::startSession();
ob_start();
?>

<div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3"><?= $titleEdit ?></h3>
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
          <a href="<?= BASE_PATH ?>/order"><?= $title ?> </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
       
        <li class="nav-item">
          <a href="<?= BASE_PATH ?>/editOrder"><?= $titleEdit?></a>
        </li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title"> <?=$titleEdit?></h4>
            </div>
          </div>
          <div class="card-body">

       <form id="editOrderForm" action="<?= BASE_PATH ?>/editOrder/<?php echo $order->order_id ?>" method="POST">
        
    <input type="hidden" name="order_id" value="<?= $order->order_id ?>">
    


 <div class="row mb-4">
    <div class="col"> 
 <div data-mdb-input-init class="form-outline">
  <input type="date" name="dateOrder" value="<?php echo $order->order_date ?>" id="dateOrder" class="form-control"  />
  <label class="form-label" for="dateOrder">date order:</label>
  <?php if (!empty($_SESSION['error_messages']['dateOrder'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['dateOrder'] as $error): ?>
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
       <input type="date" name="deadline" value="<?php echo $order->deadline ?>" id="deadline" class="form-control"  />
       <label class="form-label" for="deadline">deadline:</label>
       <?php if (!empty($_SESSION['error_messages']['deadline'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['deadline'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
    </div>
    <div class="col"> 
<div data-mdb-input-init class="form-outline">
  <input type="date" name="dateDelivery" value="<?php echo $order->delivery_date ?>" id="dateDelivery" class="form-control"  />
  <label class="form-label" for="dateDelivery">date delivery:</label>
  <?php if (!empty($_SESSION['error_messages']['dateDelivery'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['dateDelivery'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</div>
  
</div>

<div class="row mb-4">
<div class="col">
        <select name="status" id="status" class="form-control">

        
          <option value="<?php echo $order->status ?>" selected ><?php echo $order->status ?></option>

          <option value="pending">pending</option>
          <option value="completed">completed</option>
          <option value="cancelled" >cancelled</option>
        </select>
        <label for="status" class="form-label">status:</label>

        <?php if (!empty($_SESSION['error_messages']['status'])): ?>
        <div class="text-danger">
            <?php foreach ($_SESSION['error_messages']['status'] as $error): ?>
                <span><?= htmlspecialchars('*'.$error) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="col">
            <label class="form-label me-3" for="urgent">Urgent:</label>
            <div class="form-check form-check-inline">
            <input type="radio" id="urgent_yes" name="urgent" value="Yes" <?= strtolower($order->urgent ?? '') === 'yes' ? 'checked' : '' ?> class="form-check-input">
                <label for="urgent_yes" class="form-check-label">Yes</label>
            </div>
            <div class="form-check form-check-inline">
            <input type="radio" id="urgent_no" name="urgent" value="No" <?= strtolower($order->urgent  ?? '') === 'no' ? 'checked' : '' ?> class="form-check-input">
            <label for="urgent_no" class="form-check-label">No</label>
            </div>
            <?php if (!empty($_SESSION['error_messages']['urgent'])): ?>
                <div class="text-danger">
                    <?php foreach ($_SESSION['error_messages']['urgent'] as $error): ?>
                        <span><?= htmlspecialchars('*'.$error) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
</div>  



<div class="row">
        <div class="col">
          <div data-mdb-input-init class="form-outline">
            <input type="text"
            value="<?php echo $order->user_name ?>"
            id="username" name="username" class="form-control" readonly />
            <input type="hidden" 
              value="<?php echo $order->user_id ?>"
              id="user_id" name="user_id" />
            <label class="form-label" for="user_id">user:</label>
            <?php if ($order->user_id === NULL): ?>
                <span style="color: red;">(* Deleted User)</span>
            <?php endif; ?></label>
          </div>
        </div>

        <div class="col">
        <select name="supplier_id" id="supplier" class="form-control">
          
        <option value="<?php echo $order->supplier_id ?>" selected><?php echo $order->supplier_name ?></option>

        <?php foreach ($suppliers as $supplier): ?>
          <option value="<?php echo $supplier->supplier_id?>">
              <?= htmlspecialchars($supplier->name) ?>
          </option>
        <?php endforeach; ?>

        </select>

        <label for="supplier_id" class="form-label">supplier:</label>
        <?php if ($order->supplier_id === NULL): ?>
        <span style="color: red;">(* Deleted Supplier)</span>
        <?php endif; ?></label>
    </div>
    </div> 

<div class="row"> 
<div class="col">
<div data-mdb-input-init class="form-outline">
<input type="number" value="<?php echo $order->total_amount ?>" name="total_amount" id="generalTotal" class="form-control" readonly />
<label class="form-label text-dark fw-bold fs-5 " for="total_amount"> <strong > General Total: </strong> </label>
</div>
</div>


<?php $counter = 1; ?>
<?php foreach ($items as $item): ?>
    <h5 class="mt-5" >Medicament <?= $counter ?>:</h5>
    <input type="hidden" name="items[<?= $item->item_id ?>][item_id]" value="<?= $item->item_id ?>">
   
    <div class="row mb-4">
        <div class="col">
        <select class="form-control" name="items[<?= $item->item_id ?>][medicament_id]" id="medicament_id_<?= $item->item_id ?>">
               <option value="" selected disabled><?= $item->medicament_name ?></option>
                <?php foreach ($medicaments as $medicament): ?>
                    <option value="<?= $medicament->medicament_id ?>" data-price="<?= $medicament->price; ?>" <?= $medicament->medicament_id == $item->medicament_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($medicament->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="medicament_id_<?= $item->item_id ?>">Medicament:</label>

           
        <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['medicament_id'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['medicament_id'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
        </div>

        <div class="col">
        <input type="number" name="items[<?= $item->item_id ?>][quantity]" value="<?= $item->quantity ?>" class="form-control" id="quantity_<?= $item->item_id ?>"  oninput="calculateItemTotal(<?= $item->item_id ?>)"    min="1" >
        <label for="quantity_<?= $item->item_id ?>">Quantity:</label>

  
        <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['quantity'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['quantity'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    
        </div>
    </div>

    <div class="row mb-4">
        <div class="col">
        <input type="number" name="items[<?= $item->item_id ?>][price]" value="<?= $item->price ?>" class="form-control" id="price_<?= $item->item_id ?>" oninput="calculateItemTotal(<?= $item->item_id ?>)">
          <label for="price_<?= $item->item_id ?>">Price:</label>

          <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['price'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['price'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    
        </div>
       
    </div>

    <div class="row mb-4">
        <div class="col">
        <input type="number" name="items[<?= $item->item_id ?>][total]" value="<?= $item->total ?>" class="form-control" id="total_<?= $item->item_id ?>" >
        <label for="total_<?= $item->item_id ?>">Total:</label>

        <?php if (!empty($_SESSION['error_messages']["items_{$item->item_id}"]['total'])): ?>
            <div class="text-danger">
             <?php foreach ($_SESSION['error_messages']["items_{$item->item_id}"]['total'] as $error): ?>
            <span><?= htmlspecialchars('*'.$error) ?></span>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
        </div>
    </div>
    <?php $counter++; ?>
<?php endforeach; ?>

<div class="row mb-4">
<div class="col text-center">

 <button type="button" class="btn btn-success btn-round ms-auto"
  data-toggle="modal" data-target="#addMedicamentModal">
  Add Medicaments
  <i class="fa fa-plus"></i>
</button>
</div>
</div>
</div>

<div class="card-body">
            <div class="table-responsive">

<h3>Medicaments</h3>
       <table class="table table-bordered" id="selectedItemsTable">
           <thead>
               <tr>
                   <th>Medicament</th>
                   <th>Quantity</th>
                   <th>Price</th>
                   <th>total</th>
               </tr>
           </thead>
           <tbody>
               <!-- Les lignes seront ajoutées dynamiquement ici -->
           </tbody>
           <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Total General</td>
                    <td id="totalGeneral" style="text-align: right; font-weight: bold;">0.00</td>
                </tr>
            </tfoot>
       </table>
   </div>
   </div>

    <!-- Submit button -->
  <div class="d-flex justify-content-center">
  <input type="hidden" id="medicament_data" name="medicament_data" value="[]">
    <button type="submit" name='submit' class="btn btn-primary me-2">Submit</button>
    <button type="button" id='cancel-btn' class="btn btn-danger">Cancel</button>
  </div>
  </form>
  <?php 
  unset($_SESSION['error_messages']);
  ?>
  </div>
  </div>
  </div>
 </div>

   <!--\\\\\\\ Modal\\\\\\\\\\\ -->
   <div class="modal fade" id="addMedicamentModal" tabindex="-1" role="dialog" aria-labelledby="addMedicamentModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="addMedicamentModalLabel">Add Medicaments </h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <form id="modalForm">
                       <div class="form-group">
                           <label for="modal_medicament_id">Medicament:</label>
                           <select class="form-control" name="medicament_id" id="modal_medicament_id" required>
                           
                                 <?php foreach ($medicaments as $medicament): ?>
                                   <option value="<?php echo $medicament->medicament_id?>"
                                           data-price="<?php echo $medicament->price; ?>">
                                           <?= htmlspecialchars($medicament->name) ?>
                                   </option>
                               <?php endforeach; ?>
                               <!-- Ajoutez d'autres options selon vos besoins -->
                           </select>
                       </div>
                       <div class="form-group">
                           <label for="modal_quantity">Quantity:</label>
                           <input type="number" class="form-control" id="modal_quantity"  min="1" required>
                       </div>
                       <div class="form-group">
                           <label for="modal_price">Price:</label>
                           <input type="number" class="form-control" id="modal_price"  required>
                       </div>
                       <div class="form-group">
                           <label for="modal_total">total:</label>
                           <input type="number" class="form-control" id="modal_total"  required>
                       </div>
                       <button type="button" class="btn btn-primary" id="saveModalData">Save</button>
                   </form>
               </div>
           </div>
       </div>
   </div>
 <!-- Modal End  -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script src="<?= BASE_PATH ?>/assets/js/order/editOrder.js"> </script>