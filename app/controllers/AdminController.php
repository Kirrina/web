<?php
class AdminController extends Controller {
    
   
    public function __construct() {
    
        if (!isset($_SESSION['user_id']) && $_SESSION['user_role'] !== 'admin') {
       
            $_SESSION['flash_message'] = "Cảnh báo: Bạn không có quyền truy cập khu vực này!";
            $_SESSION['flash_type'] = "danger";
            header("Location: /Project/public/"); 
            exit();
        }

    }

    
   
    public function index() {
        // Gọi Model
        $adminModel = $this->model('AdminModel');
        
        // Lấy số liệu thống kê
        $soLieu = $adminModel->getDashboardStats();
        
        // LẤY THÊM: 5 đơn hàng đặt tour mới nhất
        $danhSachMoiNhat = $adminModel->getLatestBookings(4);

        // Truyền cả 2 cục dữ liệu sang View
        $this->view('admin/dashboard', [
            'stats' => $soLieu,
            'latest_bookings' => $danhSachMoiNhat // View sẽ dùng biến này để vẽ bảng
        ]);
    }

    
    // Trang Quản lý danh sách Tour
    public function tours() {
        $adminModel = $this->model('AdminModel');
        // Giả sử bạn đã có 2 hàm này trong AdminModel
        $danhSachTour = $adminModel->getAdminTours(); 
        $danhMuc = $adminModel->getAllCategories();

        $this->view('admin/tours', [
            'tours' => $danhSachTour,
            'categories' => $danhMuc
        ]);
    }

    // Hàm Xử lý Gộp (Vừa Thêm mới, Vừa Cập nhật từ Modal)
    public function saveTour() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $adminModel = $this->model('AdminModel');
            $id = $_POST['tour_id'] ?? ''; 
            
