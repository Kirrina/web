<?php
class TourController extends Controller {
    
    
    public function detail($id = 0) {
        
        if (empty($id)) {
            header("Location: /Project/public/");
            exit();
        }

        
        $tourModel = $this->model('TourModel');
        $tour = $tourModel->getTourById($id);

        
        if (!$tour) {
            
            header("Location: /Project/public/");
            exit();
        }

       
        $this->view('tour/detail', [
            'tour' => $tour
        ]);
    }
}
?>