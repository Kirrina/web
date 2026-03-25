<?php

require_once '../app/models/UserModel.php';

class UserService {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

   
    public function register($data) {
        
        if ($this->userModel->checkEmailExist($data['email'])) {
            return ['status' => false, 'message' => 'Lỗi: Email này đã được sử dụng!'];
        }

        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        
        $isSaved = $this->userModel->createUser($data['fullname'], $data['email'], $hashedPassword);

        if ($isSaved) {
            return ['status' => true, 'message' => 'Đăng ký thành công! Hãy đăng nhập.'];
        } else {
            return ['status' => false, 'message' => 'Lỗi: Không thể lưu vào hệ thống!'];
        }
    }

    
    public function login($email, $password) {
       
        $user = $this->userModel->getUserByEmail($email);

        
        if ($user && password_verify($password, $user['password'])) {
            
           
            if ($user['status'] == 'banned') {
                return ['status' => false, 'message' => 'Tài khoản của bạn đã bị khóa!'];
            }

           
            return ['status' => true, 'data' => $user];
        }

        
        return ['status' => false, 'message' => 'Email hoặc mật khẩu không chính xác!'];
    }

    public function changePassword($userId, $oldPassword, $newPassword) {
       
        $user = $this->userModel->getUserById($userId);

        
        if (!password_verify($oldPassword, $user['password'])) {
            return ['status' => false, 'message' => 'Mật khẩu cũ không chính xác!'];
        }

        
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        if ($this->userModel->updatePassword($userId, $hashedPassword)) {
            return ['status' => true, 'message' => 'Đổi mật khẩu thành công!'];
        }

        return ['status' => false, 'message' => 'Có lỗi xảy ra khi đổi mật khẩu!'];
    }

   
    public function deleteUser($id) {
        
        if ($this->userModel->deleteUser($id)) {
            return ['status' => true, 'message' => 'Đã xóa người dùng vĩnh viễn!'];
        }
        return ['status' => false, 'message' => 'Lỗi khi xóa người dùng!'];
    }

   
    public function toggleStatus($id) {
       
        $user = $this->userModel->getUserById($id);
        
        if (!$user) return ['status' => false, 'message' => 'Không tìm thấy người dùng!'];

        $currentStatus = $user['status'] ?? 'active';
        $newStatus = ($currentStatus === 'active') ? 'banned' : 'active';
        
       
        if ($this->userModel->updateStatus($id, $newStatus)) {
            return ['status' => true, 'message' => 'Cập nhật thành công!'];
        }
        return ['status' => false, 'message' => 'Lỗi cập nhật!'];
    }

    
   public function adminUpdateUser($id, $fullname, $email, $phone, $role, $newPassword = null) {
       
        return $this->userModel->updateAccount($id, $fullname, $email, $phone, $role, $newPassword);
    }
}
?>