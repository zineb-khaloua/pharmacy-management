<?php

namespace Controllers;

use Helpers\ViewHelper;
use Helpers\UrlHelper;
use Helpers\SessionHelper;
use Helpers\Request;
use Models\CategoryModel;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class CategoryController{

    protected $db;
    public function __construct($db){
        if(!$db)
        {
            throw new \Exception('database connection is null');
        }
        $this->db=$db;
    }

    public function exportCategories()
    {
        $categoryModel=new CategoryModel($this->db);
        $categories=$categoryModel->getAll();
        
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
  $sheet->setCellValue('G2',  $pharmacyAddress );
  $sheet->getStyle('G2')->getFont()->setBold(true);
 
  $sheet->getStyle('G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $headers = ['Category', 'Description'];
        $sheet->fromArray([$headers], NULL, 'B5');

        $row = 6;
        foreach ($categories as $category) {
            $sheet->setCellValue('B' . $row, $category->name);
            $sheet->setCellValue('C' . $row, $category->description);
            $row++;
        }

        $filename = 'category_export_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        ob_clean();
        flush();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }


    public function categoryShow(){

        $categoryModel=new CategoryModel($this->db);
        $categories=$categoryModel->getAll();

        $content=ViewHelper::render('category.php',[
            'title'=>'Category',
            'categories'=>$categories
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
    }



    public function formAddCategory(){
        $content=ViewHelper::render('addCategory.php', [
            'title'=>'Category',
            'titleAdd'=>'Add Category'
        ]);
        echo ViewHelper::render('master.php',[
            'content'=>$content
       ]);
    }

    public function addCategory(){
        {
            $rules = [
                'name' => 'required',
                'description' => 'required'
            ];

            $data=[
                'name'=>$_POST['name'],
                'description'=>$_POST['description']
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
        
        $categoryModel= new CategoryModel($this->db);
        $categories= $categoryModel->add($validationResult['data']);

        if ($categories=='ok'){

            UrlHelper::redirect('/category');

        }
        else{
            echo $categories;
        }
    
    }
}

    public function editForm($id){

        $categoryModel= new CategoryModel($this->db);
        $category=$categoryModel->getCategory($id);


        $content = ViewHelper::render('editCategory.php',[
                'title'=>'Category',
                'titleEdit'=>'Edit Category',
                'category'=>$category
        ]);
        echo ViewHelper::render('master.php',[
             'content'=>$content
        ]);
    }
    public function updateCategory($id){
        {

            $rules = [
                'id'=>'required',
                'name' => 'required',
                'description' => 'required',
               
            ];

           $data=[
               'id'=>$id,
               'name'=>$_POST['name'],
               'description'=>$_POST['description']
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
        $categoryModel=new CategoryModel($this->db);
        $category=$categoryModel->update($validationResult['data']); 

        if($category=='ok'){
            UrlHelper::redirect('/category');
        }
        else{
            echo $category;
        }
       
    }
    }

    public function deleteCategory($id){

        $categoryModel=new CategoryModel($this->db);
        $category=$categoryModel->delete($id);

        if($category== 'ok')
        {
            UrlHelper::redirect('/category');
        }
        else{
            echo $category;
        }

    }
}