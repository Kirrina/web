<?php
    // Hàm rút gọn tiền: 1,500,000 -> 1.5 Tr | 2,000,000,000 -> 2 Tỷ
    function formatDoanhThu($num) {
        if ($num >= 1000000000) {
            return round($num / 1000000000, 1) . ' Tỷ';
        } elseif ($num >= 1000000) {
            return round($num / 1000000, 1) . ' Tr';
        } elseif ($num >= 1000) {
            return round($num / 1000, 1) . ' K';
        }
        return number_format($num, 0, ',', '.') . 'đ';
    }
?>

<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Tổng Quan - CloudJourney Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="/Project/public/admin_assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/themify-icons.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/metisMenu.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/typography.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/default-css.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/styles.css">
    <link rel="stylesheet" href="/Project/public/admin_assets/css/responsive.css">
    
    <!-- Nhúng Alpine.js cho Dropdown Avatar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* CSS Lột Xác Giao Diện */
        body { background-color: #f8f9fc; }
        
        /* Ép nền trắng cho Header, xóa cái nền tím cũ */
        .page-title-area { background: #ffffff !important; box-shadow: 0 1px 15px rgba(0,0,0,0.04); padding: 15px 30px; }
        
        /* Thẻ thống kê bo tròn hiện đại */
        .modern-stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #f1f3f5;
            transition: transform 0.3s;
        }
        .modern-stat-card:hover { transform: translateY(-5px); }
        .stat-icon-box {
            width: 65px; height: 65px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; margin-right: 20px;
        }
        .stat-content h4 { font-size: 14px; color: #8a909d; margin-bottom: 5px; font-weight: 600; text-transform: uppercase; }
        .stat-content h2 { font-size: 28px; font-weight: 800; color: #2c3136; margin: 0; }
        
        /* Bảng hiển thị đẹp */
        .card { border-radius: 20px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .table thead th { border-bottom: none; color: #8a909d; font-size: 12px; font-weight: 700; }
        .table tbody td { border-top: 1px solid #f8f9fc; padding: 18px 15px; vertical-align: middle; }
        
        /* Avatar tự sinh */
        .avatar-circle {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: white; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 16px; 
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            flex-shrink: 0; /* CHỐNG BỊ ÉP NHỎ LÀM ĐÈ CHỮ */
            margin-right:10px;
        }
    </style>
</head>

<body>
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
                            <li class="active">
                                <a href="/Project/public/index.php?url=admin/index"><i class="ti-dashboard"></i><span>Tổng quan</span></a>
                            </li>
                            <li>
                                <a href="/Project/public/index.php?url=admin/tours"><i class="ti-package"></i><span>Quản lý Tour</span></a>
                            </li>
                            <li>
                                <a href="#"><i class="ti-shopping-cart-full"></i><span>Quản lý Đơn hàng</span></a>
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
                
                <!-- 4 THẺ THỐNG KÊ (DỮ LIỆU THẬT) -->
                <div class="row mt-4">
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="modern-stat-card">
                            <div class="stat-icon-box" style="background: #eef2ff; color: #4f46e5;">
                                <i class="ti-package"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Tổng Tour</h4>
                                <h2><?= number_format($data['stats']['total_tours']) ?></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="modern-stat-card">
                            <div class="stat-icon-box" style="background: #ecfdf5; color: #10b981;">
                                <i class="ti-shopping-cart"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Đơn Đặt Tour</h4>
                                <h2><?= number_format($data['stats']['total_bookings']) ?></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="modern-stat-card">
                            <div class="stat-icon-box" style="background: #fff1f2; color: #e11d48;">
                                <i class="ti-money"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Doanh Thu</h4>
                                <h2><?= formatDoanhThu($data['stats']['total_revenue']) ?></h2>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="modern-stat-card">
                            <div class="stat-icon-box" style="background: #fffbeb; color: #d97706;">
                                <i class="ti-user"></i>
                            </div>
                            <div class="stat-content">
                                <h4>Khách Hàng</h4>
                                <h2><?= number_format($data['stats']['total_customers']) ?></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BẢNG ĐƠN HÀNG MỚI NHẤT (DỮ LIỆU THẬT) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <h4 class="header-title mb-4 font-weight-bold">Đơn đặt tour mới nhất</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead class="bg-light">
                                            <tr class="text-uppercase">
                                                <th>Mã Đơn</th>
                                                <th class="text-left">Khách hàng</th>
                                                <th class="text-left">Chuyến đi</th>
                                                <th>Ngày đặt</th>
                                                <th>Trạng thái</th>
                                                <th class="text-right">Tổng tiền</th>
    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(empty($data['latest_bookings'])): ?>
                                                <tr><td colspan="7" class="text-muted py-4">Chưa có đơn đặt tour nào.</td></tr>
                                            <?php else: ?>
                                                <?php foreach($data['latest_bookings'] as $booking): ?>
                                                <tr>
                                                    <!-- Mã đơn có chữ BK và tự động độn số 0 -->
                                                    <td class="font-weight-bold text-secondary">#BK-<?= sprintf('%03d', $booking['id']) ?></td>
                                                    <td class="text-left font-weight-bold text-dark"><?= htmlspecialchars($booking['full_name']) ?></td>
                                                    <td class="text-left text-muted"><?= htmlspecialchars($booking['tour_name']) ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></td>
                                                    
                                                    <!-- SỬA Ở ĐÂY: Đổi sang màu chữ và thêm chấm tròn -->
                                                    <td class="font-weight-bold">
                                                        <?php 
                                                            // strtolower giúp đưa về chữ thường hết để so sánh không bị lỗi
                                                            $status = strtolower(trim($booking['status'] ?? '')); 
                                                        ?>
                                                        
                                                        <?php if($status == 'pending'): ?>
                                                            <span class="text-warning"><i class="fa fa-circle mr-1" style="font-size: 8px; vertical-align: middle;"></i> Chờ duyệt</span>
                                                        <?php elseif($status == 'confirmed'): ?>
                                                            <span class="text-success"><i class="fa fa-circle mr-1" style="font-size: 8px; vertical-align: middle;"></i> Đã xác nhận</span>
                                                        <?php elseif($status == 'cancelled'): ?>
                                                            <span class="text-danger"><i class="fa fa-circle mr-1" style="font-size: 8px; vertical-align: middle;"></i> Đã hủy</span>
                                                        <?php else: ?>
                                                            <!-- Nếu DB trống hoặc trạng thái lạ, sẽ hiện màu xám -->
                                                            <span class="text-secondary"><i class="fa fa-circle mr-1" style="font-size: 8px; vertical-align: middle;"></i> Không rõ</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="text-right font-weight-bold text-primary">
                                                        <?= number_format($booking['total_price'], 0, ',', '.') ?>đ
                                                    </td>
                                                    
                                                </tr>
                                                <?php endforeach; ?>
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
        <footer><div class="footer-area"><p>© Copyright 2024. CloudJourney Admin System.</p></div></footer>
    </div>

    <script src="/Project/public/admin_assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="/Project/public/admin_assets/js/popper.min.js"></script>
    <script src="/Project/public/admin_assets/js/bootstrap.min.js"></script>
    <script src="/Project/public/admin_assets/js/metisMenu.min.js"></script>
    <script src="/Project/public/admin_assets/js/jquery.slimscroll.min.js"></script>
    <script src="/Project/public/admin_assets/js/jquery.slicknav.min.js"></script>
    <script src="/Project/public/admin_assets/js/scripts.js"></script>
</body>
</html>