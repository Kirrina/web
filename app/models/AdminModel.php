<?php
// require_once '../app/core/Database.php';

class AdminModel extends Database {
    
    // =====================================
    // 1. DASHBOARD THỐNG KÊ
    // =====================================
    public function getDashboardStats() {
        $stats = []; 
        $stats['total_tours'] = $this->conn->query("SELECT COUNT(*) FROM tours")->fetchColumn();
        $stats['total_bookings'] = $this->conn->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
        $revenue = $this->conn->query("SELECT SUM(total_price) FROM bookings WHERE status != 'cancelled'")->fetchColumn();
        $stats['total_revenue'] = $revenue ? $revenue : 0; 
        $stats['total_customers'] = $this->conn->query("SELECT COUNT(DISTINCT user_id) FROM bookings")->fetchColumn();
        return $stats; 
    }

    public function getLatestBookings($limit = 3) {
        $sql = "SELECT b.id, b.full_name, t.name as tour_name, b.created_at, b.status, b.total_price 
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                ORDER BY b.created_at DESC LIMIT " . (int)$limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================
    // 2. QUẢN LÝ TOUR & DANH MỤC
    // =====================================
    
    // Lấy tất cả Tour (dành cho Admin)
    public function getAdminTours() {
        $sql = "SELECT t.*, c.name as category_name 
                FROM tours t 
                LEFT JOIN categories c ON t.category_id = c.id 
                ORDER BY t.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục
    public function getAllCategories() {
        return $this->conn->query("SELECT * FROM categories ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm Tour mới
    public function insertTour($data) {
        $sql = "INSERT INTO tours (name, category_id, description, price, discount, departure_date, duration, duration_days, departure_location, available_seats, image, status) 
                VALUES (:name, :category_id, :description, :price, :discount, :departure_date, :duration, :duration_days, :departure_location, :available_seats, :image, 'active')";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật Tour cũ
    public function updateTour($data) {
        $sql = "UPDATE tours 
                SET name = :name, category_id = :category_id, description = :description, 
                    price = :price, discount = :discount, departure_date = :departure_date, 
                    duration = :duration, duration_days = :duration_days, 
                    departure_location = :departure_location, available_seats = :available_seats, 
                    image = :image 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}
?>