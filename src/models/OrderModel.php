<?php
namespace Models;
use PDO;
use Exception;
class OrderModel{
    protected $db;
    public function __construct($db){
        if(!$db){
            throw new Exception('database connection is null');
        }
        $this->db=$db;
    }

    public function getAll(){
        $stmt=$this->db->prepare('SELECT 
                              o.*,
                              s.name AS supplier_name,
                              u.username AS user_name
                              FROM `order` o
                              LEFT JOIN supplier s ON o.supplier_id = s.supplier_id
                              LEFT JOIN user u ON o.user_id =u.user_id ');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function updateStatus($order_id, $status) {
        $query = "UPDATE `order` SET status = :status WHERE order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    
    public function getOrderDetails($orderId) {
        $stmt = $this->db->prepare("
            SELECT 
                o.item_id,
                o.order_id,
                o.quantity,
                o.price,
                o.total,
                o.medicament_id,
                m.name AS medicament_name
            FROM order_items o
            LEFT JOIN medicament m ON o.medicament_id = m.medicament_id
            WHERE o.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
   
    public function getMedicaments(){
        $stmt=$this->db->prepare('SELECT medicament_id ,name,price from medicament');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    
    }
    
    public function getSuppliers(){
        $stmt=$this->db->prepare('SELECT supplier_id ,name from supplier');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    
    }

    public function getUsers(){
        $stmt=$this->db->prepare('SELECT user_id ,username from user');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function addOrder($data) {
        try {
            $stmt = $this->db->prepare('INSERT INTO `order` 
            (order_date, delivery_date, total_amount, urgent, deadline, status, supplier_id, user_id)
            VALUES (:order_date, :delivery_date, :total_amount, :urgent, :deadline, :status, :supplier_id, :user_id)');
            
            $stmt->bindParam(':order_date', $data['order_date']);
            $stmt->bindParam(':delivery_date', $data['delivery_date']);
            $stmt->bindParam(':total_amount', $data['total_amount']);
            $stmt->bindParam(':urgent', $data['urgent']);
            $stmt->bindParam(':deadline', $data['deadline']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':supplier_id', $data['supplier_id']);
            $stmt->bindParam(':user_id', $data['user_id']);
            
            $stmt->execute();
            return $this->db->lastInsertId();
            
        } catch (PDOException $e) {
            die("Error inserting order: " . $e->getMessage());
        }
    }

public function addOrderItem($quantity ,$price,$total,$order_id,$medicament_id){
  $stmt=$this->db->prepare('INSERT INTO order_items (quantity ,price,total,order_id,medicament_id)
                            VALUES(:quantity , :price , :total , :order_id , :medicament_id)');
    
     $stmt->bindParam(':quantity',$quantity);
     $stmt->bindParam(':price',$price);
     $stmt->bindParam(':total',$total);
     $stmt->bindParam(':order_id',$order_id);
     $stmt->bindParam(':medicament_id',$medicament_id);
     $stmt->execute();                      
}

public function getOrderToEdit($id){
    $stmt=$this->db->prepare('SELECT 
                 o.order_id,
                 o.order_date,
                 o.delivery_date,
                 o.total_amount,
                 o.urgent,
                 o.deadline,
                 o.status,
                 o.supplier_id,
                 o.user_id,
                 s.name AS supplier_name,
                 u.username AS user_name
  FROM `order` o
  LEFT JOIN user u ON o.user_id = u.user_id
  LEFT JOIN supplier s ON o.supplier_id = s.supplier_id 
  WHERE o.order_id=:id');
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_OBJ);
  }


public function getOrderItemToEdit($id){

     $stmt=$this->db->prepare(' SELECT 
          oi.item_id,
          oi.order_id,
          oi.medicament_id,
          oi.quantity,
          oi.price,
          oi.total,
          m.name AS medicament_name
      FROM order_items oi
      LEFT JOIN medicament m ON oi.medicament_id = m.medicament_id
      WHERE oi.order_id = :id ');

$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_OBJ);
}



public function updateOrderWithItems($data, $orderItems, $newItems = []) {
    try {
        $this->db->beginTransaction(); 
        
       
        $stmt = $this->db->prepare('UPDATE `order` SET 
                     order_date = :order_date,
                     delivery_date = :delivery_date,
                     total_amount = :total_amount,
                     urgent = :urgent,
                     deadline = :deadline,
                     status = :status,
                     supplier_id = :supplier_id,
                     user_id = :user_id
                     WHERE order_id = :id');
        
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':order_date', $data['order_date']);
        $stmt->bindParam(':delivery_date', $data['delivery_date']);
        $stmt->bindParam(':total_amount', $data['total_amount']);
        $stmt->bindParam(':urgent', $data['urgent']);
        $stmt->bindParam(':deadline', $data['deadline']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':supplier_id', $data['supplier_id']);
        $stmt->bindParam(':user_id', $data['user_id']);

        if (!$stmt->execute()) {
            throw new Exception("Order update failed.");
        }

        if (!empty($orderItems)) {
            foreach ($orderItems as $item) {
                $stmt = $this->db->prepare('UPDATE order_items 
                            SET  
                                quantity = :quantity, 
                                price = :price,  
                                total = :total,
                                medicament_id = :medicament_id
                            WHERE item_id = :id');
                
                $stmt->bindParam(':id', $item['item_id'], PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':price', $item['price']);
                $stmt->bindParam(':total', $item['total']);
                $stmt->bindParam(':medicament_id', $item['medicament_id']);

                if (!$stmt->execute()) {
                    throw new Exception("Failed to update item ID: " . $item['item_id']);
                }
            }
        } else {
            throw new Exception("No item to update."); 
        }


        if (!empty($newItems)) {
            foreach ($newItems as $item) {
                $stmt = $this->db->prepare('INSERT INTO order_items (quantity, price, total, order_id, medicament_id)
                                    VALUES(:quantity, :price, :total, :order_id, :medicament_id)');
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':price', $item['price']);
                $stmt->bindParam(':total', $item['total']);
                $stmt->bindParam(':order_id', $item['order_id']);
                $stmt->bindParam(':medicament_id', $item['medicament_id']);

                if (!$stmt->execute()) {
                    throw new Exception("Failed to add a new item..");
                }
            }
        }
        
       
        $this->db->commit();
        return "Order updated successfully.";
        
    } catch (Exception $e){
    $this->db->rollBack(); 
    return "Erreur : " . $e->getMessage();
}
}


public function deleteOrder($order_id){
   
   try{
    $stmt=$this->db->prepare('DELETE FROM `order` WHERE order_id=:order_id');
    $stmt->bindParam(':order_id',$order_id,PDO::PARAM_INT);
    if ($stmt->execute())
    {
        return 'ok';
    }   
    else{
        return 'error';
    }
    }catch(PDOException $e){
     error_log('error'.$e->getMessage());
    }
}

public function deleteOrderItem($item_id){
    $stmt = $this->db->prepare('DELETE FROM order_items WHERE item_id = :item_id');
    $stmt->bindParam(':item_id', $item_id);
    return $stmt->execute();
}


public function updateOrderTotal($order_id){
    
    $stmt = $this->db->prepare('SELECT SUM(total) AS new_total FROM order_items WHERE order_id = :order_id');
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    $new_total = $result->new_total;

   // var_dump($new_total);

    $updateStmt = $this->db->prepare('UPDATE `order` SET total_amount = :new_total WHERE order_id = :order_id');
    $updateStmt->bindParam(':new_total', $new_total);
    $updateStmt->bindParam(':order_id', $order_id);
    return $updateStmt->execute();
}









}