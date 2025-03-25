<?php

namespace Models;

use PDO;
use PDOException;

class UserModel {
    protected $db;
    
 public function __construct($db) {
    if (!$db) {
        throw new \Exception("Database connection is null.");
    }
    $this->db = $db;
}

public function getUsers()
{
    
        $stmt = $this->db->prepare('SELECT u.user_id, u.username, u.email, u.role,u.user_picture, 
                                            p.profile_id, p.registration_number, p.name, p.phone_number, 
                                            p.salary, p.hire_date, p.date_birth
                                     FROM user u
                                     LEFT JOIN profile p ON u.user_id = p.user_id
                                     WHERE u.user_id = p.user_id');
         $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
     
}  

public function findByUsername($username){
    $stmt=$this->db->prepare("SELECT * FROM user WHERE username =:username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getUserById($userId)
{
$stmt = $this->db->prepare('SELECT u.user_id, u.username, u.email,u.password_hash, u.role,u.user_picture, 
                                           p.profile_id, p.registration_number, p.name, p.phone_number, 
                                           p.salary, p.hire_date, p.date_birth
                                    FROM user u
                                    LEFT JOIN profile p ON u.user_id = p.user_id  
                                    WHERE u.user_id= :userId ');
$stmt->bindParam(':userId',$userId);
$stmt->execute();
return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateUser($userData){
    $stmtUser = $this->db->prepare("UPDATE user  SET username =:username, email=:email, password_hash =:password_hash,role =:role, user_picture=:user_picture
                                   WHERE user_id=:userId");

$stmtUser->bindParam(':userId', $userData['userId']);
$stmtUser->bindParam(':username', $userData['username']);
$stmtUser->bindParam(':email', $userData['email']);
$stmtUser->bindParam(':password_hash', $userData['password']);
$stmtUser->bindParam(':role', $userData['role']);
$stmtUser->bindParam(':user_picture', $userData['user_picture']);

if ($stmtUser->execute()){
    return 'ok';
   }           
   else{
    return 'error';
   } 
}


//--------------------------registred users ----------------------------



public function createUserAndProfile($userData, $profileData)
{
    try {
        $this->db->beginTransaction();

        $stmtUser = $this->db->prepare("INSERT INTO user (username, email, password_hash,role, user_picture)
                                        VALUES (:username, :email, :password,:role, :user_picture)");

        $stmtUser->bindParam(':username', $userData['username']);
        $stmtUser->bindParam(':email', $userData['email']);
        $stmtUser->bindParam(':password', $userData['password']);
        $stmtUser->bindParam(':role', $userData['role']);
        $stmtUser->bindParam(':user_picture', $userData['user_picture']);

        if (!$stmtUser->execute()) {
            $this->db->rollBack();
            return 'Error inserting user';
        }

        $userId = $this->db->lastInsertId();

        $stmtProfile = $this->db->prepare("INSERT INTO profile (user_id, registration_number, name, phone_number, email, salary, hire_date, date_birth) 
                                           VALUES (:user_id, :registration_number, :name, :phone_number, :email, :salary, :hire_date, :date_birth)");

        $stmtProfile->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtProfile->bindParam(':registration_number', $profileData['registration_number']);
        $stmtProfile->bindParam(':name', $profileData['name']);
        $stmtProfile->bindParam(':phone_number', $profileData['phone_number']);
        $stmtProfile->bindParam(':email', $profileData['email']);
        $stmtProfile->bindParam(':salary', $profileData['salary']);
        $stmtProfile->bindParam(':hire_date', $profileData['hire_date']);
        $stmtProfile->bindParam(':date_birth', $profileData['date_birth']);

        if (!$stmtProfile->execute()) {
            $this->db->rollBack();
            return 'Error inserting profile';
        }

        $this->db->commit();
        return 'ok';

    } catch (PDOException $e) {
        $this->db->rollBack(); 
        error_log('Transaction error: ' . $e->getMessage());
        return 'error: ' . $e->getMessage();
    }
}





public function updateUserAndProfile($userData, $profileData)
{
    try {
        
        $this->db->beginTransaction();

      
        $stmtUser = $this->db->prepare("UPDATE user SET
            username = :username,
            email = :email,
            password_hash = :new_password,
            user_picture = :user_picture
            WHERE user_id = :userId
        ");

        $stmtUser->bindParam(':userId', $userData['userId'], PDO::PARAM_INT);
        $stmtUser->bindParam(':username', $userData['username']);
        $stmtUser->bindParam(':email', $userData['email']);
        $stmtUser->bindParam(':new_password', $userData['new_password']);
        $stmtUser->bindParam(':user_picture', $userData['user_picture']);

        if (!$stmtUser->execute()) {
            $this->db->rollBack();
            return 'error updating user';
        }

      
        $stmtProfile = $this->db->prepare("UPDATE profile SET 
            registration_number = :registration_number,
            name = :name,
            phone_number = :phone_number,
            email = :email,
            salary = :salary,
            hire_date = :hire_date,
            date_birth = :date_birth 
            WHERE user_id = :userId
        ");

        $stmtProfile->bindParam(':userId', $userData['userId'], PDO::PARAM_INT);
        $stmtProfile->bindParam(':registration_number', $profileData['registration_number']);
        $stmtProfile->bindParam(':name', $profileData['name']);
        $stmtProfile->bindParam(':phone_number', $profileData['phone_number']);
        $stmtProfile->bindParam(':email', $profileData['email']);
        $stmtProfile->bindParam(':salary', $profileData['salary']);
        $stmtProfile->bindParam(':hire_date', $profileData['hire_date']);
        $stmtProfile->bindParam(':date_birth', $profileData['date_birth']);

        if (!$stmtProfile->execute()) {
            $this->db->rollBack();
            return 'error updating profile';
        }

        $this->db->commit();
        return 'ok';

    } catch (PDOException $e) {
        $this->db->rollBack();
        error_log('Update error: ' . $e->getMessage());
        return 'error: ' . $e->getMessage();
    }
}



public function delete($userId){
    $stmt = $this->db->prepare('DELETE FROM user WHERE user_id = :userId');
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        return 'ok';
    } else {
        return 'error';
    }
}

}