            // 1. XỬ LÝ ẢNH ĐẠI DIỆN CHÍNH (IMAGE)
            $imageName = $_POST['old_image'] ?? 'default-tour.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "../public/images/tours/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                $file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $imageName = "tour_" . time() . "." . $file_ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $imageName);
            }

            // 2. XỬ LÝ THƯ VIỆN ẢNH (GALLERY)
            $oldGallery = json_decode($_POST['old_gallery'] ?? '[]', true);
            if (!is_array($oldGallery)) $oldGallery = [];

            // Xóa các ảnh được đánh dấu tích xóa
            $deletedImages = $_POST['delete_gallery'] ?? []; 
            if (!empty($deletedImages)) {
                $oldGallery = array_filter($oldGallery, function($img) use ($deletedImages) {
                    return !in_array($img, $deletedImages);
                });
            }

            // Upload các ảnh gallery mới
            $newGallery = [];
            if (isset($_FILES['new_gallery']) && !empty($_FILES['new_gallery']['name'][0])) {
                $target_dir = "../public/images/tours/";
                foreach ($_FILES['new_gallery']['name'] as $key => $name) {
                    if ($_FILES['new_gallery']['error'][$key] == 0) {
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        $newName = "gal_" . time() . "_" . $key . "." . $ext;
                        if (move_uploaded_file($_FILES['new_gallery']['tmp_name'][$key], $target_dir . $newName)) {
                            $newGallery[] = $newName;
                        }
                    }
                }
            }
            // Gộp ảnh cũ còn lại và ảnh mới upload
            $finalGallery = array_merge(array_values($oldGallery), $newGallery);

            // 3. GOM DỮ LIỆU TỪ FORM
            $data = [
                ':name' => trim($_POST['name']),
                ':category_id' => $_POST['category_id'],
                ':description' => trim($_POST['description'] ?? ''),
                ':itinerary' => trim($_POST['itinerary'] ?? ''), // JSON Text
                ':price' => (int)$_POST['price'],
                ':discount' => (int)$_POST['discount'],
                ':departure_date' => $_POST['departure_date'],
                ':duration' => trim($_POST['duration']),
                ':duration_days' => 1, 
                ':departure_location' => 'TP.HCM', // Mặc định
                ':available_seats' => (int)$_POST['available_seats'],
                ':status' => $_POST['status'] ?? 'active',
                ':image' => $imageName,
                ':gallery' => json_encode($finalGallery)
            ];

            if (empty($id)) {
                $adminModel->insertTour($data);
                $_SESSION['flash_message'] = "Thêm Tour thành công!";
            } else {
                $data[':id'] = $id;
                $adminModel->updateTour($data);
                $_SESSION['flash_message'] = "Cập nhật Tour thành công!";
            }
            
            $_SESSION['flash_type'] = "success";
            
            header("Location: /Project/public/index.php?url=admin/tours");
            exit;
        }
    }
    public function deleteTour($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteTour($id)) {
            $_SESSION['flash_message'] = "Đã xóa tour thành công!";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Lỗi khi xóa dữ liệu!";
            $_SESSION['flash_type'] = "danger";
        }
        
        header("Location: /Project/public/index.php?url=admin/tours");
        exit();
    }

    // Xử lý Thêm hoặc Sửa Danh mục
    public function saveCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = trim($_POST['cat_id'] ?? '');
            $name = trim($_POST['cat_name'] ?? '');
            $description = trim($_POST['cat_description'] ?? '');

            if (!empty($name)) {
                $adminModel = $this->model('AdminModel');
                
                if (empty($id)) {
                    // Không có ID -> Thêm mới
                    $adminModel->addCategory($name, $description);
                    $_SESSION['flash_message'] = "Thêm danh mục mới thành công!";
                } else {
                    // Có ID -> Cập nhật
                    $adminModel->updateCategory($id, $name, $description);
                    $_SESSION['flash_message'] = "Cập nhật danh mục thành công!";
                }
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Tên danh mục không được để trống!";
                $_SESSION['flash_type'] = "danger";
            }
            header("Location: /Project/public/index.php?url=admin/tours");
            exit();
        }
    }

    // Hàm Xóa Danh Mục
    public function deleteCategory($id) {
        $adminModel = $this->model('AdminModel');
        if ($adminModel->deleteCategory($id)) {
            $_SESSION['flash_message'] = "Đã xóa danh mục và các Tour liên quan!";
            $_SESSION['flash_type'] = "success";
        } else {
            $_SESSION['flash_message'] = "Có lỗi xảy ra khi xóa!";
            $_SESSION['flash_type'] = "danger";
        }
        header("Location: /Project/public/index.php?url=admin/tours");
        exit();
    }

    // =====================================
    // QUẢN LÝ ĐƠN HÀNG (BOOKINGS)
    // =====================================
    
    // Trang danh sách đơn hàng
    public function bookings() {
        $adminModel = $this->model('AdminModel');
        $bookings = $adminModel->getAllBookings();

        $this->view('admin/bookings', [
            'bookings' => $bookings
        ]);
    }

    // Xử lý cập nhật trạng thái đơn hàng (Có logic hoàn trả chỗ)
    public function updateBooking() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['booking_id'];
            $new_status = $_POST['status'];
            
            $adminModel = $this->model('AdminModel');
            
            // 1. Lấy thông tin đơn hàng HIỆN TẠI trước khi update
            $booking = $adminModel->getBookingById($id);
            
            if ($booking) {
                $old_status = $booking['status'];
                $qty = (int)$booking['quantity'];
                $tour_id = $booking['tour_id'];

                // 2. SO SÁNH LOGIC ĐỂ HOÀN TRẢ / TRỪ CHỖ
                // Trường hợp 1: Chuyển từ (Chờ/Xác nhận) -> HỦY => Trả lại chỗ (+qty)
                if ($old_status != 'cancelled' && $new_status == 'cancelled') {
                    $adminModel->updateTourSeats($tour_id, $qty);
                }
                // Trường hợp 2: Khách đổi ý, từ HỦY -> MỞ LẠI (Chờ/Xác nhận) => Trừ lại chỗ (-qty)
                elseif ($old_status == 'cancelled' && $new_status != 'cancelled') {
                    $adminModel->updateTourSeats($tour_id, -$qty);
                }

                // 3. Tiến hành cập nhật trạng thái mới
                if ($adminModel->updateBookingStatus($id, $new_status)) {
                    $_SESSION['flash_message'] = "Cập nhật trạng thái thành công!";
                    $_SESSION['flash_type'] = "success";
                }
            } else {
                $_SESSION['flash_message'] = "Không tìm thấy đơn hàng!";
                $_SESSION['flash_type'] = "danger";
            }
            
            header("Location: /Project/public/index.php?url=admin/bookings");
            exit;
        }
    }

    // Xóa đơn hàng (Có logic hoàn trả chỗ nếu Admin lỡ tay xóa)
    public function deleteBooking($id) {
        $adminModel = $this->model('AdminModel');
        
        // 1. Lấy thông tin đơn hàng trước khi xóa vĩnh viễn
        $booking = $adminModel->getBookingById($id);

        if ($booking) {
            // 2. Nếu đơn này chưa bị Hủy (Tức là nó đang ngậm số chỗ của Tour) -> Phải trả lại chỗ
            if ($booking['status'] != 'cancelled') {
                $adminModel->updateTourSeats($booking['tour_id'], (int)$booking['quantity']);
            }

            // 3. Tiến hành xóa khỏi Database
            if ($adminModel->deleteBooking($id)) {
                $_SESSION['flash_message'] = "Đã xóa đơn hàng và hoàn lại số chỗ trống cho Tour!";
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Có lỗi xảy ra khi xóa!";
                $_SESSION['flash_type'] = "danger";
            }
        }
        
        header("Location: /Project/public/index.php?url=admin/bookings");
        exit;
    }
    
    // =====================================
    // QUẢN LÝ NGƯỜI DÙNG (USERS)
    // =====================================
    
    public function users() {
        $userModel = $this->model('UserModel');
        $danhSachUser = $userModel->getAllUsers();
        $this->view('admin/users', ['users' => $danhSachUser]);
    }

    public function delete_user($id) {
        $userModel = $this->model('UserModel');
        if ($userModel->deleteUser($id)) {
            $_SESSION['flash_message'] = "Đã xóa vĩnh viễn người dùng!";
            $_SESSION['flash_type'] = "success";
        }
        header("Location: /Project/public/index.php?url=admin/users");
        exit;
    }

    public function toggle_status($id, $current_status) {
        $userModel = $this->model('UserModel');
        $newStatus = ($current_status === 'active') ? 'banned' : 'active';
        
        if ($userModel->updateStatus($id, $newStatus)) {
            $_SESSION['flash_message'] = "Đã thay đổi trạng thái tài khoản!";
            $_SESSION['flash_type'] = "success";
        }
        header("Location: /Project/public/index.php?url=admin/users");
        exit;
    }
    
    public function update_user($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            
            $userModel = $this->model('UserModel');
            if ($userModel->updateAccount($id, $fullname, $email, $phone, $role, $password)) {
                $_SESSION['flash_message'] = "Cập nhật thông tin và quyền hạn thành công!";
                $_SESSION['flash_type'] = "success";
            } else {
                $_SESSION['flash_message'] = "Có lỗi xảy ra khi cập nhật!";
                $_SESSION['flash_type'] = "danger";
            }
            header("Location: /Project/public/index.php?url=admin/users");
            exit();
        }
    }
}
?>