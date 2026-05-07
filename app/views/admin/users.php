<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản Lý Người Dùng - CloudJourney Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/Project/public/admin_assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/themify-icons.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/metisMenu.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/typography.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/default-css.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/styles.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/responsive.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { background-color: #f8f9fc; }
        .page-title-area { background: #ffffff !important; box-shadow: 0 1px 15px rgba(0,0,0,0.04); padding: 15px 30px; }
        .card { border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .avatar-circle { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #6366f1); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; flex-shrink: 0; margin-right:10px; }
        .modal-content { border-radius: 15px; border: none; }
        .modal-header { background: #f8f9fc; border-radius: 15px 15px 0 0; border-bottom: 1px solid #e2e8f0; }
        .form-control { border-radius: 8px; border: 1px solid #e2e8f0; }
        .table-banned { background-color: #fef2f2 !important; opacity: 0.85; }
    </style>
</head>

<body>

    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        
        <!-- SIDEBAR -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="/Project/public/index.php?url=admin/index"><h3 class="text-white font-weight-bold">CloudJourney</h3></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li>
                                <a href="/Project/public/index.php?url=admin/index"><i class="ti-dashboard"></i><span>Tổng quan</span></a>
                            </li>
                            <li class="active">
                                <a href="/Project/public/index.php?url=admin/users"><i class="ti-user"></i><span>Quản lý User</span></a>
                            </li>
                            <li>
                                <a href="/Project/public/index.php?url=admin/tours"><i class="ti-package"></i><span>Quản lý Tour</span></a>
                            </li>
                            <li>
                                <a href="/Project/public/index.php?url=admin/bookings"><i class="ti-shopping-cart-full"></i><span>Quản lý Đơn hàng</span></a>
                            </li>
                            <li>
                                <a href="/Project/public/index.php" target="_blank"><i class="ti-home"></i><span>Xem Website</span></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- NỘI DUNG CHÍNH -->
        <div class="main-content">
            <!-- Header phía trên (Nút đóng mở menu) -->
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Khu vực User Profile - Đã sửa lỗi Dropdown bằng AlpineJS -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left font-weight-bold" style="color:#2c3136 !important;">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><span>Tổng Quan Hệ Thống</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end align-items-center">
                        
                        <!-- DROP DOWN MENU AVATAR (ALPINE.JS) -->
                        <div x-data="{ open: false }" class="pull-right position-relative" style="margin-top: 5px;">
                            <button @click="open = !open" @click.outside="open = false" style="background:none; border:none; outline:none; cursor:pointer;" class="d-flex align-items-center">
                                <div class="avatar-circle">
                                    <?= mb_substr(htmlspecialchars($_SESSION['user_fullname']), 0, 1, "UTF-8") ?>
                                </div>
                                <h4 class="user-name text-dark ml-3 mb-0" style="font-size: 15px; font-weight: 600;">
                                    <?= htmlspecialchars($_SESSION['user_fullname'] ?? 'Admin') ?> 
                                    <i class="fa fa-angle-down ml-1 text-muted"></i>
                                </h4>
                            </button>

                            <div x-show="open" x-transition x-cloak class="dropdown-menu show" style="position: absolute; right: 0; top: 120%; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none; min-width: 180px;">
                                <a class="dropdown-item py-2" href="/Project/public/index.php"><i class="ti-home mr-2 text-muted"></i> Về Website</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-2 text-danger" href="/Project/public/index.php?url=user/logout"><i class="ti-shift-right mr-2"></i> Đăng xuất</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="main-content-inner">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <h4 class="header-title mb-4">Danh sách Thành viên</h4>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-center align-middle">
                                        <thead class="bg-light">
                                            <tr class="text-uppercase text-muted" style="font-size: 13px;">
                                                <th>STT</th>
                                                <th class="text-left">Họ và Tên</th>
                                                <th class="text-left">Email</th>
                                                <th>Số điện thoại</th>
                                                <th>Vai trò</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($data['users'])): ?>
                                                <?php $stt = 1; // Khởi tạo biến đếm STT ?>
                                                <?php foreach($data['users'] as $user): ?>
                                                <?php $isBanned = ($user['status'] === 'banned'); ?>
                                                
                                                <tr class="<?= $isBanned ? 'table-banned' : '' ?>">
                                                    <td class="font-weight-bold text-secondary"><?= $stt++ ?></td>
                                                    
                                                    <td class="text-left font-weight-bold text-dark"><?= htmlspecialchars($user['fullname']) ?></td>
                                                    <td class="text-left text-primary"><?= htmlspecialchars($user['email']) ?></td>
                                                    <td><?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : '<span class="text-muted italic">Chưa có</span>' ?></td>
                                                    
                                                    <td>
                                                        <?php if($user['role'] === 'admin'): ?>
                                                            <span class="badge px-3 py-2 shadow-sm" style="background-color: #f59e0b; color: #ffffff; font-size: 12px; border-radius: 6px;">
                                                                <i class="ti-crown mr-1"></i> Admin
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge px-3 py-2 shadow-sm" style="background-color: #0ea5e9; color: #ffffff; font-size: 12px; border-radius: 6px;">
                                                                <i class="ti-user mr-1"></i> Khách hàng
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php if($isBanned): ?>
                                                            <span class="text-danger font-weight-bold"><i class="fa fa-lock mr-1"></i> Bị Khóa</span>
                                                        <?php else: ?>
                                                            <span class="text-success font-weight-bold"><i class="fa fa-circle mr-1" style="font-size: 8px;"></i> Hoạt động</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <?php if($user['id'] == $_SESSION['user_id']): ?>
                                                            <span class="badge badge-light border text-muted">Đang đăng nhập</span>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-sm btn-info rounded-circle mx-1 shadow-sm" 
                                                                    onclick="openEditUserModal(<?= $user['id'] ?>, '<?= htmlspecialchars($user['fullname'], ENT_QUOTES) ?>', '<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>', '<?= htmlspecialchars($user['phone'] ?? '', ENT_QUOTES) ?>', '<?= $user['role'] ?>')" title="Sửa">
                                                                <i class="ti-pencil"></i>
                                                            </button>
                                                            
                                                            <a href="/Project/public/index.php?url=admin/toggle_status/<?= $user['id'] ?>/<?= $user['status'] ?>" 
                                                               class="btn btn-sm <?= $isBanned ? 'btn-success' : 'btn-warning' ?> rounded-circle shadow-sm mx-1" title="<?= $isBanned ? 'Mở Khóa' : 'Khóa Tài Khoản' ?>">
                                                                <i class="<?= $isBanned ? 'ti-unlock' : 'ti-lock' ?>"></i>
                                                            </a>
                                                            
                                                            <a href="/Project/public/index.php?url=admin/delete_user/<?= $user['id'] ?>" 
                                                               class="btn btn-sm btn-danger rounded-circle shadow-sm" 
                                                               onclick="return confirm('Cảnh báo: Thao tác này sẽ xóa vĩnh viễn user. Bạn có chắc chắn?');" title="Xóa">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="7" class="text-muted py-4">Chưa có người dùng nào.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editUserForm" action="" method="POST">
                    <div class="modal-header position-relative bg-light">
                        <h5 class="modal-title font-weight-bold text-dark">Cập Nhật Người Dùng</h5>
                        <button type="button" class="close position-absolute" style="right: 20px; top: 15px;" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Vai trò (Role)</label>
                            <select name="role" id="edit_role" class="form-control">
                                <option value="user">Khách hàng (User)</option>
                                <option value="admin">Quản trị viên (Admin)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" name="fullname" id="edit_fullname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Số điện thoại</label>
                            <input type="text" name="phone" id="edit_phone" class="form-control">
                        </div>
                        <hr>
                        <div class="form-group mb-0">
                            <label class="font-weight-bold text-danger">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" placeholder="Để trống nếu không muốn đổi mật khẩu...">
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="ti-save mr-1"></i> Lưu Thay Đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Project/public/admin_assets/js/metisMenu.min.js"></script>
    <script src="/Project/public/admin_assets/js/jquery.slimscroll.min.js"></script>
    <script src="/Project/public/admin_assets/js/scripts.js"></script>

    <script>
        function openEditUserModal(id, fullname, email, phone, role) {
            $('#edit_fullname').val(fullname);
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            $('#edit_role').val(role);
            
            // Gắn URL hành động mới vào Form
            $('#editUserForm').attr('action', '/Project/public/index.php?url=admin/update_user/' + id);
            
            // Bật Modal
            $('#editUserModal').modal({ backdrop: 'static', show: true });
        }

        // Kỹ thuật giữ nguyên thanh cuộn
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('admin_users_scroll', window.scrollY);
        });
        document.addEventListener("DOMContentLoaded", function() {
            let scrollPos = sessionStorage.getItem('admin_users_scroll');
            if (scrollPos) {
                window.scrollTo({ top: parseInt(scrollPos), behavior: 'instant' });
                sessionStorage.removeItem('admin_users_scroll');
            }
        });
    </script>
</body>
</html>