<?php
require_once '../app/core/Database.php';

class TourModel extends Database {
    
    // Đếm tổng số tour thỏa mãn điều kiện lọc
    public function getTotalTours($keyword = "", $max_price = "", $ratings = [], $duration = "", $people = 0, $departure_date = "") {
        $sql = "SELECT COUNT(*) as total FROM tours WHERE status = 'active'";
        $params = []; 
        
        if (!empty($keyword)) {
            $sql .= " AND (name COLLATE utf8mb4_general_ci LIKE :keyword OR departure_location COLLATE utf8mb4_general_ci LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }
        if (!empty($max_price)) {
            $sql .= " AND price <= :max_price";
            $params[':max_price'] = $max_price;
        }
        if (!empty($ratings) && is_array($ratings)) {
            $rateConditions = [];
            if (in_array('5', $ratings)) $rateConditions[] = "rate = 5";
            if (in_array('4', $ratings)) $rateConditions[] = "rate >= 4";
            if (in_array('under_4', $ratings)) $rateConditions[] = "(rate < 4 OR rate IS NULL )";
            if (count($rateConditions) > 0) $sql .= " AND (" . implode(" OR ", $rateConditions) . ")";
        }
        if (!empty($duration)) {
            if ($duration == '1') {
                $sql .= " AND duration_days = 1";
            } elseif ($duration == '2-3') {
                $sql .= " AND duration_days BETWEEN 2 AND 3";
            } elseif ($duration == '4-7') {
                $sql .= " AND duration_days BETWEEN 4 AND 7";
            } elseif ($duration == 'over_7') {
                $sql .= " AND duration_days > 7";
            }
        }
        if (!empty($people) && $people > 0) {
            $sql .= " AND available_seats >= :people";
            $params[':people'] = $people;
        }
        if (!empty($departure_date)) {
            $sql .= " AND departure_date BETWEEN DATE_SUB(:dep_date, INTERVAL 3 DAY) 
                                        AND DATE_ADD(:dep_date, INTERVAL 3 DAY)";
            $params[':dep_date'] = $departure_date;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params); 
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getAllTours($keyword = "", $max_price = "", $ratings = [], $duration = "", $sort = "popular", $people = 0, $limit = 10, $offset = 0, $departure_date="") {
        $sql = "SELECT tours.*, categories.name as category_name FROM tours JOIN categories ON tours.category_id = categories.id WHERE tours.status = 'active'";
        $params = []; 

        // Copy y hệt logic nối chuỗi SQL của hàm đếm ở trên xuống (cho keyword, max_price, ratings, duration, people)
        if (!empty($keyword)) {
            $sql .= " AND (tours.name COLLATE utf8mb4_general_ci LIKE :keyword OR tours.departure_location COLLATE utf8mb4_general_ci LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }
        if (!empty($max_price)) {
            $sql .= " AND tours.price <= :max_price";
            $params[':max_price'] = $max_price;
        }
        if (!empty($ratings) && is_array($ratings)) {
            $rateConditions = [];
            if (in_array('5', $ratings)) $rateConditions[] = "tours.rate = 5";
            if (in_array('4', $ratings)) $rateConditions[] = "tours.rate >= 4";
            if (in_array('under_4', $ratings)) $rateConditions[] = "(tours.rate < 4 OR tours.rate IS NULL )";
            if (count($rateConditions) > 0) $sql .= " AND (" . implode(" OR ", $rateConditions) . ")";
        }
        if (!empty($duration)) {
            if ($duration == '1') {
                $sql .= " AND tours.duration_days = 1";
            } elseif ($duration == '2-3') {
                $sql .= " AND tours.duration_days BETWEEN 2 AND 3";
            } elseif ($duration == '4-7') {
                $sql .= " AND tours.duration_days BETWEEN 4 AND 7";
            } elseif ($duration == 'over_7') {
                $sql .= " AND tours.duration_days > 7";
            }
        }
        if (!empty($people) && $people > 0) {
            $sql .= " AND tours.available_seats >= :people";
            $params[':people'] = $people;
        }

        if (!empty($departure_date)) {
            $sql .= " AND departure_date BETWEEN DATE_SUB(:dep_date, INTERVAL 3 DAY) 
                                        AND DATE_ADD(:dep_date, INTERVAL 3 DAY)";
            $params[':dep_date'] = $departure_date;
        }

        // Logic Sort
        if ($sort === 'price_asc') $sql .= " ORDER BY tours.price ASC";
        elseif ($sort === 'price_desc') $sql .= " ORDER BY tours.price DESC";
        else $sql .= " ORDER BY tours.review_count DESC, tours.id DESC";
        
        // Thêm LIMIT và OFFSET ở cuối cùng
        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params); 
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


    // Lấy các đánh giá tiêu biểu của CÁC TOUR ĐANG ĐƯỢC HIỂN THỊ
    public function getTopReviews($tourIds = [], $limit = 2) {
        // Nếu danh sách tour rỗng (ví dụ lọc không ra kết quả), thì không có review nào cả
        if (empty($tourIds)) {
            return [];
        }

        // Tạo chuỗi dấu chấm hỏi (?,?,?) tương ứng với số lượng ID để chống SQL Injection
        $placeholders = implode(',', array_fill(0, count($tourIds), '?'));

        $sql = "SELECT c.*, t.name as tour_name, u.fullname as customer_name 
                FROM comments c
                JOIN tours t ON c.tour_id = t.id 
                JOIN users u ON c.user_id = u.id
                WHERE c.rating >= 4 
                AND c.tour_id IN ($placeholders) 
                ORDER BY c.created_at DESC 
                LIMIT " . (int)$limit;
                
        $stmt = $this->conn->prepare($sql);
        // Ném trực tiếp mảng ID vào execute() để nó tự động thay thế cho các dấu ?
        $stmt->execute($tourIds); 
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentsByTourId($tourId, $limit = 5) {
        try {
            // Đã thêm LIMIT vào dòng cuối cùng của câu SQL
            $sql = "SELECT c.id, c.tour_id, c.rating, c.content, c.created_at, u.fullname AS customer_name 
                    FROM comments c
                    JOIN users u ON c.user_id = u.id
                    WHERE c.tour_id = :tour_id
                    ORDER BY c.created_at DESC
                    LIMIT " . (int)$limit;
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tour_id' => $tourId]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("<div style='background: #ffebee; color: red; padding: 20px; margin: 20px; border-radius: 8px; font-family: sans-serif;'>
                    <strong>LỖI SQL TRONG MODEL:</strong><br> " . $e->getMessage() . 
                "</div>");
        }
    }

    // Thêm bình luận mới vào Database
    public function addComment($tourId, $userId, $rating, $content) {
        // 1. Chèn bình luận vào bảng comments
        $sqlInsert = "INSERT INTO comments (tour_id, user_id, rating, content, created_at) 
                      VALUES (:tour_id, :user_id, :rating, :content, NOW())";
                
        $stmtInsert = $this->conn->prepare($sqlInsert);
        $inserted = $stmtInsert->execute([
            ':tour_id' => $tourId,
            ':user_id' => $userId,
            ':rating'  => $rating,
            ':content' => $content
        ]);

        // 2. Nếu chèn thành công, tiến hành đồng bộ lại số liệu cho bảng tours
        if ($inserted) {
            // Câu SQL này lấy Count và Average của bảng comments để đè lên bảng tours
            $sqlUpdate = "UPDATE tours 
                          SET review_count = (SELECT COUNT(*) FROM comments WHERE tour_id = :tour_id1),
                              rate = (SELECT AVG(rating) FROM comments WHERE tour_id = :tour_id2)
                          WHERE id = :tour_id3";
                          
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':tour_id1' => $tourId,
                ':tour_id2' => $tourId,
                ':tour_id3' => $tourId
            ]);
            
            return true;
        }
        
        return false;
    }

    public function getSuggestedKeywords($limit = 14) {
        // Lấy tên tour, sắp xếp theo số lượng đánh giá tăng dần (ASC)
        // Dùng IFNULL để đề phòng trường hợp cột review_count bị NULL
        $sql = "SELECT name FROM tours ORDER BY IFNULL(review_count, 0) ASC LIMIT " . (int)$limit;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Rút trích kết quả thành 1 mảng 1 chiều chỉ chứa các cái tên
        return array_column($results, 'name');
    }

    public function updateTour($id, $data) {
        $sql = "UPDATE tours SET 
                name = :name, 
                description = :description, 
                price = :price, 
                duration = :duration,
                duration_days = :duration_days,
                departure_location = :departure_location,
                image = :image
                WHERE id = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name'        => $data['name'],
            ':description' => $data['description'],
            ':price'       => $data['price'],
            ':duration'    => $data['duration'],
            ':duration_days'      => $data['duration_days'],
            ':departure_location' => $data['departure_location'],
            ':image'       => $data['image'],
            ':id'          => $id
        ]);
    }

    public function updateTourItinerary($id, $itineraryJson) {
        $sql = "UPDATE tours SET itinerary = :itinerary WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':itinerary' => $itineraryJson,
            ':id' => $id
        ]);
    }

    public function getSuggestedTours($categoryId, $currentTourId, $durationDays) {
        $minDays = max(1, $durationDays - 2); 
        $maxDays = $durationDays + 2;

        // Dùng JOIN để lấy luôn tên category từ bảng categories
        $sql = "SELECT t.id, t.name, t.image, t.price, t.discount, t.duration, t.rate, t.review_count, c.name as category_name 
                FROM tours t
                JOIN categories c ON t.category_id = c.id
                WHERE t.category_id = :category_id 
                AND t.id != :current_tour_id 
                AND t.available_seats > 0 
                AND t.status = 'active'
                AND t.duration_days BETWEEN :min_days AND :max_days
                ORDER BY RAND() 
                LIMIT 4";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':category_id' => $categoryId,
            ':current_tour_id' => $currentTourId,
            ':min_days' => $minDays,
            ':max_days' => $maxDays
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
    // Cập nhật tham số truyền vào dùng transaction để bảo đảm an toàn dữ liệu 
    public function bookTour($tourId, $userId, $quantity, $fullName, $email, $phone, $paymentMethod, $note) {
        try {
            //bắt đầu giao dịch khóa sql
            $this->conn->beginTransaction();

            $stmtCheck = $this->conn->prepare("SELECT available_seats, price, discount FROM tours WHERE id = ?");
            $stmtCheck->execute([$tourId]);
            $tour = $stmtCheck->fetch();

            if ($tour['available_seats'] < $quantity) {
                throw new Exception("Rất tiếc, tour này chỉ còn " . $tour['available_seats'] . " chỗ trống.");
            }

            $price = $tour['price'] ?? 0;
            $discount = $tour['discount'] ?? 0;
            $totalPrice = ($price - $discount) * $quantity;

            // Thêm các cột mới vào câu SQL
            $sqlInsert = "INSERT INTO bookings (tour_id, user_id, full_name, email, phone, quantity, total_price, payment_method, note, created_at, status) 
                          VALUES (:tour_id, :user_id, :full_name, :email, :phone, :quantity, :total_price, :payment_method, :note, NOW(), 'pending')";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            $stmtInsert->execute([
                ':tour_id' => $tourId,
                ':user_id' => $userId,
                ':full_name' => $fullName,
                ':email' => $email,
                ':phone' => $phone,
                ':quantity' => $quantity,
                ':total_price' => $totalPrice,
                ':payment_method' => $paymentMethod,
                ':note' => $note
            ]);

            $sqlUpdate = "UPDATE tours SET available_seats = available_seats - :quantity WHERE id = :tour_id";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':quantity' => $quantity,
                ':tour_id' => $tourId
            ]);

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return $e->getMessage();
        }
    }
}
?>