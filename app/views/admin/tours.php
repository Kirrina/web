<!doctype html>
<html class="no-js" lang="vi">
<head>
    <meta charset="utf-8">
    <title>Quản Lý Tour - CloudJourney Admin</title>
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
        .avatar-circle { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #6366f1); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; flex-shrink: 0; }
        .tour-img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
        
        /* Chỉnh style cho Modal */
        .modal-content { border-radius: 15px; border: none; }
        .modal-header { background: #f8f9fc; border-radius: 15px 15px 0 0; border-bottom: 1px solid #e2e8f0; }
        .form-control { border-radius: 8px; border: 1px solid #e2e8f0; }
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
                            <li>
                                <a href="/Project/public/index.php?url=admin/index"><i class="ti-dashboard"></i><span>Tổng quan</span></a>
                            </li>
                            <li class="active">
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
                            <h4 class="page-title pull-left font-weight-bold" style="color:#2c3136 !important;">Quản lý tours</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end align-items-center">
                        
                        <!-- DROP DOWN MENU AVATAR (ALPINE.JS) -->
                        <div x-data="{ open: false }" class="pull-right position-relative" style="margin-top: 5px;">
                            <button @click="open = !open" @click.outside="open = false" style="background:none; border:none; outline:none; cursor:pointer;" class="d-flex align-items-center">
                                <div class="avatar-circle" >
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
                                <!-- Thanh công cụ -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="header-title mb-0">Tất cả Tour</h4>
                                    <!-- NÚT GỌI MODAL THÊM MỚI -->
                                    <button class="btn btn-primary rounded-pill px-4" onclick="openModal()">
                                        <i class="ti-plus mr-2"></i> Thêm Tour
                                    </button>
                                </div>

                                <!-- Bảng danh sách (Thêm table-striped để chia màu chẵn/lẻ) -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-center align-middle">
                                        <thead class="bg-light">
                                            <tr class="text-uppercase text-muted" style="font-size: 13px;">
                                                <th>Ảnh</th>
                                                <th class="text-left">Tên Tour</th>
                                                <th>Giá bán</th>
                                                <th>Giảm giá</th>
                                                <th>Ngày đi</th>
                                                <th>Chỗ</th>
                                                <th>Trạng thái</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data['tours'] as $tour): ?>
                                            <tr>
                                                <td><img src="/Project/public/images/tours/<?= htmlspecialchars($tour['image']) ?>" class="tour-img shadow-sm" onerror="this.src='/Project/public/images/default-tour.jpg'"></td>
                                                <td class="text-left font-weight-bold text-dark"><?= htmlspecialchars($tour['name']) ?></td>
                                                <td class="text-primary font-weight-bold"><?= number_format($tour['price']) ?>đ</td>
                                                <td class="text-success font-weight-bold"><?= number_format($tour['discount']) ?>đ</td>
                                                <td><?= date('d/m/Y', strtotime($tour['departure_date'])) ?></td>
                                                <td class="font-weight-bold"><?= $tour['available_seats'] ?></td>
                                                
                                                <!-- Sửa màu trạng thái cho nổi bật -->
                                                <td>
                                                    <?php if($tour['status'] == 'active'): ?>
                                                        <span class="text-success font-weight-bold">
                                                            <i class="fa fa-circle mr-1" style="font-size: 8px; vertical-align: middle;"></i> Mở bán
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-secondary font-weight-bold">
                                                            <i class="fa fa-circle mr-1" style="font-size: 8px; vertical-align: middle;"></i> Đã ẩn
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                
                                                <td>
                                                    <!-- ĐÃ SỬA LỖI MODAL BẰNG htmlspecialchars -->
                                                    <button class="btn btn-sm btn-info rounded-circle mx-1 shadow-sm" 
                                                            onclick="openModal(<?= htmlspecialchars(json_encode($tour), ENT_QUOTES, 'UTF-8') ?>)" 
                                                            title="Sửa">
                                                        <i class="ti-pencil"></i>
                                                    </button>
                                                    <a href="/Project/public/index.php?url=admin/deleteTour/<?= $tour['id'] ?>" 
                                                       class="btn btn-sm btn-danger rounded-circle shadow-sm" 
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa tour này?');">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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

    <!-- ============================================== -->
    <!-- MODAL THÊM / SỬA TOUR (BOOTSTRAP MODAL) -->
    <!-- ============================================== -->
    <div class="modal fade" id="tourModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/Project/public/index.php?url=admin/saveTour" method="POST" enctype="multipart/form-data" id="tourForm">
                    
                    <!-- Input Ẩn lưu ID Tour (Dùng cho Update) -->
                    <input type="hidden" name="tour_id" id="modal_tour_id">
                    <input type="hidden" name="old_image" id="modal_old_image">

                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-dark" id="modalTitle">Thêm Tour Mới</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label class="font-weight-bold">Tên chuyến đi <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="modal_name" class="form-control" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" id="modal_category" class="form-control" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach($data['categories'] as $cat): ?>
                                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Giá bán <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="modal_price" class="form-control" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Giảm giá</label>
                                <input type="number" name="discount" id="modal_discount" class="form-control" value="0">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Chỗ trống <span class="text-danger">*</span></label>
                                <input type="number" name="available_seats" id="modal_seats" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Ngày khởi hành <span class="text-danger">*</span></label>
                                <input type="date" name="departure_date" id="modal_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Thời gian (VD: 3 Ngày 2 Đêm) <span class="text-danger">*</span></label>
                                <input type="text" name="duration" id="modal_duration" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Hình ảnh (Để trống nếu không muốn đổi ảnh)</label>
                            <input type="file" name="image" id="modal_image" class="form-control-file" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="ti-save mr-1"></i> Lưu Dữ Liệu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/Project/public/admin_assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="/Project/public/admin_assets/js/popper.min.js"></script>
    <script src="/Project/public/admin_assets/js/bootstrap.min.js"></script>
    <script src="/Project/public/admin_assets/js/metisMenu.min.js"></script>
    <script src="/Project/public/admin_assets/js/scripts.js"></script>

    <!-- SCRIPT ĐIỀU KHIỂN MODAL -->
    <script>
        function openModal(tourData = null) {
            let form = $('#tourForm')[0];
            
            if (tourData) {
                // TRẠNG THÁI: SỬA TOUR
                $('#modalTitle').text('Cập Nhật Chuyến Đi');
                $('#modal_tour_id').val(tourData.id);
                $('#modal_old_image').val(tourData.image);
                
                // Đổ dữ liệu vào các ô input
                $('#modal_name').val(tourData.name);
                $('#modal_category').val(tourData.category_id);
                $('#modal_price').val(tourData.price);
                $('#modal_discount').val(tourData.discount);
                $('#modal_seats').val(tourData.available_seats);
                $('#modal_date').val(tourData.departure_date);
                $('#modal_duration').val(tourData.duration);
                
                // Khi sửa, không bắt buộc chọn ảnh mới
                $('#modal_image').removeAttr('required');
            } else {
                // TRẠNG THÁI: THÊM TOUR MỚI
                $('#modalTitle').text('Thêm Tour Mới');
                form.reset(); // Xóa sạch form
                $('#modal_tour_id').val('');
                $('#modal_old_image').val('');
                
                // Khi thêm mới, BẮT BUỘC phải up ảnh
                $('#modal_image').attr('required', 'required');
            }
            
            // Mở Modal
            $('#tourModal').modal('show');
        }
    </script>
</body>
</html>