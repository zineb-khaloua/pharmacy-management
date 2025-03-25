<?php 

namespace Controllers;

use Models\UserModel;
use Models\PharmacyModel;
use Helpers\SessionHelper;
use Helpers\UrlHelper;
use Helpers\ViewHelper;
use Helpers\Request;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UserController{

    protected $db;

    public function __construct($db) {
        if (!$db) {
            throw new \Exception("Database connection is null.");
        }
        $this->db = $db;
    }


    public function loginForm()
    {
        require_once  VIEWS . 'user.php';
    }

 
    public function login()
    {
       
        SessionHelper::startSession(); 
       

        $username =trim($_POST['username']);
        $password =trim($_POST['password']);

         
          if (empty($username) || empty($password)) {

        
              $_SESSION['alert']=[
                'type'=>'warning',
                'message'=>'veuillez remplir tout les champs'
              ];

              UrlHelper::redirect('/login');
              
        }

 

        $userModel = new UserModel($this->db);
        $user = $userModel->findByUsername($username);
       // var_dump($user); 
        if ($user && password_verify($password, $user['password_hash'])) {
            
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_picture'] = $user['user_picture'];

            //var_dump($_SESSION);
            $_SESSION['alert']=[
                'type'=>'success',
                'message'=>'Bienvenue '.$user['username']
            ];


            UrlHelper::redirect('/dashboard');
            
        } else {
          
            $_SESSION['alert']=[
                'type'=>'danger',
                'message'=>'Identifiants incorrects.Reessayer'
            ];
            UrlHelper::redirect('/login');
        }
    }

   
    public function dashboard(){
        $content=ViewHelper::render('dashboard.php',[
            'title'=>'Dashboard'
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
   }


    public function userShow($userId){

        $userModel= new UserModel($this->db);
        $user=$userModel->getUserById($userId);
        
        $content=ViewHelper::render('userSetting.php',[
            'title'=>'User Setting',
            'user'=>$user
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content,
          
        ]);
    }
    //-----------export users --------
    public function exportUsers()
    {
        $userModel = new UserModel($this->db);
        $users = $userModel->getUsers();
    
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
        $sheet->setCellValue('B2', $pharmacyName);
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->mergeCells('B2:C2');
    
        $pharmacyAddress = !empty($pharmacy->address) ? $pharmacy->address : '123 Pharmacy St, City';
        $sheet->setCellValue('I2', 'Address: ' . $pharmacyAddress);
        $sheet->getStyle('I2')->getFont()->setBold(true);
        $sheet->getStyle('I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    
        $headers = [ 'user_picture','Name', 'Registration NB', 'Phone', 'Email', 'Salary', 'Hire Date', 'Date Birth','username', 'role',];
        $sheet->fromArray([$headers], NULL, 'B5');
    
        $row = 6;
        foreach ($users as $user) {
            $sheet->setCellValue('B' . $row, $user['user_picture']);
            $sheet->setCellValue('C' . $row, $user['name']);
            $sheet->setCellValue('D' . $row, $user['registration_number']);
            $sheet->setCellValue('E' . $row, $user['phone_number']);
            $sheet->setCellValue('F' . $row, $user['email']);
            $sheet->setCellValue('G' . $row, $user['salary']);
            $sheet->setCellValue('H' . $row, $user['hire_date']);
            $sheet->setCellValue('I' . $row, $user['date_birth']);
            $sheet->setCellValue('j' . $row, $user['username']);
            $sheet->setCellValue('k' . $row, $user['role']);

            $row++;
        }

        $filename = 'users_export_' . date('Y-m-d') . '.xlsx';
    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        ob_clean();
        flush();
    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    
        exit();
    }
    


    //-------------- show all users and profile----------------
   

     public function authentificationInfo(){
        $userModel= new UserModel($this->db);
        $users=$userModel->getUsers();
        $content=ViewHelper::render('authenInfo.php',[
            'title'=>'Users Infos',
            'users'=>$users
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
       }
//--------------------add user and profile----------------

    public function formAddUser(){
        $content=ViewHelper::render('addUser.php',[
            'title'=>'Users',
            'titleAdd'=>'Add User'
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
    }

    public function addUser(){

    SessionHelper::startSession();

$userRules=[
    'username' => 'required',
    'email' => 'required|email',
    'password_hash' => 'required',
    'role' => 'required',
    'user_picture' => 'required'

];

$profilRules=[
    'registration_number' => 'required',
    'name' => 'required',
    'email' => 'required|email',
    'phone_number' => 'required',
    'salary' => 'required',
    'hire_date' => 'required',
    'date_birth' => 'required'
  
];

        if (isset($_FILES['user_picture']) && $_FILES['user_picture']['error'] === 0) {
            $targetDir = "uploads/"; 
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '', $_FILES["user_picture"]["name"]);
            $targetFilePath = $targetDir . $fileName;
        
            if (move_uploaded_file($_FILES["user_picture"]["tmp_name"], $targetFilePath)) {
                $imagePath = $targetFilePath; 
                $_SESSION['old_data']['user_picture'] = $imagePath;
                //echo "File uploaded successfully: " . $imagePath . "<br>"; // Debugging line
            } else {
                $_SESSION['error_messages']['user_picture'][] = "File upload failed!";
            }
        } else {
            $_SESSION['error_messages']['user_picture'][] = "No file uploaded!";
            $imagePath = null;
        }


$userData = [
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'password_hash' => password_hash($_POST['password_hash'], PASSWORD_BCRYPT),
    'role' => $_POST['role'],
    'user_picture' =>$imagePath
];


$profileData = [
    'registration_number' => $_POST['registration_number'],
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'phone_number' => $_POST['phone_number'],
    'salary' => $_POST['salary'],
    'hire_date' => $_POST['hire_date'],
    'date_birth' => $_POST['date_birth']
];

    $requestUser = new Request($userRules);
    $validationUser = $requestUser->validate($userData);

    $requestProfile = new Request($profilRules);
    $validationProfile = $requestProfile->validate($profileData);

    if (!empty($validationUser['errors']) || !empty($validationProfile['errors'])) {
        $_SESSION['error_messages'] = array_merge(
            $validationUser['errors'],
            $validationProfile['errors']
        );
        $_SESSION['old_data'] = $_POST;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

        $userModel= new UserModel($this->db);
        $user=$userModel->createUserAndProfile($validationUser['data'], $validationProfile['data']);
        if($user){
            UrlHelper::redirect('/authenInfo');
        }else{
            var_dump($user);
        }
}


   
    
   
    
       
    //----------------update user and profile--------

    public function editUser($userId){
        $userModel= new UserModel($this->db);
        $user=$userModel->getUserById($userId);
        $content=ViewHelper::render('editUser.php',[
           
            'title'=>'Users Infos',
            'editTitle'=>'Edit User',
            'user'=>$user
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
    }


    public function updateUser($userId){


        $userModel = new UserModel($this->db);
        $existingUser = $userModel->getUserById($userId);
    
        $newPassword = !empty($_POST['new_password']) 
            ? password_hash($_POST['new_password'], PASSWORD_BCRYPT) 
            : $existingUser['password_hash']; 
    
        $userPicture = $existingUser['user_picture']; 
        if (isset($_FILES['user_picture']) && $_FILES['user_picture']['error'] === 0) {
            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '', $_FILES["user_picture"]["name"]);
            $targetFilePath = $targetDir . $fileName;
    
            if (move_uploaded_file($_FILES["user_picture"]["tmp_name"], $targetFilePath)) {
                $userPicture = $targetFilePath;
            } else {
                echo "<p style='color: red;'>File upload failed!</p>";
                exit;
            }
        }
    

        $userRules=[
            'username' => 'required',
            'email' => 'required|email',
            'password_hash' => 'required',
            'role' => 'required',
            'user_picture' => 'required'
        
        ];

        $userData = [
            'userId' => $userId,
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password_hash' => $newPassword, 
            'role' => $_POST['role'],
            'user_picture' => $userPicture 
        ];
      

        $requestUser = new Request($userRules);
        $validationUser = $requestUser->validate($userData);

        if (!empty($validationUser['errors'])) {
           
            SessionHelper::startSession();
             $_SESSION['error_messages'] =   $validationUser['errors'];
             header('Location: ' . $_SERVER['HTTP_REFERER']);
              exit;
            
         }

         $result=$userModel->updateUser($validationUser['data']);
        
    if ($result === 'ok') {
        UrlHelper::redirect('/dashboard');
    } else {
        echo "Error: " . $result;
    }
    }





    public function updateUserAndProfile($userId) {

        

        $userRules=[
            'username' => 'required',
            'email' => 'required|email',
            'password_hash' => 'required',
            'role' => 'required',
            'user_picture' => 'required'
        
        ];
        
        $profilRules=[
            'registration_number' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'salary' => 'required',
            'hire_date' => 'required',
            'date_birth' => 'required'
          
        ];

        $userModel = new UserModel($this->db);
        $existingUser = $userModel->getUserById($userId);
    
        $newPassword = !empty($_POST['password_hash']) 
            ? password_hash($_POST['password_hash'], PASSWORD_BCRYPT) 
            : $existingUser['password_hash']; 
    
        $userPicture = $existingUser['user_picture']; 
        if (isset($_FILES['user_picture']) && $_FILES['user_picture']['error'] === 0) {
            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $fileName = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '', $_FILES["user_picture"]["name"]);
            $targetFilePath = $targetDir . $fileName;
    
            if (move_uploaded_file($_FILES["user_picture"]["tmp_name"], $targetFilePath)) {
                $userPicture = $targetFilePath;
            } else {
                echo "<p style='color: red;'>File upload failed!</p>";
                exit;
            }
        }
    

    
        $userData = [
            'userId' => $userId,
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password_hash' => $newPassword, 
            'role' => $_POST['role'],
            'user_picture' => $userPicture 
        ];
    
        $profileData = [
            'userId' => $userId,
            'registration_number' => $_POST['registration_number'],
            'name' => $_POST['name'],
            'phone_number' => $_POST['phone_number'],
            'email' => $_POST['email'],
            'salary' => $_POST['salary'],
            'hire_date' => $_POST['hire_date'],
            'date_birth' => $_POST['date_birth']
        ];
        $requestUser = new Request($userRules);
        $validationUser = $requestUser->validate($userData);
    
        $requestProfile = new Request($profilRules);
        $validationProfile = $requestProfile->validate($profileData);

        if (!empty($validationUser['errors']) || !empty($validationProfile['errors'])) {
           
            SessionHelper::startSession();
             $_SESSION['error_messages'] = array_merge(
                 $validationUser['errors'],
                 $validationProfile['errors']
             );
             $_SESSION['old_data'] = $_POST;
             header('Location: ' . $_SERVER['HTTP_REFERER']);
             exit;
         }
        
      //var_dump($validationUser['data'], $validationProfile['data']);
       //     exit();
             $userModel= new UserModel($this->db);
             $result=$userModel->updateUserAndProfile($validationUser['data'], $validationProfile['data']);
           
        if ($result === 'ok') {
            UrlHelper::redirect('/authenInfo');
        } else {
            echo "Error: " . $result;
        }
    }


    public function deleteUser($userId){
        $userModel= new UserModel($this->db);
        $user=$userModel->delete($userId);
        if($user){
            UrlHelper::redirect('/authenInfo');
        }else{
            var_dump($user);
        }
    }

    //--------------logout----------------
    public function logout()
    {
        SessionHelper::logout(); 
        session_unset(); 
        session_destroy(); 
        UrlHelper::redirect('/login'); 
        exit();
    }
    
    
       
   
   
}