<?php

namespace Controllers;
use Models\MedicamentModel;
use Helpers\ViewHelper;
use Helpers\UrlHelper;
use Helpers\SessionHelper;
use Helpers\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MedicamentController{

    protected $db;
    public function __construct($db){
        if(!$db){
          throw new \Exception ('database connection is null');
        }
       $this->db= $db;
    }


    public function exportMedicaments()
    {
        $medicamentModel= new MedicamentModel($this->db);
        $medicaments=$medicamentModel->getAll();

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
  $sheet->setCellValue('J2',  $pharmacyAddress);
  $sheet->getStyle('J2')->getFont()->setBold(true);
 
  $sheet->getStyle('J2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

       
        $headers = ['Name','Category', 'Reference','Price','Qty','Laboratory','Reimbursable','Prescription','Supplier'];
        $sheet->fromArray([$headers], NULL, 'B5');

       
        $row = 6;
        foreach ($medicaments as $medicament) {
            $sheet->setCellValue('B' . $row, $medicament->name);
            $sheet->setCellValue('C' . $row, $medicament->category_name);
            $sheet->setCellValue('D' . $row, $medicament->reference_code);
            $sheet->setCellValue('E' . $row, $medicament->price);
            $sheet->setCellValue('F' . $row, $medicament->quantity_in_stock);
            $sheet->setCellValue('G' . $row, $medicament->laboratory);
            $sheet->setCellValue('H' . $row, $medicament->reimbursable);
            $sheet->setCellValue('I' . $row, $medicament->prescription);
            $sheet->setCellValue('J' . $row, $medicament->supplier_name);
            $row++;
        }

   
        $filename = 'medicaments_export_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        ob_clean();
        flush();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function medicamentShow() {

        $medicamentModel= new MedicamentModel($this->db);
        $medicaments=$medicamentModel->getAll();
        
        $content=ViewHelper::render('medicament.php',[
         'title'=>'Medicament',
         'medicaments'=>$medicaments

        ]);
        echo ViewHelper::render('master.php',[
            'content' => $content
        ]);
    }
    public function formAddMedicament(){

        $medicamentModel= new MedicamentModel($this->db);
        $categories=$medicamentModel->getAllCategories();
        $suppliers=$medicamentModel->getAllSuppliers();
        $medicaments=$medicamentModel->getAll();
        $newReferenceCode =$medicamentModel->generateNewReferenceCode();

        $content=ViewHelper::render('addMedicament.php',[
                 'title'=>'Medicament',
                 'titleAdd'=>'Add Medicament',
                 'categories'=>$categories,
                 'suppliers'=>$suppliers,
                 'medicaments'=>$medicaments,
                 'reference_code'=>$newReferenceCode
        ]);

       // var_dump($content);
       //exit;
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
    }
    public function addMedicament()
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'reference_code' => 'required',
            'price' => 'required',
            'quantity_in_stock' => 'required|numeric',
            'laboratory' => 'required',
            'expired_date'=>'required',
            'reimbursable' => 'required|in:YES,NO',
            'prescription' => 'required|in:YES,NO',
            'supplier_id' => 'required',
            'category_id' => 'required'
        ];
        
        $data = [
            'name' => $_POST['name'] ?? '',
            'reference_code' => $_POST['reference_code'] ?? '',
            'price' => $_POST['price'] ?? '',
            'quantity_in_stock' => $_POST['quantity_in_stock'] ?? '',
            'laboratory' => $_POST['laboratory'] ?? '',
            'expired_date'=>$_POST['expired_date'] ?? '',
            'reimbursable' => $_POST['reimbursable'] ?? '',
            'prescription' => $_POST['prescription'] ?? '',
            'supplier_id' => $_POST['supplier_id'] ?? '',
            'category_id' => $_POST['category_id'] ?? ''
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
        
    
        $medicamentModel = new MedicamentModel($this->db);
        $result = $medicamentModel->add($validationResult['data']);
        
        if ($result === 'ok') {
            UrlHelper::redirect('/medicament');
        } else {
            echo "<script>alert(\"Error while adding the medication.\"); window.history.back();</script>";
            exit;
        }
    }
    
    
    

public function editForm($id){

    $medicamentModel = new MedicamentModel($this->db);
    $medicament=$medicamentModel->getMedicament($id);
    $categories=$medicamentModel->getAllCategories();
    $suppliers=$medicamentModel->getAllSuppliers();

         $content= ViewHelper::render('editMedicament.php',[
                'title'=>'Medicament',
                'titleEdit'=>'Edit Medicament',
                'medicament'=>$medicament,
                'categories'=>$categories,
                 'suppliers'=>$suppliers
     ]);
     echo ViewHelper::render('master.php',[
                 'content'=>$content
     ]);

   
}

public function updateMedicament($id){
    {
  
        $rules = [
            'medicament_id' => 'required',
            'name' => 'required|min:3|max:50',
            'reference_code' => 'required',
            'price' => 'required|decimal',
            'quantity_in_stock' => 'required|numeric',
            'laboratory' => 'required',
            'expired_date'=>'required',
            'reimbursable' => 'required',
            'prescription' => 'required',
            'supplier_id' => '',
            'category_id' => ''
        ];
    $data=[
        'medicament_id' => $id,                  
        'name'=>$_POST['name'], 
        'reference_code'=>$_POST['reference_code'],
        'price'=>$_POST['price'],                      
        'quantity_in_stock'=>$_POST['quantity_in_stock'], 
        'laboratory'=>$_POST['laboratory'],
        'expired_date'=> $_POST['expired_date'],
        'reimbursable'=>$_POST['reimbursable'], 
        'prescription'=>$_POST['prescription'],
        'supplier_id'=>!empty($_POST['supplier_id']) ? $_POST['supplier_id'] : null,                      
        'category_id'=>!empty($_POST['category_id']) ? $_POST['category_id'] : null
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
      
   
else {
    //$data = $validationResult['data'];
    //$data['id'] = $id;
    
    $medicamentModel=new MedicamentModel($this->db);
    $medicament=$medicamentModel->update($validationResult['data']);

    if ($medicament === 'ok') {
        UrlHelper::redirect('/medicament');
    } else {
        echo "<script>alert(\"Error while adding the medication.\"); window.history.back();</script>";
        exit;
    }
    }
}
   
}

public function deleteMedicament($id){
      $medicamentModel= new MedicamentModel($this->db);
      $medicament=$medicamentModel->delete($id);
      if($medicament == 'ok'){
        UrlHelper::redirect('/medicament');
      }
      else{
        echo $medicament;
      }
}

}