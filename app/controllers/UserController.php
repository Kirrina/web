<?php
class UserController extends Controller {

    public function index() {
        
        if (isset($_SESSION['user_id'])) {
            header("Location: /Project/public");
        } 
        
        else {
            header("Location: /Project/public/user/login");
        }
        exit();
    }
    
    public function register() {
        $viewData = ['thong_bao' => '', 'loai_thong_bao' => ''];

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
          
            $postData = [
                'fullname' => trim($_POST['fullname']),
                'email' => trim($_POST['email']),
                'password' => $_POST['password']
            ];

           
            $userService = $this->service('UserService');
            $ket_qua = $userService->register($postData);

            
            if ($ket_qua['status'] == true) {
                
                $_SESSION['flash_message'] = "🎉 Tuyệt vời! Bạn đã đăng ký thành công. Xin mời đăng nhập.";
                $_SESSION['flash_type'] = "success";
                
                
                header("Location: /Project/public/user/login");
                exit(); 
            } else {
                
                $viewData['thong_bao'] = $ket_qua['message'];
                $viewData['loai_thong_bao'] = 'danger';
            }
        }

        
        $this->view('user/register', $viewData);
    }

    
    public function login() {
        $viewData = ['thong_bao' => '', 'loai_thong_bao' => ''];


        if (isset($_SESSION['flash_message'])) {
            
            $viewData['thong_bao'] = $_SESSION['flash_message'];
            $viewData['loai_thong_bao'] = $_SESSION['flash_type'];
            
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userService = $this->service('UserService');
            $ket_qua = $userService->login($email, $password);

            if ($ket_qua['status'] == true) {
                
                $_SESSION['user_id'] = $ket_qua['data']['id'];
                $_SESSION['user_fullname'] = $ket_qua['data']['fullname'];
                $_SESSION['user_role'] = $ket_qua['data']['role']; 
                $_SESSION['user_status'] = $ket_qua['data']['status'];

                $_SESSION['user_avatar'] = $ket_qua['data']['avatar'];

               
                if ($_SESSION['user_role'] === 'admin') {
                    header("Location: /Project/public/admin");
                } else {
                    header("Location: /Project/public/");
                }
                exit();
            } else {
                
                $viewData['thong_bao'] = $ket_qua['message'];
                $viewData['loai_thong_bao'] = 'danger';
            }
        }

        
        $this->view('user/login', $viewData);
    }


    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /Project/public/user/login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userModel = $this->model('UserModel');
        $viewData = ['thong_bao' => '', 'loai_thong_bao' => '', 'active_form' => ''];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            

            if (isset($_POST['update_info'])) {
                $viewData['active_form'] = 'info';
                $fullname = trim($_POST['fullname']);
                
    
                $isNameUpdated = $userModel->updateProfile($userId, $fullname);
                if ($isNameUpdated) {
                    $_SESSION['user_fullname'] = $fullname;
                    $viewData['thong_bao'] = 'Cập nhật thông tin thành công!';
                    $viewData['loai_thong_bao'] = 'success';
                }

                
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                    $target_dir = "../public/images/";
                    
                    
                    $file_extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
                    
                    $new_filename = "avatar_" . $userId . "_" . time() . "." . $file_extension;
                    $target_file = $target_dir . $new_filename;

                    $allowed_types = ["jpg", "jpeg", "png", "gif"];
                    if (in_array(strtolower($file_extension), $allowed_types)) {
                       
                        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                            
                            $userModel->updateAvatar($userId, $new_filename);
                           
                            $_SESSION['user_avatar'] = $new_filename; 
                            $viewData['thong_bao'] = 'Cập nhật tên và ảnh đại diện thành công!';
                        } else {
                            $viewData['thong_bao'] = 'Lỗi: Không thể lưu file ảnh vào hệ thống!';
                            $viewData['loai_thong_bao'] = 'danger';
                        }
                    } else {
                        $viewData['thong_bao'] = 'Lỗi: Chỉ chấp nhận file ảnh (JPG, PNG, GIF)!';
                        $viewData['loai_thong_bao'] = 'danger';
                    }
                }
            }

            
            if (isset($_POST['change_pass'])) {
                $viewData['active_form'] = 'pass';
                $oldPass = $_POST['old_password'];
                $newPass = $_POST['new_password'];
                $confirmPass = $_POST['confirm_password'];

                if ($newPass !== $confirmPass) {
                    $viewData['thong_bao'] = 'Mật khẩu mới nhập lại không khớp!';
                    $viewData['loai_thong_bao'] = 'danger';
                } else {
                    $userService = $this->service('UserService');
                    $ket_qua = $userService->changePassword($userId, $oldPass, $newPass);
                    $viewData['thong_bao'] = $ket_qua['message'];
                    $viewData['loai_thong_bao'] = $ket_qua['status'] ? 'success' : 'danger';
                }
            }
        }

        $viewData['user'] = $userModel->getUserById($userId);
        $this->view('user/profile', $viewData);
    }

  
    public function logout() {
        
        session_unset();
        session_destroy();
        
        
        header("Location: /Project/public/user/login");
        exit();
    }
    
}
?>