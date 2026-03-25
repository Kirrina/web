<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tour - VietTour Admin</title>
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
                    <a href="/Project/public/admin/users" class="nav-link text-white"><i class="bi bi-people me-2"></i> Quản lý User</a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/Project/public/admin/tours" class="nav-link text-white active bg-primary rounded"><i class="bi bi-map me-2"></i> Quản lý Tour</a>
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
                <h2 class="fw-bold text-dark mb-0">📦 Quản Lý Danh Sách Tour</h2>
                <a href="#" class="btn btn-success fw-bold"><i class="bi bi-plus-lg"></i> Thêm Tour Mới</a>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-0">
                    <table class="table table-hover table-bordered mb-0 align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Hình ảnh</th>
                                <th width="25%">Tên Tour</th>
                                <th width="15%">Danh mục</th>
                                <th width="15%">Giá tiền</th>
                                <th width="10%">Ghế trống</th>
                                <th width="15%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($data['tours'])): ?>
                                <?php foreach($data['tours'] as $tour): ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo $tour['id']; ?></td>
                                        
                                        <td>
                                            <?php 
                                                $img = trim($tour['image']); 
                                                $src = (strpos($img, 'http') === 0) ? $img : "/Project/public/images/" . $img; 
                                            ?>
                                            <img src="<?php echo $src; ?>" class="rounded shadow-sm" style="width: 80px; height: 50px; object-fit: cover;">
                                        </td>
                                        
                                        <td class="text-start fw-bold text-primary"><?php echo $tour['name']; ?></td>
                                        <td><span class="badge bg-info text-dark"><?php echo $tour['category_name']; ?></span></td>
                                        <td class="text-danger fw-bold"><?php echo number_format($tour['price']); ?> đ</td>
                                        <td><span class="badge bg-success fs-6"><?php echo $tour['available_seats']; ?></span></td>
                                        
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary" title="Sửa"><i class="bi bi-pencil-square"></i></a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" title="Xóa"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Kho hiện tại đang trống!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>