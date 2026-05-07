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
        .tour-img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; }
        
        /* Style Modal */
        .modal-content { border-radius: 15px; border: none; }
        .modal-header { background: #f8f9fc; border-radius: 15px 15px 0 0; border-bottom: 1px solid #e2e8f0; }
        .form-control { border-radius: 8px; border: 1px solid #e2e8f0; }
        
        .avatar-circle {
            width: 40px; height: 40px; border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #6366f1);
            color: white; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 16px; 
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            flex-shrink: 0; 
            margin-right:10px;
        }
    </style>
</head>

<body>

    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        
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
                            <li><a href="/Project/public/index.php?url=admin/index"><i class="ti-dashboard"></i><span>Tổng quan</span></a></li>
                            <li><a href="/Project/public/index.php?url=admin/users"><i class="ti-user"></i><span>Quản lý User</span></a></li>
                            <li class="active"><a href="/Project/public/index.php?url=admin/tours"><i class="ti-package"></i><span>Quản lý Tour</span></a></li>
                            <li><a href="/Project/public/index.php?url=admin/bookings"><i class="ti-shopping-cart-full"></i><span>Quản lý Đơn hàng</span></a></li>
                            <li><a href="/Project/public/index.php" target="_blank"><i class="ti-home"></i><span>Xem Website</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left"><span></span><span></span><span></span></div>
                    </div>
                </div>
            </div>
            
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left font-weight-bold" style="color:#2c3136 !important;">Quản lý tours</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end align-items-center">
                        <div x-data="{ open: false }" class="pull-right position-relative" style="margin-top: 5px;">
                            <button @click="open = !open" @click.outside="open = false" style="background:none; border:none; outline:none; cursor:pointer;" class="d-flex align-items-center">
                                <div class="avatar-circle" >
                                    <?= mb_substr(htmlspecialchars($_SESSION['user_fullname'] ?? 'Admin'), 0, 1, "UTF-8") ?>
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
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="header-title mb-0">Tất cả Tour</h4>
                                    <button type="button" class="btn btn-outline-primary rounded-pill px-4 mr-2" onclick="openCategoryModal()">
                                        <i class="ti-layers mr-2"></i> Thêm Danh Mục
                                    </button>
                                    <button type="button" class="btn btn-primary rounded-pill px-4" onclick="openModal()">
                                        <i class="ti-plus mr-2"></i> Thêm Tour
                                    </button>
                                </div>

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
                                            <?php if(!empty($data['tours'])): ?>
                                                <?php foreach($data['tours'] as $tour): ?>
                                                <tr>
                                                    <td><img src="/Project/public/images/tours/<?= htmlspecialchars($tour['image'] ?? '') ?>" class="tour-img shadow-sm" onerror="this.src='/Project/public/images/default-tour.jpg'"></td>
                                                    <td class="text-left font-weight-bold text-dark"><?= htmlspecialchars($tour['name']) ?></td>
                                                    <td class="text-primary font-weight-bold"><?= number_format($tour['price']) ?>đ</td>
                                                    <td class="text-success font-weight-bold"><?= number_format($tour['discount'] ?? 0) ?>đ</td>
                                                    <td><?= date('d/m/Y', strtotime($tour['departure_date'])) ?></td>
                                                    <td class="font-weight-bold"><?= $tour['available_seats'] ?></td>
                                                    
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
                                                        <button type="button" class="btn btn-sm btn-info rounded-circle mx-1 shadow-sm" 
                                                                data-id="<?= htmlspecialchars($tour['id']) ?>"
                                                                data-name="<?= htmlspecialchars($tour['name'], ENT_QUOTES, 'UTF-8') ?>"
                                                                data-category="<?= htmlspecialchars($tour['category_id']) ?>"
                                                                data-price="<?= htmlspecialchars($tour['price']) ?>"
                                                                data-discount="<?= htmlspecialchars($tour['discount'] ?? 0) ?>"
                                                                data-seats="<?= htmlspecialchars($tour['available_seats']) ?>"
                                                                data-date="<?= htmlspecialchars($tour['departure_date']) ?>"
                                                                data-duration="<?= htmlspecialchars($tour['duration'], ENT_QUOTES, 'UTF-8') ?>"
                                                                data-image="<?= htmlspecialchars($tour['image'] ?? '', ENT_QUOTES, 'UTF-8') ?>"

                                                                data-status="<?= htmlspecialchars($tour['status']) ?>"
                                                                data-description="<?= htmlspecialchars($tour['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                                data-itinerary="<?= htmlspecialchars($tour['itinerary'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                                data-gallery="<?= htmlspecialchars($tour['gallery'] ?? '[]', ENT_QUOTES, 'UTF-8') ?>"
                                                                
                                                                onclick="openModal(this)" title="Sửa">
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

    <div class="modal fade" id="tourModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="/Project/public/index.php?url=admin/saveTour" method="POST" enctype="multipart/form-data" id="tourForm">
                    
                    <input type="hidden" name="tour_id" id="modal_tour_id">
                    <input type="hidden" name="old_image" id="modal_old_image">
                    <input type="hidden" name="old_gallery" id="modal_old_gallery">

                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold text-dark" id="modalTitle">Thêm Tour Mới</h5>
                        <button type="button" class="close position-absolute" style="right: 20px; top: 15px;" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <ul class="nav nav-tabs mb-4" id="tourTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active font-weight-bold" data-toggle="tab" href="#basicInfo">Cơ bản</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" data-toggle="tab" href="#detailsInfo">Mô tả & Lịch trình</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link font-weight-bold" data-toggle="tab" href="#galleryInfo">Thư viện ảnh</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            
                            <div class="tab-pane fade show active" id="basicInfo">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                        <label class="font-weight-bold">Tên chuyến đi <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="modal_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Danh mục <span class="text-danger">*</span></label>
                                        <select name="category_id" id="modal_category" class="form-control" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php if(!empty($data['categories'])): ?>
                                                <?php foreach($data['categories'] as $cat): ?>
                                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
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
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Ngày khởi hành <span class="text-danger">*</span></label>
                                        <input type="date" name="departure_date" id="modal_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Thời gian <span class="text-danger">*</span></label>
                                        <input type="text" name="duration" id="modal_duration" class="form-control" placeholder="VD: 3 Ngày 2 Đêm" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold">Trạng thái</label>
                                        <select name="status" id="modal_status" class="form-control">
                                            <option value="active">Đang mở bán</option>
                                            <option value="hidden">Đã ẩn (Ngừng bán)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-primary">Ảnh đại diện chính</label>
                                    <input type="file" name="image" id="modal_image" class="form-control-file" accept="image/*">
                                </div>
                            </div>

                            <div class="tab-pane fade" id="detailsInfo">
                                <div class="form-group">
                                    <label class="font-weight-bold">Mô tả tổng quan</label>
                                    <textarea name="description" id="modal_description" class="form-control" rows="4" placeholder="Nhập đoạn văn giới thiệu ngắn về chuyến đi..."></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold">Lịch trình chi tiết (Dữ liệu JSON) <span class="text-danger">* Cẩn thận khi sửa</span></label>
                                    <textarea name="itinerary" id="modal_itinerary" class="form-control" rows="8" style="font-family: monospace;" placeholder='[{"title":"Ngày 1", "description":"...", "activities": { "08:00": "..."}}]'></textarea>
                                    <small class="text-muted">Cấu trúc lịch trình được mã hóa bằng JSON. Chỉ chỉnh sửa Text bên trong ngoặc kép.</small>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="galleryInfo">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Thêm ảnh mới vào thư viện</label>
                                    <input type="file" name="new_gallery[]" class="form-control-file" accept="image/*" multiple>
                                    <small class="text-muted d-block mt-1">Bạn có thể chọn nhiều ảnh cùng lúc (Giữ Ctrl hoặc kéo thả chuột).</small>
                                </div>
                                
                                <hr>
                                <label class="font-weight-bold">Ảnh đang có (Tick chọn vào ảnh để XÓA)</label>
                                <div id="gallery_preview" class="d-flex flex-wrap" style="gap: 15px;">
                                    </div>
                            </div>

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

    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
                <div class="modal-header bg-light position-relative">
                    <h5 class="modal-title font-weight-bold text-dark">Quản Lý Danh Mục</h5>
                    <button type="button" class="close position-absolute" style="right: 20px; top: 15px;" data-dismiss="modal"><span>&times;</span></button>
                </div>
                
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-5 border-right">
                            <h6 class="font-weight-bold text-primary mb-3" id="catFormTitle">Thêm Danh Mục Mới</h6>
                            <form action="/Project/public/index.php?url=admin/saveCategory" method="POST" id="categoryForm">
                                <input type="hidden" name="cat_id" id="modal_cat_id">
                                
                                <div class="form-group">
                                    <label class="font-weight-bold">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" name="cat_name" id="modal_cat_name" class="form-control" placeholder="VD: Tour Mùa Hè" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Mô tả ngắn</label>
                                    <textarea name="cat_description" id="modal_cat_desc" class="form-control" rows="3" placeholder="Ghi chú về danh mục này..."></textarea>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4"><i class="ti-save mr-1"></i> Lưu lại</button>
                                    <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3 ml-1" onclick="resetCatForm()"><i class="ti-reload"></i> Hủy</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-7">
                            <h6 class="font-weight-bold text-dark mb-3">Danh sách hiện tại</h6>
                            <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-bordered table-hover text-center text-sm align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>STT</th>
                                            <th class="text-left">Tên danh mục</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($data['categories'])): ?>
                                            <?php $stt = 1; // Khởi tạo biến đếm thứ tự ?>
                                            <?php foreach($data['categories'] as $cat): ?>
                                            <tr>
                                                <td class="font-weight-bold text-secondary"><?= $stt++ ?></td>
                                                
                                                <td class="text-left font-weight-bold text-dark"><?= htmlspecialchars($cat['name']) ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info rounded-circle px-2"
                                                        onclick="editCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars($cat['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>')" title="Sửa">
                                                        <i class="ti-pencil"></i>
                                                    </button>
                                                    
                                                    <a href="/Project/public/index.php?url=admin/deleteCategory/<?= $cat['id'] ?>" class="btn btn-sm btn-danger rounded-circle px-2" 
                                                       onclick="return confirm('CẢNH BÁO NGUY HIỂM: Xóa danh mục này sẽ XÓA TOÀN BỘ các Tour đang có bên trong nó! Bạn chắc chắn muốn xóa chứ?');" title="Xóa">
                                                        <i class="ti-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="3" class="text-muted">Chưa có danh mục nào</td></tr>
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

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="/Project/public/admin_assets/js/metisMenu.min.js"></script>
    <script src="/Project/public/admin_assets/js/jquery.slimscroll.min.js"></script>
    <script src="/Project/public/admin_assets/js/scripts.js"></script>

    <script>
        window.openModal = function(btnElement = null) {
            let form = $('#tourForm')[0];
            
            // Reset tab về tab đầu tiên (Cơ bản) mỗi khi mở Modal
            $('#tourTabs a[href="#basicInfo"]').tab('show');
            $('#gallery_preview').html(''); // Xóa preview ảnh cũ
            
            if (btnElement) {
                let $btn = $(btnElement);
                $('#modalTitle').text('Cập Nhật Chuyến Đi');
                $('#modal_tour_id').val($btn.attr('data-id'));
                $('#modal_old_image').val($btn.attr('data-image'));
                
                // Tab 1: Cơ bản
                $('#modal_name').val($btn.attr('data-name'));
                $('#modal_category').val($btn.attr('data-category'));
                $('#modal_price').val($btn.attr('data-price'));
                $('#modal_discount').val($btn.attr('data-discount'));
                $('#modal_seats').val($btn.attr('data-seats'));
                $('#modal_date').val($btn.attr('data-date'));
                $('#modal_duration').val($btn.attr('data-duration'));
                $('#modal_status').val($btn.attr('data-status') || 'active');
                
                // Tab 2: Mô tả & Lịch trình
                $('#modal_description').val($btn.attr('data-description'));
                $('#modal_itinerary').val($btn.attr('data-itinerary'));
                
                // Tab 3: Xử lý hiển thị Gallery
                let galleryStr = $btn.attr('data-gallery');
                $('#modal_old_gallery').val(galleryStr);
                
                try {
                    let galleryArr = JSON.parse(galleryStr || '[]');
                    let galleryHtml = '';
                    if(galleryArr.length > 0) {
                        galleryArr.forEach(img => {
                            galleryHtml += `
                                <div class="position-relative border rounded p-1 shadow-sm" style="width: 100px; height: 100px;">
                                    <img src="/Project/public/images/tours/${img}" class="w-100 h-100 rounded" style="object-fit:cover;">
                                    <div class="position-absolute" style="top: -8px; right: -8px;">
                                        <input type="checkbox" name="delete_gallery[]" value="${img}" style="transform: scale(1.5); cursor: pointer;" title="Đánh dấu để xóa ảnh này">
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        galleryHtml = '<span class="text-muted text-sm italic">Chưa có ảnh nào trong thư viện.</span>';
                    }
                    $('#gallery_preview').html(galleryHtml);
                } catch (e) { 
                    console.error("Lỗi parse JSON Gallery: ", e); 
                }

                $('#modal_image').removeAttr('required'); // Sửa thì không bắt ép up ảnh chính
            } else {
                // TRẠNG THÁI: THÊM MỚI
                $('#modalTitle').text('Thêm Tour Mới');
                form.reset(); 
                $('#modal_tour_id').val('');
                $('#modal_old_image').val('');
                $('#modal_old_gallery').val('[]');
                $('#modal_status').val('active'); // Mặc định mở bán
                $('#modal_image').attr('required', 'required'); // Thêm mới bắt buộc up ảnh chính
            }
            
            // Hiện Modal (chống bấm nhầm ra ngoài làm tắt Modal)
            $('#tourModal').modal({ backdrop: 'static', show: true });
        };

        // ===== SCRIPTS QUẢN LÝ DANH MỤC =====
    
        // Mở Modal Danh mục
        window.openCategoryModal = function() {
            resetCatForm(); // Xóa trắng form mỗi khi mở
            $('#categoryModal').modal({ backdrop: 'static', show: true });
        };

        // Bấm nút Sửa danh mục (Đổ dữ liệu từ Bảng sang Form)
        window.editCategory = function(id, name, desc) {
            $('#catFormTitle').text('Cập Nhật Danh Mục').removeClass('text-primary').addClass('text-warning');
            $('#modal_cat_id').val(id);
            $('#modal_cat_name').val(name);
            $('#modal_cat_desc').val(desc);
        };

        // Nút Hủy (Reset form về trạng thái Thêm Mới)
        window.resetCatForm = function() {
            $('#catFormTitle').text('Thêm Danh Mục Mới').removeClass('text-warning').addClass('text-primary');
            $('#categoryForm')[0].reset();
            $('#modal_cat_id').val('');
        };
    </script>

    <script>
        // 1. Ngay trước khi trang bị tải lại (do bấm Submit form hoặc bấm thẻ <a> Xóa)
        window.addEventListener('beforeunload', function() {
            // Lưu tọa độ Y của thanh cuộn vào bộ nhớ SessionStorage
            sessionStorage.setItem('admin_tours_scroll_pos', window.scrollY);
        });

        // 2. Ngay khi trang vừa load lại xong
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy lại tọa độ cũ
            let scrollPos = sessionStorage.getItem('admin_tours_scroll_pos');
            if (scrollPos) {
                // Trình duyệt tự động nhảy xuống đúng tọa độ đó ngay lập tức
                window.scrollTo({
                    top: parseInt(scrollPos),
                    behavior: 'instant' // Dùng 'instant' để chớp mắt là xuống, không bị hiệu ứng trượt chậm
                });
                // Xóa mốc đi để nếu lần sau bạn bấm từ trang chủ vào thì nó vẫn ở trên cùng
                sessionStorage.removeItem('admin_tours_scroll_pos');
            }
        });
    </script>
</body>
</html>