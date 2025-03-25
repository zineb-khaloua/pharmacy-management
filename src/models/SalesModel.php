<?php
namespace Models;

use PDO;
use Exception;
class SalesModel{
  protected $db;

  public function __construct($db){

    if(!$db){
        throw new \Exception('database connection is null');
    }
    $this->db=$db;
  }

 
  public function getAllSales() {
    $stmt = $this->db->prepare("SELECT 
    s.sales_id,
    s.total_price,
    s.sale_date,
    s.credit,
    s.user_id,
    s.patient_id,
    p.name AS patient_name,
    u.username AS user_name
FROM sales s
LEFT JOIN user u ON s.user_id = u.user_id
LEFT JOIN patient p ON s.patient_id = p.patient_id
");
$stmt->execute();
return  $stmt->fetchAll(PDO::FETCH_OBJ);
}


public function getSaleDetails($saleId) {
  $stmt = $this->db->prepare("
      SELECT 
          si.item_id,
          si.sale_id,
          si.quantity,
          si.price,
          si.prescription,
          si.total,
          si.medicament_id,
          m.name AS medicament_name
      FROM sale_items si
      LEFT JOIN medicament m ON si.medicament_id = m.medicament_id
      WHERE si.sale_id = ?
  ");
  $stmt->execute([$saleId]);
  return $stmt->fetchAll(PDO::FETCH_OBJ);
}


public function getMedicaments(){
  $stmt=$this->db->prepare('SELECT medicament_id ,name,price from medicament');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);


}
public function getPatients(){
  $stmt=$this->db->prepare('SELECT patient_id ,name from patient');
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);

}


public function addSale($data) {
  $stmt = $this->db->prepare("INSERT INTO sales (total_price, sale_date, credit, patient_id, user_id) 
                              VALUES (:total_price, :sale_date, :credit, :patient_id, :user_id)");

  $stmt->bindParam(':total_price', $data['total_price']);
  $stmt->bindParam(':sale_date', $data['sale_date']);
  $stmt->bindParam(':credit', $data['credit']);
  $stmt->bindParam(':patient_id', $data['patient_id']);
  $stmt->bindParam(':user_id', $data['user_id']);

  $stmt->execute();

  return $this->db->lastInsertId();
}


public function addSaleItem($sale_id, $medicament_id, $quantity,$prescription, $price, $total) {
  $stmt = $this->db->prepare("INSERT INTO sale_items (sale_id,medicament_id,quantity,prescription,price,total) 
                              VALUES (:sale_id,:medicament_id,:quantity,:prescription,:price ,:total)");
  $stmt->bindParam(':sale_id', $sale_id);
  $stmt->bindParam(':medicament_id', $medicament_id);
  $stmt->bindParam(':quantity', $quantity);
  $stmt->bindParam(':prescription', $prescription);
  $stmt->bindParam(':price', $price);
  $stmt->bindParam(':total', $total);
  $stmt->execute();
}



public function getSalesToEdit($id){
  $stmt=$this->db->prepare('SELECT 
    s.sales_id,
    s.total_price,
    s.sale_date,
    s.credit,
    s.patient_id,
    s.user_id,
    p.name AS patient_name,
    u.username AS user_name
FROM sales s
LEFT JOIN user u ON s.user_id = u.user_id
LEFT JOIN patient p ON s.patient_id = p.patient_id 
WHERE s.sales_id=:id');
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetch(PDO::FETCH_OBJ);
}


public function getItemsToEdit($id){

  $stmt=$this->db->prepare(' SELECT 
          si.item_id,
          si.sale_id,
          si.medicament_id,
          si.quantity,
          si.price,
          si.prescription,
          si.total,
          m.name AS medicament_name
      FROM sale_items si
      LEFT JOIN medicament m ON si.medicament_id = m.medicament_id
      WHERE si.sale_id = :id ');

  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_OBJ);
}



public function updateSaleWithItem($data , $saleItems, $newItems= []){

try{
  $this->db->beginTransaction();


  $stmt=$this->db->prepare('  UPDATE sales SET 
               total_price =:total_price,
               sale_date=:sale_date,
               credit=:credit,
               patient_id=:patient_id,
               user_id=:user_id
               WHERE sales_id=:id 
  
  ');


  $stmt->bindParam(':id',$data['id'],PDO::PARAM_INT);
  $stmt->bindParam(':total_price',$data['total_price']);
  $stmt->bindParam(':sale_date',$data['sale_date']);
  $stmt->bindParam(':credit',$data['credit']);
  $stmt->bindParam(':patient_id',$data['patient_id']);
  $stmt->bindParam(':user_id',$data['user_id']);
if (!$stmt->execute())
{
  throw new Exception("Échec de la mise à jour de la commande.");
}




  if(!empty($saleItems))
  {
     foreach($saleItems as $item){
      $stmt=$this->db->prepare('UPDATE sale_items 
      SET medicament_id = :medicament_id, 
          quantity = :quantity, 
          price = :price, 
          prescription = :prescription, 
          total = :total 
          WHERE item_id = :id ');

      $stmt->bindParam(':id',$item['item_id'],PDO::PARAM_INT);
      $stmt->bindParam(':medicament_id', $item['medicament_id']);
      $stmt->bindParam(':quantity', $item['quantity']);
      $stmt->bindParam(':price', $item['price']);
      $stmt->bindParam(':prescription', $item['prescription']);
      $stmt->bindParam(':total', $item['total']);
      if(!$stmt->execute())
      {
        throw new Exception("Échec de la mise à jour de l'article ID: " . $item['item_id']);
      }
     }
  }  else {
    throw new Exception("Aucun article à mettre à jour."); 
}    
        


         if(!empty($newItems)){
          foreach($newItems as $item){
            $stmt = $this->db->prepare('INSERT INTO sale_items (sale_id,medicament_id,quantity,prescription,price,total)
            VALUES(:sale_id, :medicament_id,:quantity ,:prescription, :price , :total )');
               
               $stmt->bindParam(':sale_id', $item['sale_id']); 
                $stmt->bindParam(':medicament_id', $item['medicament_id']);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':prescription', $item['prescription']);
                $stmt->bindParam(':price', $item['price']); 
                $stmt->bindParam(':total', $item['total']); 

                if (!$stmt->execute()) {
                  throw new Exception("Échec de l'ajout d'un nouvel article.");
              }
          }
         }
$this->db->commit();
return 'sale update with succefully';

}catch(Exception $e){
  $this->db->rollback();
  return 'error'. $e->getMessage();
}

}



public function delete($id){
  try{
  $stmt=$this->db->prepare('DELETE FROM sales WHERE sales_id=:id');
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
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


 public function deleteSaleItem($itemId) {

    $stmt = $this->db->prepare("DELETE FROM sale_items WHERE item_id = :itemId");
    $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
    return $stmt->execute();

}
 

public function updateSaleTotal($sale_id){
    
  $stmt = $this->db->prepare('SELECT SUM(total) AS new_total FROM sale_items WHERE sale_id = :sale_id');
  $stmt->bindParam(':sale_id', $sale_id);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  $new_total = $result->new_total;


  $updateStmt = $this->db->prepare('UPDATE sales SET total_price = :new_total WHERE sales_id = :sale_id');
  $updateStmt->bindParam(':new_total', $new_total);
  $updateStmt->bindParam(':sale_id', $sale_id);
  return $updateStmt->execute();
}


 

}