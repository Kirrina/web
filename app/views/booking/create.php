<?php require_once '../app/views/inc/header.php'; ?>
<?php $tour = $data['tour']; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-warning text-dark text-center py-3">
                    <h3 class="fw-bold mb-0">🛒 Xác Nhận Đặt Tour</h3>
                </div>
                
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <?php $img = trim($tour['image']); $src = (strpos($img, 'http') === 0) ? $img : "/Project/public/images/" . $img; ?>
                        <img src="<?php echo $src; ?>" class="rounded shadow-sm me-3" style="width: 120px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="fw-bold text-primary mb-1"><?php echo $tour['name']; ?></h5>
                            <p class="text-muted mb-0">Khởi hành: <?php echo date('d/m/Y', strtotime($tour['departure_date'])); ?></p>
                            <p class="text-danger fw-bold mb-0">Đơn giá: <span id="don_gia" data-price="<?php echo $tour['price']; ?>"><?php echo number_format($tour['price']); ?></span> đ/người</p>
                        </div>
                    </div>

                    <form action="/Project/public/booking/store/<?php echo $tour['id']; ?>" method="POST">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Người đặt</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $_SESSION['user_fullname']; ?>" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-primary">Số lượng người tham gia <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="so_luong" class="form-control form-control-lg border-primary" value="1" min="1" max="<?php echo $tour['available_seats']; ?>" required>
                                <small class="text-success">Còn trống: <?php echo $tour['available_seats']; ?> ghế</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ghi chú thêm (Không bắt buộc)</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Ví dụ: Có trẻ em đi kèm, ăn chay..."></textarea>
                        </div>

                        <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                            <span class="fs-5 fw-bold text-dark">TỔNG THANH TOÁN:</span>
                            <span class="fs-3 fw-bold text-danger" id="tong_tien"><?php echo number_format($tour['price']); ?> đ</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">XÁC NHẬN VÀ THANH TOÁN</button>
                            <a href="/Project/public/tour/detail/<?php echo $tour['id']; ?>" class="btn btn-outline-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputSoLuong = document.getElementById('so_luong');
    const theHienThiTongTien = document.getElementById('tong_tien');
    const donGia = document.getElementById('don_gia').getAttribute('data-price');

   
    inputSoLuong.addEventListener('input', function() {
        let soLuong = this.value;
       
        if(soLuong < 1 || isNaN(soLuong)) {soLuong = 1; this.value = 1;} 
        
        let tongTien = soLuong * donGia;
        
        
        theHienThiTongTien.innerText = new Intl.NumberFormat('vi-VN').format(tongTien) + " đ";
    });
</script>

<?php require_once '../app/views/inc/footer.php'; ?>