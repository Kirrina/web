<?php
class TourController extends Controller {
    
    public function index() {
        $keyword   = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : "";
        $max_price = isset($_REQUEST['max_price']) ? $_REQUEST['max_price'] : "";
        $ratings   = isset($_REQUEST['rating']) ? $_REQUEST['rating'] : []; 
        $duration  = isset($_REQUEST['duration']) ? $_REQUEST['duration'] : "";
        $sort      = isset($_REQUEST['sort']) ? trim($_REQUEST['sort']) : "popular"; 
        $people    = isset($_REQUEST['people']) ? (int)$_REQUEST['people'] : 0;
        $departure_date = isset($_REQUEST['departure_date']) ? $_REQUEST['departure_date'] : '';
        

        // 1. Cấu hình phân trang
        $page   = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1; // Mặc định là trang 1
        $limit  = 10; // 10 chuyến / trang
        $offset = ($page - 1) * $limit; // Tính vị trí bắt đầu lấy dữ liệu

        $tourModel = $this->model('TourModel');
        
        // 2. Lấy TỔNG SỐ tour (để biết có bao nhiêu trang)
        $totalTours = $tourModel->getTotalTours($keyword, $max_price, $ratings, $duration, $people, $departure_date);
        $totalPages = ceil($totalTours / $limit); // Hàm ceil làm tròn lên (VD: 12 tour / 10 = 1.2 -> 2 trang)

        // 3. Lấy DANH SÁCH tour của riêng trang hiện tại
        $tours = $tourModel->getAllTours($keyword, $max_price, $ratings, $duration, $sort, $people, $limit, $offset, $departure_date);

        // THÊM MỚI: Rút trích danh sách ID của các tour ĐANG HIỂN THỊ
        $currentTourIds = array_column($tours, 'id');

        // Truyền mảng ID này vào hàm lấy Review (Giới hạn hiển thị 2 cái)
        $topReviews = $tourModel->getTopReviews($currentTourIds, 2);

        //Lấy danh sách 14 từ khóa gợi ý (từ các tour ít đánh giá)
        $suggestedKeywords = $tourModel->getSuggestedKeywords(14);

        // lấy FAQ 
        $faqs = $this->model('FaqModel')->getAllFaqs();

        $this->view('tour/list', [
            'tours'      => $tours,
            'faqs' => $faqs,
            'keyword'    => $keyword,
            'page'       => $page,
            'totalPages' => $totalPages,
            'totalTours' => $totalTours,
            'topReviews' => $topReviews,
            'suggestedKeywords' => $suggestedKeywords
        ]);
    }

    //Hiển thị chi tiết 1 sản phẩm
    public function detail($id = 0) {
        
        if (empty($id)) {
            header("Location: /Project/public/");
            exit();
        }

        $tourModel = $this->model('TourModel');
        $tour = $tourModel->getTourById($id);

        if (!$tour) {
            $_SESSION['flash_message'] = "Xin lỗi, tour này hiện không khả dụng!";
            $_SESSION['flash_type'] = "warning";
            header("Location: /Project/public/index.php?url=tour/index");
            exit();
        }

        $durationDays = isset($tour['duration_days']) ? (int)$tour['duration_days'] : 1;

        // Lấy danh sách tour gợi ý
        $suggestedTours = $this->model('TourModel')->getSuggestedTours(
            $tour['category_id'], 
            $tour['id'], 
            $durationDays
        );

        $comments = $this->model('TourModel')->getCommentsByTourId($tour['id']);

        $this->view('tour/detail', [
            'tour' => $tour,
            'suggestedTours' => $suggestedTours,
            'comments' => $comments
        ]);
    }

