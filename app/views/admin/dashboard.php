<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Quản Trị - VietTour</title>
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
                    <a href="/Project/public/admin" class="nav-link text-white active bg-primary rounded"><i class="bi bi-speedometer2 me-2"></i> Bảng điều khiển</a>
                </li>
                
                <li class="nav-item mb-2">
                    <a href="/Project/public/admin/users" class="nav-link text-white"><i class="bi bi-people me-2"></i> Quản lý User</a>
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
            
            <div class="d-flex justify-content-between align-items-center mb-5 bg-white p-3 rounded shadow-sm">
                <h2 class="fw-bold text-dark mb-0">Bảng điều khiển (Dashboard)</h2>
                <div class="d-flex align-items-center">
                    <?php 
                        
                        $avatar = $_SESSION['user_avatar'] ?? '';
                        if (empty($avatar) || $avatar == 'default_avatar.jpg') {
                            
                            $src = "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user_fullname']) . "&background=random";
                        } else if (strpos($avatar, 'http') === 0) {
                            $src = $avatar;
                        } else {
                            $src = "/Project/public/images/" . $avatar;
                        }
                    ?>
                    <img src="<?php echo $src; ?>" class="rounded-circle me-2 border border-2 border-primary bg-white" style="width: 45px; height: 45px; object-fit: cover;">
                    <span class="fw-bold fs-5 text-primary">Sếp <?php echo $_SESSION['user_fullname']; ?></span>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white shadow rounded-4 border-0">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Tổng số Tour</h5>
                                <h1 class="display-4 fw-bold mb-0"><?php echo $data['stats']['total_tours']; ?></h1> </div>
                            <i class="bi bi-map display-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-success text-white shadow rounded-4 border-0">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Đơn hàng mới</h5>
                                <h1 class="display-4 fw-bold mb-0"><?php echo $data['stats']['new_bookings']; ?></h1>
                            </div>
                            <i class="bi bi-cart-check display-1 opacity-50"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning text-dark shadow rounded-4 border-0">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Tổng doanh thu</h5>
                                <h1 class="display-5 fw-bold mb-0 text-truncate" style="max-width: 100%;"><?php echo number_format($data['stats']['total_revenue']); ?> đ</h1>
                            </div>
                            <i class="bi bi-cash-coin display-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>