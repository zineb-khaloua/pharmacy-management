<?php

namespace Models;
use PDO;
class MedicamentModel{

public function __construct($db){

    if(!$db){
        throw new \Exception('database connection is null');
    }
    $this->db=$db;
}


public function getAll(){
    $stmt=$this->db->prepare('SELECT 
                              m.medicament_id,
                              m.name ,
                              m.reference_code,
                              m.price,
                              m.quantity_in_stock,
                              m.laboratory,
                              m.expired_date,
                              m.reimbursable,
                              m.prescription,
                              m.supplier_id,
                              m.category_id,
                              s.name AS supplier_name,
                              c.name AS category_name
                              FROM medicament m
                              LEFT JOIN supplier s ON m.supplier_id = s.supplier_id
                              LEFT JOIN category c ON m.category_id =c.category_id
 ');
 $stmt->execute();
 return $stmt->fetchAll(PDO::FETCH_OBJ);
}



public function getAllCategories(){
    $stmt=$this->db->prepare('SELECT category_id , name FROM category');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


public function getAllSuppliers(){
    $stmt=$this->db->prepare('SELECT supplier_id, name FROM supplier');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

// generate New Reference Code

public function getLastReferenceCode() {
    $stmt = $this->db->prepare("SELECT reference_code FROM medicament ORDER BY medicament_id DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['reference_code'] : null;
}

public function generateNewReferenceCode() {
    $lastReference = $this->getLastReferenceCode();

    if ($lastReference) {
        $numericPart = intval(substr($lastReference, 2));
        $newNumericPart = str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT);
    } else {
        $newNumericPart = str_pad(1, 8, '0', STR_PAD_LEFT);
    }

    return 'FA' . $newNumericPart;
}


//////////////////////////Add Medicament////////////////

public function add($data){
  
$stmt=$this->db->prepare('INSERT INTO medicament (name ,reference_code,price,quantity_in_stock,laboratory,expired_date,Reimbursable,prescription,supplier_id,category_id)
                          VALUES(:name,:reference_code,:price,:quantity_in_stock,:laboratory,:expired_date,:reimbursable,:prescription,:supplier_id,:category_id)');

   $stmt->bindParam(':name',$data['name']);       
   $stmt->bindParam(':reference_code',$data['reference_code']); 
   $stmt->bindParam(':price',$data['price']);       
   $stmt->bindParam(':quantity_in_stock',$data['quantity_in_stock']); 
   $stmt->bindParam(':laboratory',$data['laboratory']);    
   $stmt->bindParam(':expired_date',$data['expired_date']);    
   $stmt->bindParam(':reimbursable',$data['reimbursable']); 
   $stmt->bindParam(':prescription',$data['prescription']);       
   $stmt->bindParam(':supplier_id',$data['supplier_id']); 
   $stmt->bindParam(':category_id',$data['category_id']); 



   if($stmt->execute()){
    return 'ok';
   }
   else{
    return 'error';
   }
   
}

public function getMedicament($id){

    try{
    $stmt=$this->db->prepare('SELECT 
                              m.medicament_id,
                              m.name ,
                              m.reference_code,
                              m.price,
                              m.quantity_in_stock,
                              m.laboratory,
                              m.expired_date,
                              m.Reimbursable,
                              m.prescription,
                              m.supplier_id,
                              m.category_id,
                              s.name AS supplier_name,
                              c.name AS category_name
                              FROM medicament m
                              LEFT JOIN supplier s ON m.supplier_id = s.supplier_id
                              LEFT JOIN category c ON m.category_id =c.category_id 
                              WHERE medicament_id=:id');
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $medicament= $stmt->fetch(PDO::FETCH_OBJ);
    if($medicament) {
        error_log('category data: ' . print_r($medicament, true));
    }
    else{
        error_log('No data found for ID: ' . $id);
    }
    return $medicament;

    }catch(PDOException $e){
        error_log('error' .$e->getMessage());
        return null;
    }
  

}


public function update($data){
    try{
         $stmt=$this->db->prepare('UPDATE medicament SET
                                 name=:name,
                                 reference_code =:reference_code,
                                 price=:price,
                                 quantity_in_stock=:quantity_in_stock,
                                 laboratory=:laboratory,
                                 expired_date=:expired_date,
                                 reimbursable=:reimbursable,
                                 prescription=:prescription,
                                 supplier_id=:supplier_id,
                                 category_id=:category_id
                                 WHERE medicament_id=:medicament_id');

        $stmt->bindParam(':medicament_id',$data['medicament_id'], PDO::PARAM_INT);                      
        $stmt->bindParam(':name',$data['name']); 
        $stmt->bindParam(':reference_code',$data['reference_code']);
        $stmt->bindParam(':price',$data['price']);                      
        $stmt->bindParam(':quantity_in_stock',$data['quantity_in_stock']); 
        $stmt->bindParam(':laboratory',$data['laboratory']);
        $stmt->bindParam(':expired_date',$data['expired_date']);
        $stmt->bindParam(':reimbursable',$data['reimbursable']); 
        $stmt->bindParam(':prescription',$data['prescription']);
        $stmt->bindParam(':supplier_id',$data['supplier_id']);                      
        $stmt->bindParam(':category_id',$data['category_id']); 
       
        if($stmt->execute()){
            return 'ok';
        }
        else{
            return 'error';
        }
    }catch(PDOExeption $e){
      error_log('error'.$e->getMessage());
    }
   
}


public function delete($id){
    try{
    $stmt=$this->db->prepare('DELETE FROM medicament WHERE medicament_id=:id');
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




   
}