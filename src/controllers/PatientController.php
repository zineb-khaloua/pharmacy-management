<?php 

namespace Controllers;

use Models\PatientModel;
use Helpers\ViewHelper;
use Helpers\UrlHelper;
use Helpers\SessionHelper;
use Helpers\Request;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PatientController{

    protected $db;

    // Dependency injection via the constructor
     public function __construct($db) {
         if (!$db) {
             throw new \Exception("Database connection is null.");
         }
         $this->db = $db;
     }


     
    public function exportPatients()
    {

        $patientModel= new PatientModel($this->db);
        $patients=$patientModel->getAll();

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
       
  $sheet->setCellValue('I2',  $pharmacyAddress);
  $sheet->getStyle('I2')->getFont()->setBold(true);
 
  $sheet->getStyle('I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

       
        $headers = ['Patients','National ID', 'Date of birth','Address','Phone','Email'];
        $sheet->fromArray([$headers], NULL, 'B5');

        
        $row = 6;
        foreach ($patients as $patient) {
            $sheet->setCellValue('B' . $row, $patient->name);
            $sheet->setCellValue('C' . $row, $patient->National_ID);
            $sheet->setCellValue('D' . $row, $patient->dob);
            $sheet->setCellValue('E' . $row, $patient->address);
            $sheet->setCellValue('F' . $row, $patient->phone_number);
            $sheet->setCellValue('G' . $row, $patient->email);
            $row++;
        }

       
        $filename = 'patients_export_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        ob_clean();
        flush();
   
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function patientShow(){

    $patientModel=new PatientModel($this->db);

    $patients=$patientModel->getAll();

    $content = ViewHelper::render('patient.php', [
    'title' => 'Patient',
    'patients' => $patients
    ]);

        //var_dump($content);
        //exit;


    echo ViewHelper::render('master.php', [
        'content' => $content
    ]);
    }


    public function formAddPatient(){

    $content = ViewHelper::render('addPatient.php', [
        'title' => 'Patient',
        'titleAdd' => 'Add Patient'
        ]);
    


        echo ViewHelper::render('master.php', [
            'content' => $content
        ]);
    }


    public function addPatient()
    {
        {
            $rules = [
                'name' => 'required',
                'national_id' => 'required',
                'dob' => 'required|date',
                'address' => '',
                'phone' => 'required',
                'email' => ''
            ];
            $data=[
              'name'=>$_POST['name'],
              'national_id'=>$_POST['national_id'],
               'dob'=>$_POST['dob'],
               'address'=>$_POST['address'],
               'phone'=>$_POST['phone'],
               'email'=>$_POST['email']
            ];

            $request = new Request($rules);
        
            $validationResult = $request->validate($data);
            if (!empty($validationResult['errors'])) {
                SessionHelper::startSession();
                $_SESSION['error_messages'] = $validationResult['errors']; 
                $_SESSION['old_data']=$_POST;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            $patientModel=new patientModel($this->db);

            $patients=$patientModel->Add($validationResult['data']);

            if ($patients['status'] === 'success') {
                echo "<script>alert('{$patients['message']}');</script>";
                UrlHelper::redirect('/patient');
                exit();

            } else {
               
                echo "<script>alert('{$patients['message']}');</script>";
                echo "<script>window.history.back();</script>";
            }



        }
    }
  

    public function editForm($id) {

        //var_dump($id); 
        $patientModel = new patientModel($this->db);
        $patient=$patientModel->getPatient($id);

    
        $content = ViewHelper::render('editPatient.php', [
        'title' => 'Edit Patient',
        'patient' => $patient
        ]);
       
    
        echo ViewHelper::render('master.php', [
            'content' => $content
        ]);
    }

    public function updatePatient($id){

    {
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'national_id' => 'required',
            'dob' => 'required|date',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
            
        ];
            $data = [
                'id' => $id,
                'name' => $_POST['name'],
                'national_id' => $_POST['national_id'],
                'dob' => $_POST['dob'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone_number'],
                'email' => $_POST['email']
            ];
            $request = new Request($rules);
    
            $validationResult = $request->validate($data);
            if (!empty($validationResult['errors'])) {
                SessionHelper::startSession(); 
                $_SESSION['error_messages'] = $validationResult['errors']; 
                $_SESSION['old_data']=$_POST;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            } else {
            $patientModel = new patientModel($this->db);
            $patients=$patientModel->update($data);
    
            if ($patients === 'ok') {
              
                UrlHelper::redirect("/patient");
                
            } else {
              
                echo $patients;
            }
        }
    }
    }


    public function deletePatient($id) {
         
    
          $patientModel = new patientModel($this->db);
          $patients = $patientModel->delete($id);
    
          if ($patients === 'ok') {
           UrlHelper::redirect('/patient');
        } else {
            echo $patients;  
        }
            
   }
   
}
