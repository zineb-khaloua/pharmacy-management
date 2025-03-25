<?php
namespace Models;

use PDO;
use Exception;

 class SupplierModel{

    protected $db;

    public function __construct($db){
       if(!$db){
        throw new \Exception('database connection is null');
       }
       $this->db= $db;

    }
    public function getAll(){
        $stmt=$this->db->prepare('SELECT * FROM supplier ');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function add($data){

        $stmt=$this->db->prepare('INSERT INTO supplier(name,phone_number,address,email,entity) 
                                  VALUES(:name ,:phone_number,:address,:email,:entity) ');
        $stmt->bindParam(':name',$data['name']);
        $stmt->bindParam(':phone_number',$data['phone_number']);
        $stmt->bindParam(':address',$data['address']);
        $stmt->bindParam(':email',$data['email']);
        $stmt->bindParam(':entity',$data['entity']);
        if ($stmt->execute())
        {
          return 'ok';
        }
        else{
          return 'error';
        }
    }
public function getSupplier($id){

  try{
      $stmt=$this->db->prepare('SELECT * FROM supplier
                             WHERE supplier_id=:id');
      $stmt->bindParam(':id',$id,PDO::PARAM_INT);
      $stmt->execute();
      $supplier=$stmt->fetch(PDO::FETCH_OBJ);


      if ($supplier) {
        error_log('category data: ' . print_r($supplier, true));
    } else {
        error_log('No data found for ID: ' . $id);
    }
    return $supplier;

  }catch(PDOException $e){
      error_log('error:' .$e->getMessage());
      return null;
  }
   
}

   public function update($data){
    try{

    
    $stmt=$this->db->prepare('UPDATE supplier SET 
                             name=:name,
                             phone_number=:phone_number,
                             address=:address,
                             email=:email,
                             entity=:entity
                             WHERE supplier_id=:id ');

    $stmt->bindParam(':id',$data['id'], PDO::PARAM_INT);                      
    $stmt->bindParam(':name',$data['name']); 
    $stmt->bindParam(':phone_number',$data['phone_number']);
    $stmt->bindParam(':address',$data['address']);  
    $stmt->bindParam(':email',$data['email']); 
    $stmt->bindParam(':entity',$data['entity']); 

    if($stmt->execute()){
       return 'ok';
    }
    else {
      return 'error';
    }
  }catch(PDOExeption $e)
  {
    error_log('error:' .$e->getMessage());
    return null;
  }
  }

  public function delete($id){
    
   try{
    $stmt=$this->db->prepare('DELETE FROM supplier 
                              WHERE supplier_id=:id');
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    if($stmt->execute())
    {
      return 'ok';
    }
    else {
      return 'No supplier found with the given id ';
    }
   }catch( PDOException $e )
   {
   error_log('error'.$e->getMessage());
   }
    

  }
  

}