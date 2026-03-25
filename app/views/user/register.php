<?php require_once '../app/views/inc/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        
        <div class="card shadow-lg border-0 rounded-lg mt-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="font-weight-light my-2">Tạo Tài Khoản</h3>
                <?php if (!empty($data['thong_bao'])): ?>
                <div class="alert alert-<?php echo $data['loai_thong_bao']; ?> text-center mx-4 mt-3">
                    <?php echo $data['thong_bao']; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="card-body p-4">
                <form action="/Project/public/user/register" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control form-control-lg" placeholder="Nhập họ tên của bạn" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Mật khẩu</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Tạo mật khẩu" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-lg fw-bold" type="submit">Đăng ký ngay</button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center py-3 bg-light">
                <div class="small">Đã có tài khoản? <a href="/Project/public/user/login" class="text-primary text-decoration-none fw-bold">Đăng nhập ngay</a></div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>