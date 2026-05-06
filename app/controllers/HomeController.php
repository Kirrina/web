<?php
class HomeController extends Controller {
    
    public function index() {
      
        $tourModel = $this->model('TourModel');
        
        
        $tours = $tourModel->getAllTours();
        
        
        $this->view('home/index', [
            'tours' => $tours,
            'loi_chao' => 'Danh sách Tour du lịch mới nhất'
        ]);
    }
}
?>