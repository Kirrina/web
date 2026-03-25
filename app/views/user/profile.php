<?php require_once '../app/views/inc/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><h5>Cập nhật thông tin</h5></div>
                <div class="card-body">
                    <?php if (!empty($data['thong_bao']) && $data['loai_thong_bao'] == 'success' && $data['active_form'] == 'info'): ?>
                        <div class="alert alert-success"><?php echo $data['thong_bao']; ?></div>
                    <?php endif; ?>
                    
                    <form action="/Project/public/user/profile" method="POST" enctype="multipart/form-data">
                        
                        <div class="text-center mb-3">
                            <?php 
                                $current_avatar = $data['user']['avatar'];
                                if ($current_avatar == 'default_avatar.jpg' || empty($current_avatar)) {
                                    $img_show = "https://ui-avatars.com/api/?name=" . urlencode($data['user']['fullname']) . "&background=random&size=100";
                                } else {
                                    $img_show = "/Project/public/images/" . $current_avatar;
                                }
                            ?>
                            <img src="<?php echo $img_show; ?>" class="rounded-circle shadow" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email (Không thể sửa)</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $data['user']['email']; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ và Tên</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $data['user']['fullname']; ?>" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Thay đổi Ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" name="update_info" class="btn btn-primary w-100 fw-bold">Lưu thay đổi</button>
                    </form>
                    
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark"><h5>Đổi mật khẩu</h5></div>
                <div class="card-body">
                    
                     <?php if (!empty($data['thong_bao']) && $data['loai_thong_bao'] == 'success' && $data['active_form'] == 'pass'): ?>
                        <div class="alert alert-success"><?php echo $data['thong_bao']; ?></div>
                    <?php endif; ?>

                    <?php if (!empty($data['thong_bao']) && $data['loai_thong_bao'] == 'danger'): ?>
                        <div class="alert alert-danger"><?php echo $data['thong_bao']; ?></div>
                    <?php endif; ?>

                    <form action="/Project/public/user/profile" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu cũ</label>
                            <input type="password" name="old_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <button type="submit" name="change_pass" class="btn btn-warning fw-bold">Xác nhận đổi mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>