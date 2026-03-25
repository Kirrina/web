<?php
require_once '../app/core/Database.php';

class AdminModel extends Database {
    
   
    public function getDashboardStats() {
        $stats = []; 

       
        $stmt1 = $this->conn->query("SELECT COUNT(*) as total_tours FROM tours");
        $stats['total_tours'] = $stmt1->fetch(PDO::FETCH_ASSOC)['total_tours'];

       
        $stmt2 = $this->conn->query("SELECT COUNT(*) as new_bookings FROM bookings WHERE status = 'pending'");
        $stats['new_bookings'] = $stmt2->fetch(PDO::FETCH_ASSOC)['new_bookings'];

       
        $stmt3 = $this->conn->query("SELECT SUM(total_price) as total_revenue FROM bookings");
        $revenue = $stmt3->fetch(PDO::FETCH_ASSOC)['total_revenue'];
        
       
        $stats['total_revenue'] = $revenue ? $revenue : 0; 

        return $stats; 
    }
}
?>