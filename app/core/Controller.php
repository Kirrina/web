<?php
class Controller {
    
   
    public function view($view, $data = []) {
        
        if (file_exists('../app/views/' . $view . '.php')) {
            extract($data);
            require_once '../app/views/' . $view . '.php';
        } else {
            echo "Lỗi: Không tìm thấy giao diện này!";
        }
    }

   
    public function service($service) {
        if (file_exists('../app/services/' . $service . '.php')) {
            require_once '../app/services/' . $service . '.php';
            return new $service();
        }
    }

   
    public function model($model) {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model();
        }
    }
}
?>