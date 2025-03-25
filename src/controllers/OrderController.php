<?php

namespace Controllers;
use Models\OrderModel;
use Helpers\ViewHelper;
use Helpers\UrlHelper;
use Helpers\SessionHelper;
use Helpers\Request;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Dompdf\Dompdf;
use Dompdf\Options;

class OrderController{
      protected $db;
      public function __construct($db){
             if(!$db){
                throw new Exception('database connection is null ');
             }
             $this->db=$db;
      }

      public function exportOrders()
      {
          $orderModel= new OrderModel($this->db);
          $orders=$orderModel->getAll();
  
          $pharmacyModel = new PharmacyModel($this->db);
          $pharmacy = $pharmacyModel->getPharmacy(); 
          
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
  
    $logoPath = !empty($pharmacy->logo) ? $pharmacy->logo : 'assets/img/logo/default_logo.png';
    if (file_exists($logoPath)) {
    
    $drawing = new Drawing();
    $drawing->setName('Pharmacy Logo');
    $drawing->setDescription('Pharmacy Logo');
    $drawing->setPath($logoPath);  
    $drawing->setCoordinates('A1'); 
    $drawing->setHeight(50); 
    $drawing->setWorksheet($sheet); 
    }

    
    $pharmacyName = !empty($pharmacy->name) ? $pharmacy->name : 'Pharmacy Name';
    $sheet->setCellValue('B2',  $pharmacyName);
    $sheet->getStyle('B2')->getFont()->setBold(true);
    $sheet->mergeCells('B2:C2'); 

    $pharmacyAddress = !empty($pharmacy->address) ? $pharmacy->address : '123 Pharmacy St, City'; 
    $sheet->setCellValue('I2',  $pharmacyAddress);
    $sheet->getStyle('I2')->getFont()->setBold(true);
   
    $sheet->getStyle('I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

          $headers = ['Order ID', 'Order Date', 'Delivery Date', 'Total Amount',
        'Urgent', 'Deadline', 'Status', 'Supplier Name','User Name'];
          $sheet->fromArray([$headers], NULL, 'A4');
  
          
          $row = 5;
          foreach ($orders as $order) {
              $sheet->setCellValue('A' . $row, $order->order_id);
              $sheet->setCellValue('B' . $row, $order->order_date);
              $sheet->setCellValue('C' . $row, $order->delivery_date);
              $sheet->setCellValue('D' . $row, $order->total_amount);
              $sheet->setCellValue('E' . $row, $order->urgent);
              $sheet->setCellValue('F' . $row, $order->deadline);
              $sheet->setCellValue('G' . $row, $order->status);
              $sheet->setCellValue('H' . $row, $order->supplier_name);
              $sheet->setCellValue('I' . $row, $order->user_name);
              $row++;
          }
  
          $filename = 'orders_export_' . date('Y-m-d') . '.xlsx';
  
          
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="' . $filename . '"');
          header('Cache-Control: max-age=0');
  
          ob_clean();
          flush();
         
          $writer = new Xlsx($spreadsheet);
          $writer->save('php://output');
  
          exit();
      }
  
      public function orderShow(){
        $orderModel= new OrderModel($this->db);
        $orders=$orderModel->getAll();
        $content= ViewHelper::render('order.php',[
            'title'=>'Order',
            'orders'=>$orders
        ]);

        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);


      }

      public function updateOrderStatus() {
       
            $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;
            $status = isset($_POST['status']) ? $_POST['status'] : null;
            //var_dump($_POST);
            //var_dump($order_id, $status);
            if ($order_id && $status) {
              
                $orderModel = new OrderModel($this->db);

                $updateSuccess = $orderModel->updateStatus($order_id, $status);
                //var_dump($updateSuccess);
                if ($updateSuccess) {
                  error_log("Failed to update order status for ID: $order_id");
                  echo json_encode(['status' => 'success', 'message' => 'status updated successfully.']);
                } else {
                  echo json_encode(['status' => 'error', 'message' => 'Failed to update.']);
                }
            } else {
              error_log("Invalid data received: order_id={$order_id}, status={$status}");
              echo json_encode(['status' => 'error', 'message' => 'invalis data.']);
             }
        }
    

