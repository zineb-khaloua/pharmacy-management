<?php

namespace Controllers;

use Models\UserModel;
use Models\DashboardModel;
use Helpers\SessionHelper;
use Helpers\UrlHelper;
use Helpers\ViewHelper;

class dashboardController{
  protected $db;
  public function __construct($db){
      if(!$db){
        throw new \Exception ('database connection is null');
      }
     $this->db= $db;
  }


  public function dashboardShow()
  {  

    if(!SessionHelper::isLoggedIn()) { 
      UrlHelper::redirect('/login');
      exit;
     }
     $dashboardModel=new DashboardModel($this->db);
     $orders=$dashboardModel->countOrders();
     $sales=$dashboardModel->countSales();
     $medicaments=$dashboardModel->expiredMedicaments();
     $patients=$dashboardModel->countPatients();
     $userId=$_SESSION['user_id'] ;
     $username=$_SESSION['username'] ;
     $content = ViewHelper::render('dashboard.php', [
    'user_id' => $userId,
    'username'=> $username,
    'title' => 'dashboard',
    'orders'=>$orders,
    'sales'=>$sales,
    'medicaments'=>$medicaments,
    'patients'=>$patients
]);
//var_dump($content);
//exit;

      echo ViewHelper::render('master.php', [
        'title' => 'pharmacy-management',
        'content' => $content,
        
    ]);

  }
  public function lowStock()
{
  $dashboardModel=new DashboardModel($this->db);
  $medicament=$dashboardModel->getLowStock();
  header('Content-Type: application/json');
  echo json_encode($medicament);
  exit;
}



public function getStatisticsSaleByPeriod($period, $date) {
  $dashboardModel = new DashboardModel($this->db);
  $salesData = $dashboardModel->getStatisticsSaleByPeriod($period, $date);

  if ($salesData) {
      $statistics = [];

      foreach ($salesData as $row) {
          $statistics[] = $row;
      }

      header('Content-Type: application/json');
      echo json_encode($statistics);
  } else {
      echo json_encode(["message" => "No data found."]);
  }
}



public function getStatisticsSaleByYear($year) {


  $dashboardModel = new DashboardModel($this->db);
  $data = $dashboardModel->getStatisticsSaleByYear($year);
 if ($data) {
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
  }
  else {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'No data found'], JSON_PRETTY_PRINT);
    exit;
  }
 
  
}

public function getStatisticsSale($date, $period) {
  $dashboardModel = new DashboardModel($this->db);
  $data = $dashboardModel->getStatisticsSaleByPeriod($period, $date);
  if (!is_array($data)) {
    $data = [$data]; 
}
header('Content-Type: application/json');
echo json_encode($data);
}


public function index() {
  $orderModel = new OrderModel($this->db);

  $periods = ['day', 'week', 'month', 'year'];
  $orderStats = [];
  $salesStats = [];

  foreach ($periods as $period) {
      $orderStats[$period] = $orderModel->getOrderStatistics($period);
      $salesStats[$period] = $orderModel->getSalesStatistics($period);
      var_dump($orderStats);
var_dump($salesStats);
  }

  $data = [
      'orderStats' => $orderStats,
      'salesStats' => $salesStats
  ];

  $content = ViewHelper::render('dashboard.php', $data);
  echo ViewHelper::render('master.php', ['content' => $content]);
}
}