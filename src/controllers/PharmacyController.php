<?php 

namespace Controllers;

use Models\PharmacyModel;
use Helpers\ViewHelper;
use Helpers\UrlHelper;
use Helpers\Request;
use Helpers\SessionHelper;

class PharmacyController{

    protected $db;

     public function __construct($db) {
         if (!$db) {
             throw new \Exception("Database connection is null.");
         }
         $this->db = $db;
     }

     
    public function pharmacy(){
        $pharmacyModel = new PharmacyModel($this->db);
        $pharmacy= $pharmacyModel->getPharmacy();
 
        $content= ViewHelper::render('pharmacy.php', [
         'title' => 'Pharmacy',
         'pharmacy'=> $pharmacy
        
     ]);
        echo ViewHelper::render('master.php', [
         'content' => $content
     ]);
     }
     
     public function updatePharmacy($id) {


        $pharmacyModel = new PharmacyModel($this->db);
    
        $existingPharmacy = $pharmacyModel->getPharmacyById($id);
    
        $logo = $existingPharmacy->logo;
    
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
            $targetDir = "logo/"; 
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); 
            }
    
            $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '', $_FILES["logo"]["name"]);
            $targetFilePath = $targetDir . $fileName;
    
           
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFilePath)) {
               
                $logo = $targetFilePath;
            }
        }
    
        $rules = [
            'id' =>'required',
            'name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'opening_hours' => 'required',
            'logo' => 'required'
        ];
        $data = [
            'id' => $id,
            'name' => $_POST['name'],
            'address' => $_POST['address'],
            'phone_number' => $_POST['phone_number'],
            'email' => $_POST['email'],
            'opening_hours' => $_POST['opening_hours'],
            'logo' => $logo 
        ];
    

        $request = new Request($rules);
        $validationData = $request->validate($data);

        if (!empty($validationData ['errors'])) {
           
            SessionHelper::startSession();
             $_SESSION['error_messages'] =   $validationData ['errors'];
             header('Location: ' . $_SERVER['HTTP_REFERER']);
              exit;
       
            
         }

        $pharmacy = $pharmacyModel->update($validationData['data']);
    
        
        if ($pharmacy) {
            UrlHelper::redirect('/dashboard');
        } else {
            var_dump($pharmacy); 
        }
    }
    
}