      public function orderDetails($id)
    {
          $orderModel= new OrderModel($this->db); 
          $orderDetails=$orderModel->getOrderDetails($id);
          echo json_encode($orderDetails);
    }
      public function formAddOrder(){
        $orderModel= new OrderModel($this->db);
        $medicaments=$orderModel->getMedicaments();
        $suppliers=$orderModel->getSuppliers();
        $users=$orderModel->getUsers();
        $content = ViewHelper::render('addOrder.php',[
                 'title'=>'Order',
                 'titleAdd'=>'Add Order',
                 'medicaments'=>$medicaments,
                 'suppliers'=>$suppliers,
                 'users'=>$users
        ]);

        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
      }

      public function addOrder(){


        $rules = [
          'order_date' => 'required',
          'delivery_date' => 'required',
          'total_amount' => 'required',
          'urgent' => 'required',
          'deadline' => 'required',
          'status' => 'required',
          'supplier_id' => 'required',
          'user_id' => 'required'
        ];
        $data=[
          'order_date'=>$_POST['date_order'] ??'' ,
          'delivery_date'=>$_POST['date_delivery'] ??'',
          'total_amount'=>$_POST['total_amount'] ??'' ,
          'urgent'=>$_POST['urgent'] ??'' ,
          'deadline'=>$_POST['deadline'] ??'' ,
          'status'=>$_POST['status'] ??'',
          'supplier_id'=>$_POST['supplier_id'] ??'' ,
          'user_id'=>$_POST['user_id'] ??''
        ];
       
        //var_dump($medicamentData);
        // Add the order
       
        $request = new Request($rules);
        
        $validationResult = $request->validate($data);
        if (!empty($validationResult['errors'])) {
           
            echo json_encode([
              'status' => 'error',
              'errors' =>$validationResult['errors']
          ]);
          exit;
        }
        
        $orderModel = new OrderModel($this->db);
        $orderId = $orderModel->addOrder($validationResult['data']);

        if (!isset($_POST['medicament_data']) || empty($_POST['medicament_data'])) {
          echo json_encode([
            'status' => 'error',
            'message' => 'At least one medicament is required.']);
          exit;
      }

      
      $medicamentData = json_decode($_POST['medicament_data'], true);
      
        if ($orderId) {
          $errors = [];
            
            foreach ($medicamentData as $item) {
            
                $addedItem = $orderModel->addOrderItem(
                    $item['quantity'],
                    $item['price'],
                    $item['total'],
                    $orderId,
                    $item['medicament_id']
                );

                if (!$addedItem) {
                  $errors[] = 'Error adding item'; 
                }
            }

            if (!empty($errors)) {

              echo json_encode(['status' => 'success', 
              'orderId' => $orderId]);

               } else {
                echo json_encode(['status' => 'error', 
                'message' => 'Please add the medication items .']); 
           }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add order.']);
        }
    }
  
  

      public function editForm($id){

        $orderModel= new OrderModel($this->db);
        $order=$orderModel->getOrderToEdit($id);
        $suppliers=$orderModel->getSuppliers();
        $medicaments=$orderModel->getMedicaments();
        $items=$orderModel->getOrderItemToEdit($id);
        $content=ViewHelper::render('editOrder.php',[
          'title'=>'Order',
          'titleEdit'=>'Edit Order',
          'suppliers'=>$suppliers,
          'medicaments'=>$medicaments,
          'order'=>$order,
          'items'=>$items,
        ]);

        echo ViewHelper::render('master.php',[
          'content'=>$content
        ]);
      }