   public function update() {
    
        if (!isset($_SESSION['user_role']) || $_SESSION['user_status'] !== 'active' || $_SESSION['user_role'] !== 'admin') {
            header("Location: /Project/public/user/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['tour_id'];
            
            $finalImage = $_POST['image_link'] ?? ''; 

            // 2. Xử lý Logic Upload File (nếu admin chọn chế độ 'upload')
            if (isset($_POST['image_type']) && $_POST['image_type'] === 'upload') {
                if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
                    
                    // Đảm bảo dẫn vào đúng folder 'tours'
                    $target_dir = "../public/images/tours/"; 
                    
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }

                    $file_ext = pathinfo($_FILES["image_file"]["name"], PATHINFO_EXTENSION);
                    $new_filename = "tour_" . $id . "_" . time() . "." . $file_ext;
                    $target_file = $target_dir . $new_filename;

                    $allowed_types = ["jpg", "jpeg", "png", "webp", "gif"];
                    if (in_array(strtolower($file_ext), $allowed_types)) {
                        if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                            // Chỉ lưu tên file 
                            $finalImage = $new_filename; 
                        }
                    }
                }
            }

            // --- BẮT ĐẦU: Xử lý chuỗi thời lượng ---
            $durationString = trim($_POST['duration']);
            $durationDays = 1; // Mặc định là 1

            // Nếu chuỗi chứa "trong ngày", gán bằng 1
            if (mb_stripos($durationString, 'trong ngày') !== false) {
                $durationDays = 1;
            } 
            // Nếu chuỗi có số (VD: "3 ngày 2 đêm", "12 ngày"), tự động tách số ra
            elseif (preg_match('/(\d+)\s*ngày/iu', $durationString, $matches)) {
                $durationDays = (int)$matches[1];
            }

            // 3. Chuẩn bị dữ liệu để đưa vào Model (Đã nằm an toàn bên trong if POST)
            $data = [
                'name'               => trim($_POST['name']),
                'description'        => trim($_POST['description']),
                'price'              => $_POST['price'],
                'duration'           => $durationString,
                'duration_days'      => $durationDays,
                'departure_location' => trim($_POST['departure_location']),
                'image'              => $finalImage 
            ];

