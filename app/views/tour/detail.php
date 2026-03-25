<?php require_once '../app/views/inc/header.php'; ?>

<?php $tour = $data['tour']; ?>

<div class="container mt-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/Project/public/" class="text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><?php echo $tour['category_name']; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $tour['name']; ?></li>
        </ol>
    </nav>

    <div class="row">
        
        <div class="col-md-7 mb-4">
            <?php 
                
                $img_val = trim($tour['image']); 
                if (strpos($img_val, 'http') === 0) {
                    $tour_image = $img_val;
                } else {
                    $tour_image = "/Project/public/images/" . $img_val;
                }
            ?>
            <img src="<?php echo $tour_image; ?>" class="img-fluid rounded-3 shadow" alt="<?php echo $tour['name']; ?>" style="width: 100%; max-height: 450px; object-fit: cover;">
        </div>

        <div class="col-md-5">
            <span class="badge bg-primary mb-2 fs-6"><?php echo $tour['category_name']; ?></span>
            <h2 class="fw-bold mb-3"><?php echo $tour['name']; ?></h2>
            
            <p class="text-danger fw-bold display-6 mb-4">
                <?php echo number_format($tour['price']); ?> <span class="fs-4 text-decoration-underline">đ</span>
            </p>

            <div class="card border-0 bg-light mb-4">
                <div class="card-body">
                    <ul class="list-unstyled mb-0 fs-5 text-secondary">
                        <li class="mb-2">📍 <strong>Khởi hành:</strong> <?php echo $tour['departure_location']; ?></li>
                        <li class="mb-2">📅 <strong>Ngày đi:</strong> <?php echo date('d/m/Y', strtotime($tour['departure_date'])); ?></li>
                        <li class="mb-2">⏱ <strong>Thời lượng:</strong> <?php echo $tour['duration'] ?? 'Đang cập nhật'; ?></li>
                        <li>🪑 <strong>Số ghế còn trống:</strong> <span class="badge bg-success fs-6"><?php echo $tour['available_seats']; ?> ghế</span></li>
                    </ul>
                </div>
            </div>

           <a href="/Project/public/booking/create/<?php echo $tour['id']; ?>" class="btn btn-warning btn-lg w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center" style="height: 60px; font-size: 1.2rem;">
                🛒 ĐẶT TOUR NGAY
            </a>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-12">
            <h3 class="fw-bold border-bottom pb-2 text-primary">📝 Lịch trình & Mô tả chi tiết</h3>
            <div class="mt-4 fs-5" style="line-height: 1.8;">
                <?php echo nl2br($tour['description']); ?>
            </div>
        </div>
    </div>

</div>

<?php require_once '../app/views/inc/footer.php'; ?>