<?php

namespace Models;

use PDO;
use Exception;

class PharmacyModel
{
    protected $db;

    public function __construct($db)
    {
      if(!$db){
            throw new \Exception ('database connection is null ');
      }
      $this->db=$db;
    }

    public function getPharmacy()
    {
    
       $stmt = $this->db->prepare('SELECT * FROM pharmacy');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function getPharmacyById($id)
    {
       $stmt = $this->db->prepare('SELECT * FROM pharmacy where pharmacy_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
public function update($data)
{
    try {
        $stmt = $this->db->prepare("UPDATE pharmacy SET
            name = :name,
            address = :address,
            phone_number = :phone_number,
            email = :email,
            opening_hours = :opening_hours,
            logo = :logo
            WHERE pharmacy_id = :id
        ");

        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':phone_number', $data['phone_number']);  
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':opening_hours', $data['opening_hours']);
        $stmt->bindParam(':logo', $data['logo']);
      
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
    } catch (PDOException $e) {
        error_log('Error: ' . $e->getMessage());
        return null;
    }
}
}