<?php require_once '../app/views/inc/header.php'; ?>

<div class="p-5 mb-4 rounded-3 shadow-sm text-white" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1200&auto=format&fit=crop'); background-size: cover; background-position: center;">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold text-warning">Khám phá thế giới cùng VietTour</h1>
        <p class="col-md-8 fs-4 mt-3">Hàng ngàn tour du lịch hấp dẫn đang chờ đón bạn. Đặt ngay hôm nay!</p>
    </div>
</div>

<div class="container">
    <h2 class="text-center text-primary fw-bold mb-5 mt-4" id="danh-sach-tour">🔥 CÁC TOUR ĐANG HOT 🔥</h2>
    
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php if(!empty($data['tours'])): ?>
            <?php foreach($data['tours'] as $tour): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 transition-hover">
                        <?php 
                            $img_val = trim($tour['image']);
                            
                            
                            if (strpos($img_val, 'http') === 0) {
                                
                                $tour_image = $img_val;
                            } else {
        
                                $tour_image = "/Project/public/images/" . $img_val;
                            }
                        ?>
                        <img src="<?php echo $tour_image; ?>" class="card-img-top" alt="<?php echo $tour['name']; ?>" style="height: 200px; object-fit: cover;">    

                        <div class="card-body">
                            <span class="badge bg-info text-dark mb-2"><?php echo $tour['category_name']; ?></span>
                            <h5 class="card-title fw-bold text-dark"><?php echo $tour['name']; ?></h5>
                            
                            <p class="card-text text-muted small">
                                📍 Khởi hành: <?php echo $tour['departure_location']; ?><br>
                                📅 Ngày đi: <?php echo date('d/m/Y', strtotime($tour['departure_date'])); ?>
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-danger fw-bold fs-5"><?php echo number_format($tour['price']); ?>đ</span>
                                <a href="/Project/public/tour/detail/<?php echo $tour['id']; ?>" class="btn btn-outline-primary btn-sm px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">Hiện tại chưa có tour nào. Vui lòng quay lại sau!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>