<?php
require_once '../app/core/Database.php';

class TourModel extends Database {
    
   
    public function getAllTours() {
       
        $sql = "SELECT tours.*, categories.name as category_name 
                FROM tours 
                JOIN categories ON tours.category_id = categories.id 
                WHERE tours.status = 'active' 
                ORDER BY tours.id DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTourById($id) {
        $sql = "SELECT tours.*, categories.name as category_name 
                FROM tours 
                JOIN categories ON tours.category_id = categories.id 
                WHERE tours.id = :id AND tours.status = 'active'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function decreaseSeats($id, $quantity) {
        $sql = "UPDATE tours SET available_seats = available_seats - :quantity WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $id
        ]);
    }
}
?>