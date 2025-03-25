<?php

namespace Models;
use PDO;
use Exception;

class DashboardModel{

    protected $db;

    public function __construct($db) {
       if(!$db){
        throw new \Exception ('database connexion is null');
       }
       $this->db=$db;
    }
    public function countOrders(){
      $stmt=$this->db->prepare('SELECT COUNT(*) as orders FROM `order` ');
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_OBJ);
      return $result->orders;
    }
    public function countSales(){
      $stmt=$this->db->prepare('SELECT COUNT(*) as sales FROM sales' );
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_OBJ);
      return $result->sales;
    }
    public function expiredMedicaments(){
      $stmt=$this->db->prepare('SELECT COUNT(*) as medicaments FROM medicament WHERE expired_date < CURDATE()' );
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_OBJ);
      return $result->medicaments;
    }
    public function countPatients(){
      $stmt=$this->db->prepare('SELECT COUNT(*) as patients FROM patient ' );
      $stmt->execute();
      $result=$stmt->fetch(PDO::FETCH_OBJ);
      return $result->patients;
    }

    public function getLowStock() {
      $stmt = $this->db->prepare('SELECT name, quantity_in_stock FROM medicament WHERE quantity_in_stock < 10');
      $stmt->execute();
      $medicaments = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $medicaments;
  }
  

  public function getPatientStatistics($date) {
    $stmt =$this->db->prepare( 'SELECT COUNT(*) as total_orders, SUM(total_amount) as total_revenue 
             FROM patient WHERE  order_date=:date');
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

public function getStatisticsSaleByYear($year){
  $stmt = $this->db->prepare("SELECT MONTH(sale_date) as month, COUNT(*) as total_sales, SUM(total_price) as total_revenue 
  FROM sales 
  WHERE YEAR(sale_date) = :year
  GROUP BY MONTH(sale_date) 
  ORDER BY MONTH(sale_date)");
  $stmt->bindParam(':year', $year);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);
}

public function getStatisticsSaleByPeriod($period, $date) {
  switch ($period) {
      case 'day':
          $stmt = $this->db->prepare('
               SELECT 
        HOUR(sale_date) AS hour, 
        COUNT(*) AS total_sales, 
        SUM(total_price) AS total_revenue 
    FROM sales 
    WHERE DATE(sale_date) = :date 
    GROUP BY hour
    ORDER BY hour
          ');
          $stmt->bindValue(':date', $date);
          break;
      case 'week':
          $stmt = $this->db->prepare('
             SELECT 
    DAYOFWEEK(sale_date) AS week_day, 
    DATE(sale_date) AS sale_day,
    COUNT(*) AS total_sales, 
    SUM(total_price) AS total_revenue 
FROM sales 
WHERE YEARWEEK(sale_date, 1) = YEARWEEK(:date, 1) 
GROUP BY week_day, sale_day
ORDER BY week_day; ');
          $stmt->bindValue(':date', $date);
          break;
      case 'month':
          $stmt = $this->db->prepare('
            SELECT DAY(sale_date) AS day, 
               COUNT(*) as total_sales, 
               SUM(total_price) AS total_revenue
        FROM sales
        WHERE MONTH(sale_date) = MONTH(:date) 
          AND YEAR(sale_date) = YEAR(:date)
        GROUP BY day;

             
          ');
          $stmt->bindValue(':date', $date);
          break;
      case 'year':
        
          $stmt = $this->db->prepare("SELECT MONTH(sale_date) as month, COUNT(*) as total_sales, SUM(total_price) as total_revenue 
          FROM sales 
          WHERE YEAR(sale_date) = :date
          GROUP BY MONTH(sale_date) 
          ORDER BY MONTH(sale_date)");
          $stmt->bindValue(':date', (int)$date);
          break;
      default:
          throw new Exception("Invalid period");
  }
  if (!$stmt->execute()) {
    print_r($stmt->errorInfo()); 
    die();
}

return $stmt->fetchAll(PDO::FETCH_OBJ);
}


   public function getStatisticsSale($date) {
    $stmt =$this->db->prepare('SELECT COUNT(*) as total_sales, SUM(total_price) as total_revenue 
                                FROM sales WHERE sale_date=:date');
     $stmt->bindParam(':date',$date);                           
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ) ;
}

}
