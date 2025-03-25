<?php

namespace Models;

use PDO;
use Exception;
class PatientModel{

    protected $db;

    public function __construct($db)
    {
      if(!$db){
            throw new \Exception ('database connection is null ');
      }
      $this->db=$db;
    }

    public function getAll()
    {
        $stmt=$this->db->prepare('SELECT * FROM patient');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function Add($data)
    {

      //check if national_id already exists
      $checkStmt=$this->db->prepare('SELECT COUNT(*) FROM patient WHERE national_id = :national_id'); 
      $checkStmt->bindParam(':national_id',$data['national_id']);
      $checkStmt->execute();
      $count=$checkStmt->fetchColumn();

      if ($count > 0) {
        return array('status' => 'error', 'message' => 'National ID already exists.');
    }
      $stmt=$this->db->prepare("INSERT INTO patient (name, national_id, dob, address, phone_number, email) 
                                   VALUES (:name, :national_id, :dob, :address, :phone, :email)" );

        $stmt->bindParam(':name',$data['name']);  
        $stmt->bindParam(':national_id',$data['national_id']); 
        $stmt->bindParam(':dob',$data['dob']); 
        $stmt->bindParam(':address',$data['address']);                          
        $stmt->bindParam(':phone',$data['phone']); 
        $stmt->bindParam(':email',$data['email']);

        if ($stmt->execute()) {
          return  array('status' => 'success', 'message' => 'Patient added successfully.');
      } else {
          return  array('status' => 'error', 'message' => 'Failed to add patient.');
      }

}
public function getPatient($id){
  
 try{
      $stmt =$this->db->prepare('SELECT * FROM patient WHERE patient_id=:id ');
     
      $stmt->execute(array(':id' => $id));
      $patients=$stmt->fetch(PDO::FETCH_OBJ);
     
        if ($patients) {
          error_log('Patient data: ' . print_r($patients, true));
      } else {
          error_log('No data found for ID: ' . $id);
      }
      return $patients;
    }
    
  catch(PDOException $e)
 {
        error_log('error: ' . $e->getMessage());
        return null;
 }
}

public function update($data) {

  try{
    
  $stmt=$this->db->prepare ( " UPDATE patient SET 
          name = :name,
          National_ID = :national_id,
          dob = :dob,
          address = :address,
          phone_number = :phone,
          email = :email
      WHERE patient_id = :id
  ");


 
  $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
  $stmt->bindParam(':name', $data['name']);
  $stmt->bindParam(':national_id', $data['national_id']);
  $stmt->bindParam(':dob', $data['dob']);
  $stmt->bindParam(':address', $data['address']);
  $stmt->bindParam(':phone', $data['phone']);
  $stmt->bindParam(':email', $data['email']);
  if( $stmt->execute()){
    return 'ok';
}
else{ 
    return 'error';
}
  
  
  }
 catch (PDOException $e) {
      error_log("Error during patient update: " . $e->getMessage());
      return 'error: ' . $e->getMessage();
}
}

public function delete($id) {
       
  try {
    
      $stmt =$this->db->prepare('DELETE FROM patient WHERE patient_id = :id');
      
      
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
          return 'ok'; 
      } else {
          return 'No patient found with the given ID.';
      }

  } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
      return null;
  }
}
}
