<?php
class HomeController extends Controller {
    
    public function index() {
      
        $tourModel = $this->model('TourModel');
        
        
        $allTours = $tourModel->getAllTours();
        
        
        $this->view('home/index', [
            'tours' => $allTours,
            'loi_chao' => 'Danh sách Tour du lịch mới nhất'
        ]);
    }
}
?>