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
       
        $adminModel = $this->model('AdminModel');
        
        
        $soLieu = $adminModel->getDashboardStats();

        
        $this->view('admin/dashboard', [
            'stats' => $soLieu
        ]);
    }

    
    public function tours() {
        
        $tourModel = $this->model('TourModel');
        
        $danhSachTour = $tourModel->getAllTours();
        
       
        $this->view('admin/tours', [
            'tours' => $danhSachTour
        ]);
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