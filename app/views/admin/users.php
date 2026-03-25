<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý User - VietTour Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <div class="d-flex">
        <div class="bg-dark text-white p-3 vh-100 position-fixed" style="width: 260px;">
            <h4 class="text-center text-warning border-bottom pb-3 mb-4 fw-bold">
                <i class="bi bi-airplane-engines"></i> Admin
            </h4>
            <ul class="nav flex-column fs-5">
                <li class="nav-item mb-2">
                    <a href="/Project/public/admin" class="nav-link text-white"><i class="bi bi-speedometer2 me-2"></i> Bảng điều khiển</a>
                </li>
                
                <li class="nav-item mb-2">
                    <a href="/Project/public/admin/users" class="nav-link text-white active bg-primary rounded"><i class="bi bi-people me-2"></i> Quản lý User</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/Project/public/admin/tours" class="nav-link text-white"><i class="bi bi-map me-2"></i> Quản lý Tour</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="/Project/public/admin/bookings" class="nav-link text-white"><i class="bi bi-receipt me-2"></i> Đơn đặt Tour</a>
                </li>
                <li class="nav-item mt-5">
                    <a href="/Project/public/" class="nav-link text-danger fw-bold"><i class="bi bi-box-arrow-left me-2"></i> Về trang Web</a>
                </li>
            </ul>
        </div>

        <div class="flex-grow-1 p-4" style="margin-left: 260px;">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark mb-0">👥 Quản Lý Thành Viên</h2>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0 align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">Họ và Tên</th>
                                <th width="25%">Email</th>
                                <th width="15%">Số điện thoại</th>
                                <th width="15%">Vai trò</th>
                                <th width="15%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data['users'])): ?>
                                <?php foreach($data['users'] as $user): ?>
                                    <?php 
                                        
                                        $status = $user['status'] ?? 'active';
                                        $rowStyle = ($status === 'banned') ? 'table-secondary opacity-75' : '';
                                    ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo $user['id']; ?></td>
                                        <td class="text-start fw-bold"><?php echo $user['fullname']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo (!empty($user['phone'])) ? $user['phone'] : '<span class="text-muted small"><i>Chưa cập nhật</i></span>'; ?></td>
                                        
                                        <td>
                                            <?php if($user['role'] === 'admin'): ?>
                                                <span class="badge bg-danger fs-6"><i class="bi bi-star-fill text-warning"></i> Admin</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary">Khách hàng</span>
                                            <?php endif; ?>
                                            
                                            <?php if(isset($user['status']) && $user['status'] === 'banned'): ?>
                                                <br><span class="badge bg-secondary mt-1"><i class="bi bi-slash-circle"></i> Bị khóa</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td>
                                            <?php if($user['id'] == $_SESSION['user_id']): ?>
                                                <span class="badge bg-light text-dark border">Đang đăng nhập</span>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-info text-white" 
                                                        onclick="openEditModal(<?php echo $user['id']; ?>, '<?php echo addslashes($user['fullname']); ?>', '<?php echo $user['email']; ?>', '<?php echo $user['phone'] ?? ''; ?>', '<?php echo $user['role'];  ?>')" 
                                                        title="Sửa thông tin">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <?php 
                                                    $status = $user['status'] ?? 'active';
                                                    if ($status === 'active'): 
                                                ?>
                                                    <a href="/Project/public/admin/toggle_status/<?php echo $user['id']; ?>/active" 
                                                    class="btn btn-sm btn-outline-warning" title="Khóa tài khoản">
                                                        <i class="bi bi-lock"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="/Project/public/admin/toggle_status/<?php echo $user['id']; ?>/banned" 
                                                    class="btn btn-sm btn-success" title="Mở khóa tài khoản">
                                                        <i class="bi bi-unlock-fill"></i> Mở khóa
                                                    </a>
                                                <?php endif; ?>

                                                <a href="/Project/public/admin/delete_user/<?php echo $user['id']; ?>" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn người này?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Chưa có thành viên nào!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editUserForm" action="" method="POST" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Chỉnh sửa tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Quyền hạn (Role)</label>
                    <select name="role" id="edit_role" class="form-select border-primary">
                        <option value="user">Khách hàng (User)</option>
                        <option value="admin">Quản trị viên (Admin)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và Tên</label>
                    <input type="text" name="fullname" id="edit_fullname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Số điện thoại</label>
                    <input type="text" name="phone" id="edit_phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-danger">Mật khẩu mới (Để trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới nếu cần...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function openEditModal(id, fullname, email, phone, role) {
        document.getElementById('edit_fullname').value = fullname;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_role').value = role;
        
        document.getElementById('editUserForm').action = '/Project/public/admin/update_user/' + id;
        
        var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        myModal.show();
    }
</script>

</body>
</html>