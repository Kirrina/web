<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản Lý Đơn Hàng - CloudJourney Admin</title>
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
        .form-control[readonly] { background-color: #f8f9fc; opacity: 1; border: 1px dashed #e2e8f0; font-weight: 600; color: #4a5568;}
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
                            <li>
                                <a href="/Project/public/index.php?url=admin/users"><i class="ti-user"></i><span>Quản lý User</span></a>
                            </li>
                            <li>
                                <a href="/Project/public/index.php?url=admin/tours"><i class="ti-package"></i><span>Quản lý Tour</span></a>
                            </li>
                            <li class="active">
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
                                <h4 class="header-title mb-4">Tất cả Đơn đặt Tour</h4>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-center align-middle">
                                        <thead class="bg-light">
                                            <tr class="text-uppercase text-muted" style="font-size: 13px;">
                                                <th>Mã Đơn</th>
                                                <th class="text-left">Khách Hàng</th>
                                                <th class="text-left">Chuyến Đi</th>
                                                <th>Số Lượng</th>
                                                <th>Tổng Tiền</th>
                                                <th>Ngày Đặt</th>
                                                <th>Trạng Thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($data['bookings'])): ?>
                                                <?php foreach($data['bookings'] as $b): 
                                                    // Xử lý fallback cho khách hàng (Nếu khách vãng lai không có tên thì lấy tên User Account)
                                                    $cName = !empty($b['full_name']) ? $b['full_name'] : $b['user_fullname'];
                                                    $cPhone = !empty($b['phone']) ? $b['phone'] : $b['user_phone'];
                                                    $cEmail = !empty($b['email']) ? $b['email'] : $b['user_email'];
                                                ?>
                                                <tr>
                                                    <td class="font-weight-bold text-secondary">#BK-<?= sprintf('%03d', $b['id']) ?></td>
                                                    <td class="text-left font-weight-bold text-dark">
                                                        <?= htmlspecialchars($cName ?? 'Khách Ẩn Danh') ?><br>
                                                        <small class="text-muted font-weight-normal"><?= htmlspecialchars($cPhone ?? '') ?></small>
                                                    </td>
                                                    <td class="text-left text-primary font-weight-bold"><?= htmlspecialchars($b['tour_name'] ?? 'Tour đã xóa') ?></td>
                                                    <td><?= $b['quantity'] ?></td>
                                                    <td class="font-weight-bold text-danger"><?= number_format($b['total_price']) ?>đ</td>
                                                    <td><?= date('d/m/Y', strtotime($b['created_at'])) ?><br><small class="text-muted"><?= date('H:i', strtotime($b['created_at'])) ?></small></td>
                                                    
                                                    <td>
                                                        <?php if($b['status'] == 'pending'): ?>
                                                            <span class="text-warning font-weight-bold"><i class="fa fa-circle mr-1" style="font-size: 8px;"></i> Chờ duyệt</span>
                                                        <?php elseif($b['status'] == 'confirmed'): ?>
                                                            <span class="text-success font-weight-bold"><i class="fa fa-circle mr-1" style="font-size: 8px;"></i> Đã xác nhận</span>
                                                        <?php else: ?>
                                                            <span class="text-danger font-weight-bold"><i class="fa fa-circle mr-1" style="font-size: 8px;"></i> Đã hủy</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info rounded-circle mx-1 shadow-sm" 
                                                                data-id="<?= $b['id'] ?>"
                                                                data-name="<?= htmlspecialchars($cName ?? '', ENT_QUOTES) ?>"
                                                                data-phone="<?= htmlspecialchars($cPhone ?? '', ENT_QUOTES) ?>"
                                                                data-email="<?= htmlspecialchars($cEmail ?? '', ENT_QUOTES) ?>"
                                                                data-tour="<?= htmlspecialchars($b['tour_name'] ?? '', ENT_QUOTES) ?>"
                                                                data-qty="<?= $b['quantity'] ?>"
                                                                data-total="<?= number_format($b['total_price']) ?>đ"
                                                                data-pay="<?= $b['payment_method'] == 'card' ? 'Thẻ Tín Dụng' : 'Tiền Mặt' ?>"
                                                                data-note="<?= htmlspecialchars($b['note'] ?? 'Không có ghi chú', ENT_QUOTES) ?>"
                                                                data-status="<?= $b['status'] ?>"
                                                                onclick="openBookingModal(this)" title="Xem chi tiết">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                        <a href="/Project/public/index.php?url=admin/deleteBooking/<?= $b['id'] ?>" 
                                                           class="btn btn-sm btn-danger rounded-circle shadow-sm" 
                                                           onclick="return confirm('Bạn có chắc chắn muốn XÓA đơn hàng này không?');">
                                                            <i class="ti-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr><td colspan="8" class="text-muted py-4">Chưa có đơn hàng nào!</td></tr>
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

    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/Project/public/index.php?url=admin/updateBooking" method="POST">
                    <input type="hidden" name="booking_id" id="modal_booking_id">

                    <div class="modal-header position-relative">
                        <h5 class="modal-title font-weight-bold text-dark">Chi Tiết Đơn Đặt Tour <span id="modal_booking_code" class="text-primary ml-2"></span></h5>
                        <button type="button" class="close position-absolute" style="right: 20px; top: 15px;" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6 border-right">
                                <h6 class="font-weight-bold text-primary mb-3"><i class="ti-user mr-2"></i>Thông tin khách hàng</h6>
                                <div class="form-group mb-2">
                                    <label class="text-sm text-muted mb-1">Họ và tên</label>
                                    <input type="text" id="modal_c_name" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-sm text-muted mb-1">Số điện thoại</label>
                                    <input type="text" id="modal_c_phone" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-sm text-muted mb-1">Email</label>
                                    <input type="text" id="modal_c_email" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-success mb-3"><i class="ti-package mr-2"></i>Thông tin Dịch vụ</h6>
                                <div class="form-group mb-2">
                                    <label class="text-sm text-muted mb-1">Tên Tour</label>
                                    <input type="text" id="modal_t_name" class="form-control form-control-sm" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-6 form-group mb-2">
                                        <label class="text-sm text-muted mb-1">Số khách</label>
                                        <input type="text" id="modal_t_qty" class="form-control form-control-sm text-center" readonly>
                                    </div>
                                    <div class="col-6 form-group mb-2">
                                        <label class="text-sm text-muted mb-1">Tổng tiền</label>
                                        <input type="text" id="modal_t_total" class="form-control form-control-sm text-danger text-center" readonly>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label class="text-sm text-muted mb-1">Hình thức thanh toán</label>
                                    <input type="text" id="modal_t_pay" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group bg-light p-3 rounded mb-4">
                            <label class="font-weight-bold text-dark"><i class="ti-comments mr-2"></i>Ghi chú của khách:</label>
                            <p id="modal_c_note" class="mb-0 text-muted font-italic"></p>
                        </div>

                        <hr>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-danger">Cập nhật Trạng thái Đơn hàng</label>
                            <select name="status" id="modal_status" class="form-control border-danger font-weight-bold" required>
                                <option value="pending" class="text-warning">Chờ duyệt (Pending)</option>
                                <option value="confirmed" class="text-success">Đã xác nhận (Confirmed)</option>
                                <option value="cancelled" class="text-danger">Hủy đơn (Cancelled)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="ti-save mr-1"></i> Lưu Trạng Thái</button>
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
        window.openBookingModal = function(btnElement) {
            let $btn = $(btnElement);
            
            $('#modal_booking_code').text('#BK-' + String($btn.attr('data-id')).padStart(3, '0'));
            $('#modal_booking_id').val($btn.attr('data-id'));
            
            $('#modal_c_name').val($btn.attr('data-name'));
            $('#modal_c_phone').val($btn.attr('data-phone'));
            $('#modal_c_email').val($btn.attr('data-email'));
            
            $('#modal_t_name').val($btn.attr('data-tour'));
            $('#modal_t_qty').val($btn.attr('data-qty') + ' Người');
            $('#modal_t_total').val($btn.attr('data-total'));
            $('#modal_t_pay').val($btn.attr('data-pay'));
            
            $('#modal_c_note').text($btn.attr('data-note'));
            $('#modal_status').val($btn.attr('data-status'));
            
            $('#bookingModal').modal({ backdrop: 'static', show: true });
        };

        // Giữ vị trí cuộn trang (Tương tự bên Tour)
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('admin_bookings_scroll', window.scrollY);
        });
        document.addEventListener("DOMContentLoaded", function() {
            let scrollPos = sessionStorage.getItem('admin_bookings_scroll');
            if (scrollPos) {
                window.scrollTo({ top: parseInt(scrollPos), behavior: 'instant' });
                sessionStorage.removeItem('admin_bookings_scroll');
            }
        });
    </script>
</body>
</html>