      public function updateOrderProcess($id) { 

        SessionHelper::startSession(); 
        $_SESSION['error_messages'] = []; 
    
        $rulesOrder = [
            'id' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'total_amount' => 'required',
            'urgent' => 'required|in:Yes,No',
            'status' => 'required|in:pending,completed,cancelled',
            'supplier_id' => '',
            'user_id' => ''
        ];
    
        $orderData = [
            'id' => $id,
            'order_date' => $_POST['dateOrder'],
            'delivery_date' => $_POST['dateDelivery'],
            'total_amount' => $_POST['total_amount'],
            'urgent' => $_POST['urgent'],
            'deadline' => $_POST['deadline'],
            'status' => $_POST['status'],
            'supplier_id' => !empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,
            'user_id' => !empty($_POST['user_id']) ? $_POST['user_id'] : null
        ];
    
        $requestOrder = new Request($rulesOrder);
        $validationOrderData = $requestOrder->validate($orderData);
    
        if (!empty($validationOrderData['errors'])) {
     
            $_SESSION['error_messages'] = $validationOrderData['errors'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
          }
    
        $rulesItems = [
            'item_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'medicament_id' => 'required|numeric'
        ];
    
        $orderItems = [];
        if (!empty($_POST['items'])) {
            foreach ($_POST['items'] as $item) {
                $validationItem = (new Request($rulesItems))->validate($item);
                if (!empty($validationItem['errors'])) {
                  foreach ($validationItem['errors'] as $field => $errors) {
                      $_SESSION['error_messages']["items_{$item['item_id']}"][$field] = $errors;
                      header('Location: ' . $_SERVER['HTTP_REFERER']);
                      exit;
                 
                  }
                }else {
                    $orderItems[] = [
                        'item_id' => $item['item_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['total'],
                        'medicament_id' => $item['medicament_id']
                    ];
                }
            }
        }
    
        $rulesNewItems = [
          'quantity' => 'required|numeric|min:1',
          'price' => 'required|numeric|min:0',
          'total' => 'required|numeric|min:0',
          'medicament_id' => 'required|numeric'
          
      ];
        $newItems = [];
        if (!empty($_POST['medicament_data'])) {
            $medicamentData = json_decode($_POST['medicament_data'], true);
            
            if (is_array($medicamentData)) {
                foreach ($medicamentData as $newItem) {

                    $validationNewItem = (new Request($rulesNewItems))->validate($newItem);
                    if (!empty($validationNewItem['errors'])) {

                      $_SESSION['error_messages'] = $validationNewItem['errors'];
                      header('Location: ' . $_SERVER['HTTP_REFERER']);
                      exit;

                      } else {
                        $newItems[] = [
                            'quantity' => $newItem['quantity'],
                            'price' => $newItem['price'],
                            'total' => $newItem['total'],
                            'medicament_id' => $newItem['medicament_id'],
                            'order_id' => $id
                            
                        ];
                   
                    }
                }
            }
        }
    
   
     
      $orderModel= new OrderModel($this->db);
      $result = $orderModel->updateOrderWithItems($orderData, $orderItems, $newItems);
    
        if ($result === "success") {
            $_SESSION['success'] = "Order updated successfully. !";
        } else {
            $_SESSION['error'] = "An error occurred while updating.";
        }
    
        UrlHelper::redirect('/order');
        exit;
    }
    

      public function deleteOrder($id){

        $orderModel= new OrderModel($this->db);
        $result=$orderModel->deleteOrder($id);
        if($result=='ok'){
          UrlHelper::redirect('/order');
        }
        else{
          echo $result;
        }
      }


      public function deleteOrderItem($itemId,$orderId) {
        $orderModel = new OrderModel($this->db);
        $result = $orderModel->deleteOrderItem($itemId);
        //header('Content-Type: application/json'); // Ensure the response is JSON
  
        if ($result) {
           $orderModel->updateOrderTotal($orderId);
           echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully.']);

           
        }  else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete item.']);
        }
    
  }



  public function invoiceCreate($orderId)
{
    $orderModel = new OrderModel($this->db);
    
    $items = $orderModel->getOrderDetails($orderId);
    $order = $orderModel->getOrderToEdit($orderId);
    
   
    $html = ViewHelper::render('invoiceOrder.php', [
        'order' => $order,
        'items' => $items
    ]);


    $options = new Options();
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    
    $dompdf->stream("Invoice_$orderId.pdf", ["Attachment" => false]);
}




}