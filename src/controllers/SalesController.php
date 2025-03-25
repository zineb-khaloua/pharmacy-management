<?php
namespace Controllers;
use Models\salesModel;
use Helpers\UrlHelper;
use Helpers\ViewHelper;
use Helpers\SessionHelper;
use Helpers\Request;



use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Dompdf\Dompdf;
use Dompdf\Options;

class SalesController{

    protected $db;
    public function __construct($db){

        if(!$db){
            throw new \Exception('database connection is null');
        }
        $this->db=$db;

    }

    public function exportSales()
    {
        $saleModel= new SalesModel($this->db);
        $sales=$saleModel->getAllSales();

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
       
  $sheet->setCellValue('B2', $pharmacyName );
  $sheet->getStyle('B2')->getFont()->setBold(true);
  $sheet->mergeCells('B2:C2'); 

  $pharmacyAddress = !empty($pharmacy->address) ? $pharmacy->address : '123 Pharmacy St, City';
  $sheet->setCellValue('G2',  $pharmacyAddress);
  $sheet->getStyle('G2')->getFont()->setBold(true);
 
  $sheet->getStyle('G2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

       
        $headers = ['Sale ID', 'Sale Date', 'Credit', 'Patient',
      'User', 'Total'];
        $sheet->fromArray([$headers], NULL, 'A5');

        
        $row = 6;
        foreach ($sales as $sale) {
            $sheet->setCellValue('A' . $row, $sale->sales_id);
            $sheet->setCellValue('B' . $row, $sale->sale_date);
            $sheet->setCellValue('C' . $row, $sale->credit);
            $sheet->setCellValue('D' . $row, $sale->patient_name);
            $sheet->setCellValue('E' . $row, $sale->user_name);
            $sheet->setCellValue('F' . $row, $sale->total_price);
            $row++;
        }

      
        $filename = 'sales_export_' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        ob_clean();
        flush();
       
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function saleShow(){
        $salesModel=new SalesModel($this->db);
        $sales=$salesModel->getAllSales();
        $content = ViewHelper::render('sales.php',[
                    'title'=>'Sales',
                    'sales'=>$sales,
        ]);
         
        echo ViewHelper::render('master.php',[
                     'content'=>$content
        ]);

    }


    public function saleDetails($id)
    {
          $salesModel= new SalesModel($this->db); 
          $salesDetails=$salesModel->getSaleDetails($id);
          echo json_encode($salesDetails);
    }

    public function formAddsale(){
        $salesModel = new SalesModel($this->db);
        $medicaments=$salesModel->getMedicaments();
        $patients=$salesModel->getPatients();
        $content= ViewHelper::render('addsales.php',[
            'title' => 'Sales',
            'titleAdd'=>'Add Sales',
            'medicaments'=>$medicaments,
            'patients'=>$patients
        ]);

        echo ViewHelper::render('master.php',[
            'content'=>$content
        ]);
    }

public function addSale(){
   $rules=[
    'credit'=>'',
    'patient_id'=>'required',
    'user_id'=>'required',
    'sale_date'=>'required',
    'total_price'=>''
   ];
$data=[

    'credit'=>$_POST['credit']?? '',
    'patient_id'=>$_POST['patient_id'] ?? '',
    'user_id'=>$_POST['user_id'] ?? '', 
    'sale_date'=>$_POST['dateSale'] ?? '',
    'total_price'=>$_POST['total_price'] ?? '',
];


    $medicament_data = isset($_POST['medicament_data']) ? json_decode($_POST['medicament_data'], true) : [];
  
    $request = new Request($rules);
        
        $validationResult = $request->validate($data);

        if (!empty($validationResult['errors'])) {
            echo json_encode([
              'status' => 'error',
              'errors' =>$validationResult['errors']
          ]);
          exit;
        }

    $salesModel = new SalesModel($this->db);
    $sale_id = $salesModel->addSale($validationResult['data']);

        if (!isset($_POST['medicament_data']) || empty($_POST['medicament_data'])) {
            echo json_encode([
              'status' => 'error',
              'message' => 'At least one medicament is required.']);
            exit;
        }

    if ($sale_id) {
        foreach ($medicament_data as $item) {
            $errors = [];
         
           $addedItem= $salesModel->addSaleItem($sale_id,
             $item['medicament_id'], 
             $item['quantity'],
             $item['prescription'], 
             $item['price'],
             $item['total']);
             if (!$addedItem) {
                $errors[] = 'Error adding item: '; 
             }
            
        }
       
        if (!empty($errors)) {  
            echo json_encode(['status' => 'success', 'saleId' => $sale_id]);  
           } else {  
            echo json_encode(['status' => 'error', 'message' => 'Please add the medication items .']); 
        }
        
    }  else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add sale.']);
    }
}


public function editForm($id){
    $salesModel=new SalesModel($this->db);
    $patients=$salesModel->getPatients();
    $medicaments=$salesModel->getMedicaments();
    $sales=$salesModel->getSalesToEdit($id);
    $items=$salesModel->getItemsToEdit($id);
    $content=ViewHelper::render('editSales.php',[
              'title'=>'Sales',
              'titleEdit'=>'Edit Sales',
              'patients'=>$patients,
              'medicaments'=>$medicaments,
              'sales'=>$sales,
              'items'=>$items
   ]);
   echo ViewHelper::render('master.php',[
    'content'=>$content
   ]);  
}

public function updateSaleProcess($id){

    SessionHelper::startSession(); 
    $_SESSION['error_messages'] = []; 

    $rulesSale = [
        'total_price' => 'required|numeric|min:0',
        'sale_date'   => 'required',
        'credit'      => 'numeric', 'min:0',
        'patient_id'  => '',
        'user_id'     => ''
    ];

    $saleData = [
        'id' => $id,
        'total_price' => $_POST['total_price'] ?? '',
        'sale_date' => $_POST['dateSale'] ?? '',
        'credit' => $_POST['credit'] ?? '',
        'patient_id' =>!empty($_POST['patient_id']) ? $_POST['patient_id'] : null,
        'user_id' => !empty($_POST['user_id']) ? $_POST['user_id'] : null,
    ];

    $requestSale = new Request($rulesSale);
    $validationSaleData = $requestSale->validate($saleData);

     
    if (!empty($validationSaleData['errors'])) {
 
        $_SESSION['error_messages'] = $validationSaleData['errors'];
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
      }



      $rulesItems = [
            'item_id'       => 'required|integer',
            'medicament_id' => 'required|integer',
            'quantity'      => 'required|numeric|min:1',
            'prescription'  =>  'required|in:YES,NO',
            'price'         => 'required|numeric|min:0',
            'total'        =>'required|numeric|min:0'

    ];


    $saleItems = [];
    if (!empty($_POST['items'])) {
        foreach ($_POST['items'] as $item) {
            $validationItem = (new Request($rulesItems))->validate($item);
            if (!empty($validationItem['errors'])) {
                foreach ($validationItem['errors'] as $field => $errors) {
                    $_SESSION['error_messages']["items_{$item['item_id']}"][$field] = $errors;
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
               
                }
            } else {
                $saleItems[] = [
                    'item_id'       => $item['item_id'],
                    'medicament_id' => $item['medicament_id'],
                    'quantity'      => $item['quantity'],
                    'prescription'  =>$item['prescription'],
                    'price'         => $item['price'],
                    'total'         =>$item['total']

                ];
            }
        }
    }

    $rulesNewItems = [
        'medicament_id' => 'required|integer',
        'quantity'      => 'required|numeric|min:1',
        'prescription'  =>  'required|in:YES,NO',
        'price'         => 'required|numeric|min:0',
        'total'        =>'required|numeric|min:0'

];

    $newItems = [];
    if (!empty($_POST['medicament_data'])) {
        $medicamentData = json_decode($_POST['medicament_data'], true);
       
        if (is_array($medicamentData)) {
            foreach ($medicamentData as $newItem) {
                $validationNewItem = (new Request($rulesNewItems))->validate($newItem);
               
                if (!empty($validationNewItem['errors'])) {
                    $_SESSION['error_messages'] = $validationNewItem['errors'];
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    exit;
                } else {
                    $newItems[] = [
                        'medicament_id' => $newItem['medicament_id'],
                        'quantity' => $newItem['quantity'],
                        'prescription'  =>$newItem['prescription'],
                        'price' => $newItem['price'],
                        'total' => $newItem['total'],
                        'sale_id' => $id
                        
                    ];
                }
            }
        }
    }

    $saleModel= new SalesModel($this->db);
    $result = $saleModel->updateSaleWithItem($saleData, $saleItems, $newItems);
  
      if ($result === "success") {
          $_SESSION['success'] = "Order updated successfully.!";
      } else {
          $_SESSION['error'] = "An error occurred while updating.";
      }
  
      UrlHelper::redirect('/sale');
      exit;
   

}



public function deleteSale($id){
    $salesModel=new SalesModel($this->db);
    $sale=$salesModel->delete($id);
    if($sale=='ok'){
        UrlHelper::redirect('/sale');
    }
    else{
        echo $sale;
    }
}


public function deleteSaleItem($itemId,$saleId) {
    
    $salesModel=new SalesModel($this->db);
    $result=$salesModel->deleteSaleItem($itemId);

    if ($result) {
        $salesModel->updateSaleTotal($saleId);
        echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully.']);

        
     }  else {
         echo json_encode(['status' => 'error', 'message' => 'Failed to delete item.']);
     }
}



public function invoiceCreate($saleId){

    $SalesModel= new SalesModel($this->db);
    
    $items=$SalesModel->getSaleDetails($saleId);
    $sale=$SalesModel->getSalesToEdit($saleId);
    $html =ViewHelper::render('invoiceSale.php',[
      'sale'=>$sale,
      'items'=>$items
    ]);

     
     $options = new Options();
     $options->set('defaultFont', 'Arial');
 
     $dompdf = new Dompdf($options);
     $dompdf->loadHtml($html);
     $dompdf->setPaper('A4', 'portrait');
     $dompdf->render();
 
     $dompdf->stream("Invoice_$saleId.pdf", ["Attachment" => false]);
   
  }




}