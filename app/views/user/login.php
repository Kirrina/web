<?php require_once '../app/views/inc/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header bg-success text-white text-center py-3">
                <h3 class="font-weight-light my-2">Đăng Nhập</h3>
            </div>
            
            <div class="card-body p-4">
                <?php if (!empty($data['thong_bao'])): ?>
                    <div class="alert alert-<?php echo $data['loai_thong_bao']; ?> text-center">
                        <?php echo $data['thong_bao']; ?>
                    </div>
                <?php endif; ?>

                <form action="/Project/public/user/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Nhập email" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary">Mật khẩu</label>
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Nhập mật khẩu" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg fw-bold" type="submit">Đăng Nhập</button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center py-3 bg-light">
                <div class="small">Chưa có tài khoản? <a href="/Project/public/user/register" class="text-success text-decoration-none fw-bold">Đăng ký ngay</a></div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>