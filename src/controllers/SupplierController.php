<?php

namespace Controllers;

use Models\supplierModel;
use Helpers\ViewHelper;
use Helpers\UrlHelper;
use Helpers\SessionHelper;
use Helpers\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SupplierController{


    protected $db;
    public function __construct($db){
        if(!$db){
            throw new \Exception('database connection is null');
         }
        $this->db=$db;
    }

    public function exportSuppliers()
    {
        $supplierModel = new SupplierModel($this->db);
        $suppliers=$supplierModel->getAll();

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
  $sheet->setCellValue('B2',   $pharmacyName);
  $sheet->getStyle('B2')->getFont()->setBold(true);
  $sheet->mergeCells('B2:C2'); 

  $pharmacyAddress = !empty($pharmacy->address) ? $pharmacy->address : '123 Pharmacy St, City';
       
  $sheet->setCellValue('G2', $pharmacyAddress);
  $sheet->getStyle('G2')->getFont()->setBold(true);
 
  $sheet->getStyle('G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Ajouter les en-têtes
        $headers = ['Name', 'phone_number', 'Address', 'Email',
      'Entity'];
        $sheet->fromArray([$headers], NULL, 'B5');

        // Ajouter les données
        $row = 6;
        foreach ($suppliers as $supplier) {
            $sheet->setCellValue('B' . $row, $supplier->name);
            $sheet->setCellValue('C' . $row, $supplier->phone_number);
            $sheet->setCellValue('D' . $row, $supplier->address);
            $sheet->setCellValue('E' . $row, $supplier->email);
            $sheet->setCellValue('F' . $row, $supplier->entity);
            $row++;
        }

        // Définir le nom du fichier
        $filename = 'orders_export_' . date('Y-m-d') . '.xlsx';

        // Envoi des en-têtes pour le téléchargement du fichier
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        ob_clean();
        flush();
        // Générer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    
    public function supplierShow(){

        $supplierModel = new SupplierModel($this->db);
        $suppliers=$supplierModel->getAll();

        $content=ViewHelper::render('supplier.php',[
                  'title'=>'Supplier',
                  'suppliers'=>$suppliers

        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
    }


    public function formAddSupplier(){
        $content = ViewHelper::render('addSupplier.php',[
                'title'=>'Supplier',
                'titleAdd'=>'Add Supplier'
        ] );

        echo ViewHelper::render('master.php',[
              'content'=>$content
        ] );
    }


    public function addSupplier(){
        {
            $rules=[
                'name'=>'required',
                'phone_number'=>'required',
                'address'=>'required',
                'email'=>'required|email',
                'entity'=>'required'
               ];

        $data=[
             'name'=>$_POST['name'],
            'phone_number'=>$_POST['phone_number'],
            'address'=>$_POST['address'],
            'email'=>$_POST['email'],
            'entity'=>$_POST['entity']
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
        $supplierModel=new SupplierModel($this->db);
        $supplier= $supplierModel->add($validationResult['data']);

        if($supplier == 'ok')
        {
            UrlHelper::redirect('/supplier');
           exit();
        }

        else {
           
            echo $supplier;
        }
    }
}

public function editForm($id){

    $supplierModel= new SupplierModel($this->db);
    $supplier=$supplierModel->getSupplier($id);

    $content=ViewHelper::render('editSupplier.php',[
        'title'=>'Supplier',
        'titleEdit'=>'Edit Supplier',
         'supplier'=>$supplier
    ]);

    echo ViewHelper::render('master.php',[
        'content'=>$content
    ]);

}

public function updateSupplier($id){
{
    $rules=[
        'name'=>'required',
        'phone_number'=>'required',
        'address'=>'required',
        'email'=>'required|email',
        'entity'=>'required'
    ];
    $data=[
        'id'=>$id,
        'name'=>$_POST['name'],
        'phone_number'=>$_POST['phone_number'],
        'address'=>$_POST['address'],
        'email'=>$_POST['email'],
        'entity'=>$_POST['entity']
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
    $supplierModel=new SupplierModel($this->db);
    $supplier=$supplierModel->update($validationResult['data'] );

    if($supplier)
    {
        UrlHelper::redirect('/supplier'); 
    }
    else{
        echo $supplier;
    }

}
}
  public function deleteSupplier ($id){

    $supplierModel=new SupplierModel($this->db);
    $supplier=$supplierModel->delete($id);
    if($supplier=='ok')
    {
        UrlHelper::redirect('/supplier');
    }
    else{
        echo $supplier;
    }
  }




}
