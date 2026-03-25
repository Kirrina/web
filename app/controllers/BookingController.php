<?php
class BookingController extends Controller {
    
   
    public function create($tour_id = 0) {
        
       
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "Vui lòng đăng nhập để có thể đặt Tour!";
            $_SESSION['flash_type'] = "warning";
            header("Location: /Project/public/user/login");
            exit();
        }

        
        $tourModel = $this->model('TourModel');
        $tour = $tourModel->getTourById($tour_id);

        
        if (!$tour) {
            header("Location: /Project/public/");
            exit();
        }

        
        $this->view('booking/create', [
            'tour' => $tour
        ]);
    }

   
    public function store($tour_id = 0) {
       
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
            header("Location: /Project/public/");
            exit();
        }

        
        $userId = $_SESSION['user_id'];
        $quantity = (int)$_POST['quantity'];
        $notes = trim($_POST['notes']);

        
        $tourModel = $this->model('TourModel');
        $tour = $tourModel->getTourById($tour_id);

        if (!$tour || $quantity < 1 || $quantity > $tour['available_seats']) {
            $_SESSION['flash_message'] = "Lỗi: Số lượng ghế không hợp lệ hoặc đã hết chỗ!";
            $_SESSION['flash_type'] = "danger";
            header("Location: /Project/public/tour/detail/" . $tour_id);
            exit();
        }

       
        $totalPrice = $tour['price'] * $quantity;

       
        $bookingModel = $this->model('BookingModel');
        $isSaved = $bookingModel->createBooking($userId, $tour_id, $quantity, $totalPrice, $notes);

        if ($isSaved) {
            
            $tourModel->decreaseSeats($tour_id, $quantity);

            
            $_SESSION['flash_message'] = "🎉 TUYỆT VỜI! Đặt Tour thành công. Chúc bạn một chuyến đi vui vẻ!";
            $_SESSION['flash_type'] = "success";
            header("Location: /Project/public/");
            exit();
        } else {
            $_SESSION['flash_message'] = "Có lỗi xảy ra, không thể đặt tour!";
            $_SESSION['flash_type'] = "danger";
            header("Location: /Project/public/booking/create/" . $tour_id);
            exit();
        }
    }
}
?>