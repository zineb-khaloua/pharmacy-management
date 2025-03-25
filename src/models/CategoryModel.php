<?php

namespace Models;
use PDO;
use Exception;
class CategoryModel{

    protected $db;

    public function __construct($db) {
       if(!$db){
        throw new \Exception ('database connexion is null');
       }
       $this->db=$db;
    }

    public function getAll(){
        $stmt=$this->db->prepare('SELECT * FROM category');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    public function add($data){
 
        $stmt=$this->db->prepare('INSERT INTO category (name , description)
                          VALUES(:name,:description)');
                          
        $stmt->bindParam(':name',$data['name']);       
        $stmt->bindParam(':description',$data['description']);  

        if ($stmt->execute())
        {
          return 'ok';
        }
        else{
          return 'error';
        }        
        
    }


    public function getCategory($id){
    try {
      $stmt=$this->db->prepare('SELECT * FROM category WHERE category_id =:id');
      $stmt->bindParam(':id',$id, PDO::PARAM_INT);
      $stmt->execute();
      $category=$stmt->fetch(PDO::FETCH_OBJ);

      if ($category) {
        error_log('category data: ' . print_r($category, true));
    } else {
        error_log('No data found for ID: ' . $id);
    }
    return $category;
    }
 
  catch(PDOException $e){

    error_log('error' .$e->getMessage());
    return null;
  }
}


public function update($data){
  try{
     $stmt=$this->db->prepare('UPDATE category SET 
                               name=:name ,
                              description =:description 
                              WHERE category_id=:id');

     $stmt->bindParam(':id',$data['id'], PDO::PARAM_INT);                      
     $stmt->bindParam(':name',$data['name']); 
     $stmt->bindParam(':description',$data['description']);   

     if ($stmt->execute()){
      return 'ok';
     }           
     else{
      return 'error';
     } 

    } catch(PDOException $e){
       error_log("error" . $e->getMessage());
       return null;
    }
           
}

public function delete($id){
  try{
      $stmt=$this->db->prepare('DELETE FROM category 
                            WHERE category_id=:id
                           ');
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);

  if ($stmt->execute()) {
    return 'ok'; 
} else {
    return 'No category found with the given ID.';
}
  }catch(PDOException $e)
  {
     error_log('error :' . $e->getMessage());
     return null;
  }

}




}