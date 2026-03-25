<?php
require_once '../app/core/Database.php';

class BookingModel extends Database {
    
    public function createBooking($userId, $tourId, $quantity, $totalPrice, $notes) {
        $sql = "INSERT INTO bookings (user_id, tour_id, quantity, total_price, notes) 
                VALUES (:user_id, :tour_id, :quantity, :total_price, :notes)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':tour_id' => $tourId,
            ':quantity' => $quantity,
            ':total_price' => $totalPrice,
            ':notes' => $notes
        ]);
    }
}
?>