            $tourModel = $this->model('TourModel');
            if ($tourModel->updateTour($id, $data)) {
                $_SESSION['flash_message'] = "🎉 Cập nhật hành trình thành công!";
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Có lỗi xảy ra khi cập nhật!";
                $_SESSION['flash_type'] = "danger";
            }
            
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
            
        } 
    }

    public function saveFaq() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_status'] !== 'active' || $_SESSION['user_role'] !== 'admin') {
            header("Location: /Project/public/user/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['faq_id'] ?? '';
            $question = trim($_POST['question'] ?? '');
            $answer = trim($_POST['answer'] ?? '');

            if (!empty($question) && !empty($answer)) {
                $faqModel = $this->model('FaqModel');
                
                if ($faqModel->saveFaq($id, $question, $answer)) {
                    $_SESSION['flash_message'] = "Đã lưu câu hỏi FAQ thành công!";
                    $_SESSION['flash_type'] = "success";
                } else {
                    $_SESSION['flash_message'] = "Có lỗi xảy ra khi lưu Database!";
                    $_SESSION['flash_type'] = "danger";
                }
            } else {
                $_SESSION['flash_message'] = "Vui lòng nhập đầy đủ câu hỏi và trả lời!";
                $_SESSION['flash_type'] = "warning";
            }
            
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }



    public function deleteFaq() {
        // Kiểm tra quyền (Admin mới được xóa)
        if (!isset($_SESSION['user_role']) || $_SESSION['user_status'] !== 'active' || $_SESSION['user_role'] !== 'admin') {
            header("Location: /Project/public/user/login");
            exit();
        }

        // Lấy ID từ trên thanh URL (index.php?url=tour/deleteFaq&id=...)
        $id = $_GET['id'] ?? '';

        if (!empty($id)) {
            $faqModel = $this->model('FaqModel');
            if ($faqModel->deleteFaq($id)) {
                $_SESSION['flash_message'] = "🗑️ Đã xóa câu hỏi thành công!";
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Lỗi khi xóa câu hỏi!";
                $_SESSION['flash_type'] = "danger";
            }
        }
        
        // Quay lại trang danh sách tour
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // ==========================================
    // XỬ LÝ CẬP NHẬT THÔNG TIN LIÊN HỆ (LƯU VÀO JSON)
    // ==========================================
    public function updateContact() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_status'] !== 'active' || $_SESSION['user_role'] !== 'admin') {
            header("Location: /Project/public/user/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hotline = trim($_POST['hotline'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (!empty($hotline) && !empty($email)) {
                
                // Gom dữ liệu thành mảng
                $contactData = [
                    'phone' => $hotline,
                    'email' => $email
                ];

                // Lưu vào file contact.json nằm trong thư mục app
                // Cờ JSON_PRETTY_PRINT giúp file json được trình bày đẹp, dễ đọc
                file_put_contents('../app/contact.json', json_encode($contactData, JSON_PRETTY_PRINT));

                $_SESSION['flash_message'] = "Đã cập nhật thông tin liên hệ!";
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Thông tin không được để trống!";
                $_SESSION['flash_type'] = "warning";
            }
            
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function updateItinerary() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Nhận dữ liệu dạng raw JSON gửi từ trình duyệt lên
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (isset($data['tour_id']) && isset($data['itinerary'])) {
                $tourId = $data['tour_id'];
                // Ép mảng thành chuỗi JSON, giữ nguyên tiếng Việt
                $itineraryJson = json_encode($data['itinerary'], JSON_UNESCAPED_UNICODE);
                
                // Khởi tạo Model
                $tourModel = $this->model('TourModel'); 
                $success = $tourModel->updateTourItinerary($tourId, $itineraryJson);
                
                // Trả về kết quả cho Javascript
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
        exit;
    }

    public function postComment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra xem user đã đăng nhập chưa
            if (!isset($_SESSION['user_id'])) {
                // Chưa đăng nhập thì đá về trang Login
                header("Location: /Project/public/user/login");
                exit;
            }

            // Lấy dữ liệu từ Form và Session
            $tourId = $_POST['tour_id'];
            $userId = $_SESSION['user_id']; // Lấy ID chuẩn từ Session
            $rating = (int)$_POST['rating'];
            $content = trim($_POST['content']);

            // Validate cơ bản: Chỉ lưu khi nội dung không bị trống
            if (!empty($content)) {
                // Gọi Model để Insert vào DB
                $tourModel = $this->model('TourModel');
                $tourModel->addComment($tourId, $userId, $rating, $content);
            }

            // Xong thì quay lại đúng trang chi tiết tour đó
            header("Location: /Project/public/index.php?url=tour/detail/" . $tourId . "#review-section");
            exit;
        }
    }

    public function checkout() {
        // 1. Phải đăng nhập mới được vào trang thanh toán
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_message'] = "Vui lòng đăng nhập để tiến hành đặt tour!";
            $_SESSION['flash_type'] = "warning";
            header("Location: /Project/public/user/login"); // Trỏ đúng về route login của bạn
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tourId = $_POST['tour_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if ($tourId) {
                $tourModel = $this->model('TourModel');
                $tour = $tourModel->getTourById($tourId);

                if ($tour) {
                    $this->view("tour/checkout", [
                        'tour' => $tour,
                        'quantity' => $quantity
                    ]);
                    return; // Dừng lại ở đây nếu load view thành công
                }
            }
        }
        
        // Nếu không có POST hoặc không tìm thấy tour, đá về trang chủ
        header("Location: /Project/public/index.php");
        exit;
    }

    public function processBooking() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: /Project/public/user/login");
                exit;
            }

            // Hứng dữ liệu mới từ Form
            $tourId = $_POST['tour_id'];
            $userId = $_SESSION['user_id'];
            $quantity = (int)$_POST['quantity'];
            
            $fullName = trim($_POST['full_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $paymentMethod = $_POST['payment_method'] ?? 'cash';
            $note = trim($_POST['note'] ?? '');

            $tourModel = $this->model('TourModel');
            $result = $tourModel->bookTour($tourId, $userId, $quantity, $fullName, $email, $phone, $paymentMethod, $note);

            if ($result === true) {
                header("Location: /Project/public/index.php?url=tour/success");
                exit;
            } else {
                $_SESSION['flash_message'] = "Lỗi đặt tour: " . $result;
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }
    public function success() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /Project/public/index.php");
            exit;
        }
        
        $this->view('tour/success');
    }
}

?>