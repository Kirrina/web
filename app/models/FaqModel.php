<?php
require_once '../app/core/Database.php';
class FaqModel extends Database {
    
    // 1. Lấy toàn bộ danh sách FAQ
    public function getAllFaqs() {
        // Lấy câu hỏi và sắp xếp theo ID cũ nhất đến mới nhất
        $sql = "SELECT * FROM faqs ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // 2. Lưu (Thêm mới hoặc Cập nhật) FAQ
    public function saveFaq($id, $question, $answer) {
        if (empty($id)) {
            // Nếu không có ID -> Thêm mới
            $sql = "INSERT INTO faqs (question, answer) VALUES (:question, :answer)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':question' => $question,
                ':answer' => $answer
            ]);
        } else {
            // Nếu có ID -> Cập nhật câu hỏi cũ
            $sql = "UPDATE faqs SET question = :question, answer = :answer WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':question' => $question,
                ':answer' => $answer,
                ':id' => $id
            ]);
        }
    }

    // 3. Xóa FAQ
    public function deleteFaq($id) {
        $sql = "DELETE FROM faqs WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}