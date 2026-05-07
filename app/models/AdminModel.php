<?php
 require_once '../app/core/Database.php';

class AdminModel extends Database {
    
    // =====================================
    // 1. DASHBOARD THỐNG KÊ
    // =====================================
    public function getDashboardStats() {
        $stats = []; 
        $stats['total_tours'] = $this->conn->query("SELECT COUNT(*) FROM tours")->fetchColumn();
        $stats['total_bookings'] = $this->conn->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
        $revenue = $this->conn->query("SELECT SUM(total_price) FROM bookings WHERE status = 'confirmed'")->fetchColumn();
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

    // Thêm Tour mới (Đã bổ sung đầy đủ trường dữ liệu)
    public function insertTour($data) {
        $sql = "INSERT INTO tours (name, category_id, description, itinerary, price, discount, departure_date, duration, duration_days, departure_location, available_seats, image, gallery, status) 
                VALUES (:name, :category_id, :description, :itinerary, :price, :discount, :departure_date, :duration, :duration_days, :departure_location, :available_seats, :image, :gallery, :status)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật Tour cũ
    public function updateTour($data) {
        $sql = "UPDATE tours 
                SET name = :name, category_id = :category_id, description = :description, itinerary = :itinerary,
                    price = :price, discount = :discount, departure_date = :departure_date, 
                    duration = :duration, duration_days = :duration_days, 
                    departure_location = :departure_location, available_seats = :available_seats, 
                    image = :image, gallery = :gallery, status = :status
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Hàm xóa Tour
    public function deleteTour($id) {
        $stmt = $this->conn->prepare("DELETE FROM tours WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // 1. Thêm danh mục mới
    public function addCategory($name, $description = '') {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description]);
    }

    // 2. Cập nhật danh mục
    public function updateCategory($id, $name, $description = '') {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description, $id]);
    }

    // 3. Xóa danh mục
    public function deleteCategory($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // =====================================
    // 3. QUẢN LÝ ĐƠN HÀNG (BOOKINGS)
    // =====================================
    
    // Lấy toàn bộ danh sách đơn hàng
    public function getAllBookings() {
        $sql = "SELECT b.*, t.name as tour_name, u.fullname as user_fullname, u.email as user_email, u.phone as user_phone 
                FROM bookings b
                LEFT JOIN tours t ON b.tour_id = t.id
                LEFT JOIN users u ON b.user_id = u.id
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy lịch sử đặt tour của một User cụ thể
    public function getUserBookings($userId) {
        $sql = "SELECT b.*, t.name as tour_name, t.image as tour_image 
                FROM bookings b
                JOIN tours t ON b.tour_id = t.id
                WHERE b.user_id = ?
                ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateBookingStatus($id, $status) {
        $sql = "UPDATE bookings SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    // Xóa đơn hàng
    public function deleteBooking($id) {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    // Lấy thông tin 1 đơn hàng cụ thể
    public function getBookingById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tự động Cập nhật lại số chỗ của Tour (Truyền số dương để trả chỗ, số âm để trừ chỗ)
    public function updateTourSeats($tour_id, $quantity_change) {
        $sql = "UPDATE tours SET available_seats = available_seats + ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$quantity_change, $tour_id]);
    }
}
?>