<?php
class AdminController extends Controller {
    
   
    public function __construct() {
    
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
       
            $_SESSION['flash_message'] = "Cảnh báo: Bạn không có quyền truy cập khu vực này!";
            $_SESSION['flash_type'] = "danger";
            header("Location: /Project/public/"); 
            exit();
        }

        require_once '../app/services/UserService.php'; 
        $this->userService = new UserService();
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
            
            // Xử lý upload ảnh (nếu có chọn ảnh mới)
            $imageName = $_POST['old_image'] ?? 'default-tour.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "../public/images/tours/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                
                $file_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $imageName = "tour_" . time() . "." . $file_ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $imageName);
            }

            // Gom dữ liệu từ Form Modal
            $data = [
                ':name' => trim($_POST['name']),
                ':category_id' => $_POST['category_id'],
                ':description' => '', // Tạm để trống do Modal chưa có ô mô tả
                ':price' => (int)$_POST['price'],
                ':discount' => (int)$_POST['discount'],
                ':departure_date' => $_POST['departure_date'],
                ':duration' => trim($_POST['duration']),
                ':duration_days' => 1, // Tạm gắn mặc định, bạn có thể tách chuỗi số sau
                ':departure_location' => 'TP.HCM', // Tạm gắn mặc định
                ':available_seats' => (int)$_POST['available_seats'],
                ':image' => $imageName
            ];

            if (empty($id)) {
                // LOGIC THÊM MỚI (Insert)
                $adminModel->insertTour($data);
                $_SESSION['flash_message'] = "Thêm Tour thành công!";
            } else {
                // LOGIC CẬP NHẬT (Update) - Nhét thêm ID vào mảng data
                $data[':id'] = $id;
                $adminModel->updateTour($data);
                $_SESSION['flash_message'] = "Cập nhật Tour thành công!";
            }
            
            $_SESSION['flash_type'] = "success";
            header("Location: /Project/public/index.php?url=admin/tours");
            exit;
        }
    }
    
    public function users() {
        
        $userModel = $this->model('UserModel');
        
        
        $danhSachUser = $userModel->getAllUsers();
        
        
        $this->view('admin/users', [
            'users' => $danhSachUser
        ]);
    }


    
    

   
    public function delete_user($id) {
        $this->userService->deleteUser($id);
        header("Location: /Project/public/admin/users");
    }

    public function toggle_status($id, $current_status) {
        $this->userService->toggleStatus($id, $current_status);
        header("Location: /Project/public/admin/users");
    }
    
    
    public function update_user($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            
            $this->userService->adminUpdateUser($id, $fullname, $email, $phone, $role, $password);
            header("Location: /Project/public/admin/users");
            exit();
        }
    }
}
?>