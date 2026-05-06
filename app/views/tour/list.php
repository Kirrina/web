<!-- Tệp: app/views/tour/list.php -->
<?php require_once '../app/views/inc/header.php'; ?>

<!-- Nhúng Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<?php 
    // Đọc thông tin liên hệ từ file JSON (nếu không có file thì dùng số mặc định)
    $sitePhone = '1900 1234';
    $siteEmail = 'support@travel.com';
    $jsonFile = '../app/contact.json';
    
    if (file_exists($jsonFile)) {
        $contactData = json_decode(file_get_contents($jsonFile), true);
        if ($contactData) {
            $sitePhone = $contactData['phone'] ?? $sitePhone;
            $siteEmail = $contactData['email'] ?? $siteEmail;
        }
    }
?>

<!-- Breadcrumb & Tiêu đề -->
<div class="bg-[#f8f9fa] pt-6 pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-sm text-gray-500 mb-4">
            <a href="index.php?controller=home" class="hover:text-blue-700">Trang chủ</a>
            <span class="mx-2">›</span>
            <span class="text-gray-900">Kết quả tìm kiếm</span>
        </nav>

        <?php 
            // Nếu có từ khóa thì in ra, không thì in "tất cả hành trình"
            $displayKeyword = (!empty($keyword) && !empty($tours)) ? $tours[0]['category_name'] : "tất cả hành trình";
        ?>
        <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Khám phá <?= htmlspecialchars($displayKeyword) ?></h1>
        <p class="text-gray-600">Tìm thấy <?= $totalTours ?> trải nghiệm tuyệt vời dành riêng cho bạn.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- BỘ LỌC (Chiếm 1/4) -->
        <aside class="w-full lg:w-1/4 flex-shrink-0">
           <form action="/Project/public/index.php?url=tour/index" method="POST" id="filterForm" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <input type="hidden" name="sort" value="<?= isset($_REQUEST['sort']) ? htmlspecialchars($_REQUEST['sort']) : 'popular' ?>">
                
                <?php if(!empty($keyword)): ?>
                    <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
                <?php endif; ?>

                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg text-gray-900">Bộ lọc</h3>
                    <!-- Nút Xóa tất cả: Chỉ giữ lại keyword, bỏ hết các biến lọc -->
                    <a href="/Project/public/index.php?url=tour/index<?= !empty($keyword) ? '&keyword='.urlencode($keyword) : '' ?>" class="text-sm text-blue-600 hover:underline">Xóa tất cả</a>
                </div>

                <!-- 0. Lọc Số lượng người -->
                <div class="mb-6 border-b border-gray-100 pb-6">
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Số người</h4>
                    <?php $currentPeople = isset($_POST['people']) ? $_POST['people'] : ''; ?>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user-friends text-gray-400"></i>
                        </div>
                        <input type="number" name="people" min="1" max="50" value="<?= htmlspecialchars($currentPeople) ?>" 
                               class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5 outline-none transition-colors" 
                               placeholder="VD: 2" 
                               onchange="this.form.submit()">
                    </div>
                </div>

                <!-- Lọc Ngày khởi hành -->
                <div class="mb-6 border-b border-gray-100 pb-6">
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Ngày khởi hành</h4>
                    <?php $currentDate = isset($_POST['departure_date']) ? $_POST['departure_date'] : ''; ?>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="far fa-calendar-alt text-gray-400"></i>
                        </div>
                        <input type="date" name="departure_date" value="<?= htmlspecialchars($currentDate) ?>" 
                            class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 p-2.5 outline-none transition-colors" 
                            onchange="this.form.submit()">
                    </div>
                    <?php if(!empty($currentDate)): ?>
                        <p class="text-[10px] text-blue-600 mt-2 italic">* Đang tìm các tour khởi hành từ <?= date('d/m', strtotime($currentDate . ' -3 days')) ?> đến <?= date('d/m', strtotime($currentDate . ' +3 days')) ?></p>
                    <?php endif; ?>
                </div>

                <!-- 1. Lọc Khoảng giá (Kéo Slider) -->
                <div class="mb-6 border-b border-gray-100 pb-6">
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Khoảng giá (VND)</h4>
                    <?php $currentPrice = isset($_POST['max_price']) ? $_POST['max_price'] : 20000000; ?>
                    
                    <input type="range" name="max_price" min="500000" max="20000000" step="500000" value="<?= htmlspecialchars($currentPrice) ?>" 
                           class="w-full accent-blue-700 cursor-pointer" 
                           oninput="document.getElementById('priceLabel').innerText = new Intl.NumberFormat('vi-VN').format(this.value) + 'đ'"
                           onchange="this.form.submit()">
                    
                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                        <span>500.000đ</span>
                        <span id="priceLabel" class="font-bold text-gray-700"><?= number_format($currentPrice, 0, ',', '.') ?>đ</span>
                    </div>
                </div>

                <!-- 2. Lọc Đánh giá (Checkbox) -->
                <div class="mb-6 border-b border-gray-100 pb-6">
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Đánh giá</h4>
                    <?php $currentRatings = isset($_POST['rating']) ? (array)$_POST['rating'] : []; ?>
                    
                    <!-- 5 Sao -->
                    <label class="flex items-center space-x-3 mb-3 cursor-pointer">
                        <input type="checkbox" name="rating[]" value="5" onchange="this.form.submit()"
                               class="form-checkbox text-blue-700 rounded h-4 w-4 border-gray-300 focus:ring-blue-500"
                               <?= in_array('5', $currentRatings) ? 'checked' : '' ?>>
                        <span class="text-sm text-gray-600 flex items-center text-yellow-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <span class="text-gray-600 ml-2">5 sao</span>
                        </span>
                    </label>
                    
                    <!-- Từ 4 Sao -->
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="rating[]" value="4" onchange="this.form.submit()"
                               class="form-checkbox text-blue-700 rounded h-4 w-4 border-gray-300 focus:ring-blue-500"
                               <?= in_array('4', $currentRatings) ? 'checked' : '' ?>>
                        <span class="text-sm text-gray-600 flex items-center text-yellow-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            <span class="text-gray-600 ml-2">từ 4 sao</span>
                        </span>
                    </label>

                    <!-- Dưới 4 Sao -->
                    <label class="flex items-center space-x-3 cursor-pointer mt-3">
                        <input type="checkbox" name="rating[]" value="under_4" onchange="this.form.submit()"
                            class="form-checkbox text-blue-700 rounded h-4 w-4 border-gray-300 focus:ring-blue-500"
                            <?= in_array('under_4', $currentRatings) ? 'checked' : '' ?>>
                        <span class="text-sm text-gray-600 flex items-center text-yellow-400">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                            <span class="text-gray-600 ml-2">dưới 4 sao</span>
                        </span>
                    </label>
                </div>

                <!-- 3. Lọc Thời lượng (Radio buttons ẩn thiết kế dạng Pill) -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Thời lượng</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php $currentDuration = isset($_POST['duration']) ? $_POST['duration'] : ''; ?>
                        
                        <!-- Trong ngày -->
                        <label class="cursor-pointer">
                            <input type="radio" name="duration" value="1" class="peer hidden" onchange="this.form.submit()" <?= $currentDuration == '1' ? 'checked' : '' ?>>
                            <span class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-full peer-checked:bg-blue-900 peer-checked:text-white transition-colors block border border-transparent peer-checked:border-blue-900 hover:bg-gray-200">Trong ngày</span>
                        </label>

                        <!-- 2-3 Ngày -->
                        <label class="cursor-pointer">
                            <input type="radio" name="duration" value="2-3" class="peer hidden" onchange="this.form.submit()" <?= $currentDuration == '2-3' ? 'checked' : '' ?>>
                            <span class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-full peer-checked:bg-blue-900 peer-checked:text-white transition-colors block border border-transparent peer-checked:border-blue-900 hover:bg-gray-200">2-3 Ngày</span>
                        </label>

                        <!-- 4-7 Ngày -->
                        <label class="cursor-pointer">
                            <input type="radio" name="duration" value="4-7" class="peer hidden" onchange="this.form.submit()" <?= $currentDuration == '4-7' ? 'checked' : '' ?>>
                            <span class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-full peer-checked:bg-blue-900 peer-checked:text-white transition-colors block border border-transparent peer-checked:border-blue-900 hover:bg-gray-200">4-7 Ngày</span>
                        </label>

                        <!-- > 7 Ngày -->
                        <label class="cursor-pointer">
                            <input type="radio" name="duration" value="over_7" class="peer hidden" onchange="this.form.submit()" <?= $currentDuration == 'over_7' ? 'checked' : '' ?>>
                            <span class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-full peer-checked:bg-blue-900 peer-checked:text-white transition-colors block border border-transparent peer-checked:border-blue-900 hover:bg-gray-200">> 7 Ngày</span>
                        </label>
                    </div>
                </div>
            </form>
        </aside>

        <!-- MAIN CONTENT: DANH SÁCH TOUR (Chiếm 3/4) -->
        <main class="w-full lg:w-3/4">
            
            <!-- Tags & Sort -->
            <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
                <div class="flex flex-wrap gap-2">
                    
                    <!-- Tag Từ khóa -->
                    <?php if(!empty($keyword)): ?>
                    <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm flex items-center border border-blue-100">
                        Từ khóa: <?= htmlspecialchars($keyword) ?> 
                        <a href="/Project/public/index.php?url=tour/index" class="ml-2 hover:text-red-500"><i class="fas fa-times cursor-pointer"></i></a>
                    </span>
                    <?php endif; ?>

                    <!-- Tag Ngày khởi hành -->
                    <?php if(!empty($_POST['departure_date'])): ?>
                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs flex items-center border border-blue-200 shadow-sm">
                            <i class="far fa-calendar-alt mr-1"></i>
                            Ngày: <?= date('d/m/Y', strtotime($_POST['departure_date'])) ?> (±3 ngày)
                        </span>
                    <?php endif; ?>

                    <!-- Tag Số người -->
                    <?php if(!empty($_POST['people'])): ?>
                        <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs flex items-center border border-purple-200 shadow-sm">
                            <i class="fas fa-user-friends mr-1"></i>
                            ≥ <?= htmlspecialchars($_POST['people']) ?> Người
                        </span>
                    <?php endif; ?>
                    
                    <!-- Tag Khoảng giá -->
                    <?php if(isset($_POST['max_price']) && (int)$_POST['max_price'] < 20000000): ?>
                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs flex items-center border border-gray-200 shadow-sm">
                            Giá < <?= number_format((int)$_POST['max_price'], 0, ',', '.') ?>đ
                        </span>
                    <?php endif; ?>

                    <!-- Tag Thời lượng -->
                    <?php if(!empty($_POST['duration'])): ?>
                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs flex items-center border border-green-200 shadow-sm">
                            <i class="far fa-clock mr-1"></i>
                            <?php 
                                if($_POST['duration'] == '1') echo 'Trong ngày';
                                elseif($_POST['duration'] == '2-3') echo '2-3 Ngày';
                                elseif($_POST['duration'] == '4-7') echo '4-7 Ngày';
                                elseif($_POST['duration'] == 'over_7') echo '> 7 Ngày';
                            ?>
                        </span>
                    <?php endif; ?>

                    <!-- Tag Đánh giá (Sao) -->
                    <?php if(!empty($_POST['rating']) && is_array($_POST['rating'])): ?>
                        <?php foreach($_POST['rating'] as $r): ?>
                            <span class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs flex items-center border border-yellow-200 shadow-sm">
                                <i class="fas fa-star mr-1"></i>
                                <?php 
                                    if ($r == '5') echo '5 Sao';
                                    elseif ($r == '4') echo 'Từ 4 Sao';
                                    elseif ($r == 'under_4') echo 'Dưới 4 Sao';
                                ?>
                            </span>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
                
                <div class="flex items-center text-sm text-gray-500">
                    Sắp xếp theo: 
                    <!-- Form con để sắp xếp, auto-submit khi đổi -->
                    <form action="/Project/public/index.php?url=tour/index" method="POST" class="inline">

                         <?php if(!empty($keyword)): ?><input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>"><?php endif; ?>
                         <?php if(isset($_POST['max_price'])): ?><input type="hidden" name="max_price" value="<?= htmlspecialchars($_POST['max_price']) ?>"><?php endif; ?>
                         <?php if(isset($_POST['duration'])): ?><input type="hidden" name="duration" value="<?= htmlspecialchars($_POST['duration']) ?>"><?php endif; ?>
                         <?php if(!empty($_POST['people'])): ?><input type="hidden" name="people" value="<?= htmlspecialchars($_POST['people']) ?>"><?php endif; ?>
                         <?php if(!empty($_POST['departure_date'])): ?><input type="hidden" name="departure_date" value="<?= htmlspecialchars($_POST['departure_date']) ?>"><?php endif; ?>
                         
                         <?php 
                            $currentRatings = isset($_POST['rating']) ? (array)$_POST['rating'] : [];
                            foreach($currentRatings as $r) {
                                echo '<input type="hidden" name="rating[]" value="'.htmlspecialchars($r).'">';
                            }
                         ?>
                        <?php $currentSort = isset($_POST['sort']) ? $_POST['sort'] : 'popular'; ?>
                        <select name="sort" onchange="this.form.submit()" class="ml-2 bg-white border border-gray-200 text-gray-800 font-medium rounded-lg px-3 py-1.5 focus:outline-none cursor-pointer">
                            <option value="popular" <?= $currentSort == 'popular' ? 'selected' : '' ?>>Phổ biến nhất</option>
                            <option value="price_asc" <?= $currentSort == 'price_asc' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                            <option value="price_desc" <?= $currentSort == 'price_desc' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- List Tours -->
            <div class="space-y-6">
                <?php if (empty($tours)): ?>
                    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-bold text-gray-700">Không tìm thấy trải nghiệm nào</h3>
                        <p class="text-gray-500">Thử thay đổi từ khóa hoặc bộ lọc của bạn.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($tours as $tour): ?>
                        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                            
                            <!-- Ảnh Tour -->
                            <div class="md:w-5/12 h-56 md:h-auto relative overflow-hidden">
                                <?php 
                                    $imageSrc = $tour['image'];
                                    // Nếu không phải link (không bắt đầu bằng http) thì nối thêm path thư mục
                                    if (!filter_var($imageSrc, FILTER_VALIDATE_URL)) {
                                        $imageSrc = "/Project/public/images/tours/" . $imageSrc;
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($imageSrc) ?>" 
                                    alt="<?= htmlspecialchars($tour['name']) ?>" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-blue-900 px-3 py-1 text-xs font-extrabold tracking-wider uppercase rounded shadow-sm">
                                    <?= htmlspecialchars($tour['category_name']) ?>
                                </span>
                                <button class="absolute top-3 right-3 w-8 h-8 bg-white/80 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>

                            <!-- Thông tin Tour -->
                             
                            <div class="md:w-7/12 p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <!-- Tiêu đề (Link tới trang chi tiết) -->
                                        <a href="/Project/public/index.php?url=tour/detail/<?= $tour['id'] ?>" class="text-xl font-bold text-gray-900 hover:text-blue-700 transition line-clamp-2">
                                            <?= htmlspecialchars($tour['name']) ?>
                                        </a>
                                        <div class="flex items-center text-sm font-bold ml-4 shrink-0">

                                            <!-- Kiểm tra rating Null  -->
                                            <?php if (is_null($tour['rate']) || $tour['review_count'] == 0): ?>
                                                <span class="text-gray-400 text-xs italic bg-gray-50 px-2 py-1 rounded">Chưa được đánh giá</span>
                                            <?php else: ?>
                                                <i class="fas fa-star text-yellow-500 mr-1"></i>
                                                <?= number_format($tour['rate'], 1) ?>
                                                <span class="text-gray-400 font-normal ml-1 hover:underline cursor-pointer">(<?= htmlspecialchars($tour['review_count']) ?>)</span>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">
                                        <?= htmlspecialchars($tour['description']) ?>
                                    </p>
                                    <p class="text-sm font-medium text-gray-600 flex items-center">
                                        <i class="far fa-clock text-gray-400 mr-2"></i> <?= htmlspecialchars($tour['duration']) ?>
                                    </p>
                                </div>
                                
                                <div class="flex justify-between items-end mt-6 pt-4 border-t border-gray-50">
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium mb-1">Giá từ</p>
                                        <div class="flex items-baseline">
                                            <p class="text-2xl font-extrabold text-blue-700">
                                                <?= number_format($tour['price'], 0, ',', '.') ?>đ
                                            </p>
                                        </div>
                                    </div>

                                  <?php 
                                    // 1. Kiểm tra trạng thái đăng nhập
                                    $isLoggedIn = isset($_SESSION['user_id']);

                                    // 2. Lấy role và status an toàn (Nếu không tồn tại, tự động gán là chuỗi rỗng '')
                                    $userRole = $_SESSION['user_role'] ?? '';
                                    $userStatus = $_SESSION['user_status'] ?? '';

                                    $hasValidRole = ($userRole === 'admin' || $userRole === 'user');
                                    $isActive = ($userStatus === 'active');

                                    // 3. Xử lý đường dẫn
                                    if ($isLoggedIn && $hasValidRole && $isActive) {
                                        $link = "/Project/public/tour/detail/" . $tour['id']; 
                                    } else {
                                        $link = "/Project/public/user/login";
                                    }
                                ?>

                                <!-- NÚT ĐẶT NGAY -->
                                <a href="<?= $link ?>" 
                                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-orange-500/30 transition-all hover:-translate-y-0.5">
                                    Đặt ngay
                                </a>

                                <!-- NÚT SỬA DÀNH CHO ADMIN -->
                                <?php if($userRole === 'admin'): ?>
                                    <button x-data 
                                            @click="$dispatch('open-edit-tour', <?= htmlspecialchars(json_encode($tour)) ?>)" 
                                            class="bg-blue-100 text-blue-700 p-2.5 rounded-xl hover:bg-blue-200 transition shadow-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            
            <!-- Phân trang (Pagination) -->
            <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="flex justify-center mt-10">
                <nav class="flex items-center space-x-2">
                    <!-- Nút Lùi (Chỉ hiện nếu không phải trang 1) -->
                    <?php if ($page > 1): ?>
                        <button type="submit" form="filterForm" name="page" value="<?= $page - 1 ?>" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition"><i class="fas fa-chevron-left"></i></button>
                    <?php endif; ?>

                    <!-- Vòng lặp in số trang -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <button type="submit" form="filterForm" name="page" value="<?= $i ?>" 
                                class="w-10 h-10 rounded-full flex items-center justify-center transition <?= $i == $page ? 'text-white bg-blue-700 font-bold shadow-md' : 'text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 font-medium' ?>">
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>

                    <!-- Nút Tới (Chỉ hiện nếu chưa tới trang cuối) -->
                    <?php if ($page < $totalPages): ?>
                        <button type="submit" form="filterForm" name="page" value="<?= $page + 1 ?>" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition"><i class="fas fa-chevron-right"></i></button>
                    <?php endif; ?>
                </nav>
            </div>
            <?php endif; ?>

        </main>
    
    </div>

    <!-- KHỐI ĐÁNH GIÁ TIÊU BIỂU -->
    <?php if (!empty($topReviews)): ?>
    <section class="mt-16 border-t border-gray-200 pt-10 pb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Đánh giá Tours và trải nghiệm của khách hàng </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($topReviews as $review): ?>
            <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                <!-- Hiển thị Sao -->
                <div class="text-yellow-400 text-sm mb-3 flex gap-1">
                    <?php 
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $review['rating']) {
                                echo '<i class="fas fa-star"></i>';
                            } else {
                                echo '<i class="text-gray-300 fas fa-star"></i>';
                            }
                        }
                    ?>
                </div>
                
                <!-- Dòng Review cho tour nào -->
                <div class="text-sm text-gray-500 mb-3">
                    Đánh giá cho: <a href="/Project/public/index.php?url=tour/detail&id=<?= $review['tour_id'] ?>" class="text-blue-600 hover:underline font-medium"><?= htmlspecialchars($review['tour_name']) ?></a>
                </div>
                
                <!-- Tên người dùng và Ngày -->
                <div class="text-xs text-gray-400 mb-4 uppercase tracking-wide">
                    <?= htmlspecialchars($review['customer_name']) ?> <span class="mx-2">•</span> Đã đăng vào <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                </div>

                <!-- Nội dung đánh giá -->
                <p class="text-gray-700 leading-relaxed line-clamp-4">
                    "<?= htmlspecialchars($review['content']) ?>"
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- KHỐI FAQS -->
    <?php 
        $isAdmin = false;
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
            if (strtolower(trim($_SESSION['user_role'])) === 'admin') {
                $isAdmin = true;
            }
        }
    ?>

    <section class="mt-12 border-t border-gray-200 pt-12 pb-12 relative">
        
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Câu hỏi thường gặp</h2>
            
            <?php if($isAdmin): ?>
                <!-- Đã thêm x-data để Alpine nhận diện -->
                <button x-data type="button" @click="$dispatch('open-faq-modal', {})" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-xl hover:bg-blue-200 transition flex items-center gap-2 text-sm font-bold shadow-sm cursor-pointer z-10 relative">
                    <i class="fas fa-plus"></i> Thêm câu hỏi
                </button>
            <?php endif; ?>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cột trái: Accordion Câu hỏi (Dùng vòng lặp động) -->
            <div class="w-full lg:w-2/3 space-y-4">
                
                <?php if(!empty($faqs)): ?>
                    <?php foreach ($faqs as $faq): ?>
                        <details class="group bg-white border border-gray-200 rounded-xl cursor-pointer shadow-sm hover:shadow-md transition duration-200">
                            <summary class="p-5 font-semibold text-gray-800 list-none flex justify-between items-center outline-none pr-4 relative">
                                <span><?= htmlspecialchars($faq['question']) ?></span>
                                
                                <div class="flex items-center gap-2 ml-4">
                                    <?php if($isAdmin): ?>
                                        <!-- CHÚ Ý: Đã thêm x-data và @click.prevent.stop.
                                             prevent.stop giúp ấn nút sửa mà không làm sập (đóng/mở) câu hỏi -->
                                        <button x-data type="button" 
                                            @click.prevent.stop="$dispatch('open-faq-modal', <?= htmlspecialchars(json_encode([
                                                'id' => $faq['id'],
                                                'question' => $faq['question'],
                                                'answer' => $faq['answer']
                                            ])) ?>)" 
                                            class="text-gray-400 hover:text-blue-600 transition p-2 cursor-pointer relative z-10" title="Sửa câu hỏi">
                                            <i class="fas fa-pen text-sm"></i>
                                        </button>

                                        <a href="/Project/public/index.php?url=tour/deleteFaq&id=<?= $faq['id'] ?>" 
                                           onclick="event.stopPropagation(); saveScrollPos(); return confirm('Bạn có chắc chắn muốn xóa câu hỏi này không? Hành động này không thể hoàn tác!');"
                                           class="text-gray-400 hover:text-red-500 transition p-2 cursor-pointer relative z-10" title="Xóa câu hỏi">
                                            <i class="fas fa-trash text-sm"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <span class="transition-transform duration-300 group-open:rotate-180 text-blue-600 ml-2">
                                        <i class="fas fa-chevron-down"></i>
                                    </span>
                                </div>
                            </summary>
                            <div class="px-5 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-3">
                                <!-- Dùng nl2br để giữ định dạng xuống dòng nếu admin gõ Enter -->
                                <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                            </div>
                        </details>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500 italic p-4 bg-gray-50 rounded-xl border border-gray-100">Chưa có câu hỏi thường gặp nào.</p>
                <?php endif; ?>

            </div>

           
          <!-- Cột phải: Card Hỗ trợ -->
            <div class="w-full lg:w-1/3">
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center sticky top-24 shadow-sm relative">
                    
                    <?php if($isAdmin): ?>
                        <button x-data type="button" @click="$dispatch('open-contact-modal')" class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 z-10 cursor-pointer" title="Sửa liên hệ">
                            <i class="fas fa-pen text-xs"></i>
                        </button>
                    <?php endif; ?>

                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 text-blue-600 text-2xl">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bạn cần thêm hỗ trợ?</h3>
                    <p class="text-gray-600 text-sm mb-6">Đội ngũ chuyên gia du lịch của chúng tôi luôn sẵn sàng giải đáp mọi thắc mắc của bạn 24/7.</p>
                    
                    <a class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-md shadow-blue-500/30 hover:-translate-y-0.5 cursor-pointer">
                        <!-- IN RA BIẾN PHP LẤY TỪ JSON -->
                        <i class="fas fa-phone-alt mr-2"></i> Gọi Hotline: <span id="display_phone"><?= htmlspecialchars($sitePhone) ?></span>
                    </a>
                    
                    <p class="text-sm text-gray-500 mt-5">
                        Hoặc gửi email: <br>
                        <!-- IN RA BIẾN PHP LẤY TỪ JSON -->
                        <a href="mailto:<?= htmlspecialchars($siteEmail) ?>" id="display_email" class="font-bold text-gray-800 hover:text-blue-600 transition"><?= htmlspecialchars($siteEmail) ?></a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    


    <!-- KHỐI EXPLORE MORE  -->
    <?php if(!empty($suggestedKeywords)): ?>
    <section class="mt-16 border-t border-gray-200 pt-10 pb-12">
        <div class="flex items-center mb-8">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-search text-lg"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Gợi ý dành riêng cho bạn</h2>
        </div>

        <?php 
            $chunks = array_chunk($suggestedKeywords, ceil(count($suggestedKeywords) / 2));
            $group1 = $chunks[0] ?? [];
            $group2 = $chunks[1] ?? [];
        ?>

        <!-- Nhóm 1 -->
        <div class="mb-8">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Đang thịnh hành</h3>
            <div class="flex flex-wrap gap-2.5">
                <?php foreach($group1 as $kw): ?>
                <a href="/Project/public/index.php?url=tour/index&keyword=<?= urlencode($kw) ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm font-medium text-gray-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 hover:shadow-sm transition-all duration-200 max-w-xs group">
                    <i class="fas fa-fire text-gray-300 mr-2 text-xs group-hover:text-orange-500 transition-colors"></i>
                    <span class="truncate"><?= htmlspecialchars($kw) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Nhóm 2 -->
        <?php if(!empty($group2)): ?>
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Có thể bạn quan tâm</h3>
            <div class="flex flex-wrap gap-2.5">
                <?php foreach($group2 as $kw): ?>
                <a href="/Project/public/index.php?url=tour/index&keyword=<?= urlencode($kw) ?>" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-full text-sm font-medium text-gray-600 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-700 hover:shadow-sm transition-all duration-200 max-w-xs group">
                    <i class="fas fa-hashtag text-gray-300 mr-2 text-xs group-hover:text-blue-500 transition-colors"></i>
                    <span class="truncate"><?= htmlspecialchars($kw) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

</div> 

<!-- ========================================== -->
<!-- MODAL CHỈNH SỬA TOUR (SỬ DỤNG ALPINE.JS) -->
<!-- ========================================== -->
<?php if($isAdmin): ?>
<div x-data="{ 
        isOpen: false, 
        tour: {}, 
        imageType: 'link' 
     }" 
     @open-edit-tour.window="tour = $event.detail; isOpen = true; imageType = 'link'"
     x-show="isOpen"
     x-transition.opacity.duration.300ms
     style="display: none;" 
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
     
    <!-- Khối Modal (Bấm ra ngoài vùng tối sẽ tự đóng nhờ @click.away) -->
    <div @click.away="isOpen = false" 
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">
         
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa hành trình</h3>
            <!-- Đóng Modal -->
            <button type="button" @click="isOpen = false" class="text-gray-400 hover:text-red-500 transition cursor-pointer">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="/Project/public/index.php?url=tour/update" method="POST" class="p-6 space-y-4 keep-scroll" enctype="multipart/form-data">
            <!-- Tự động nạp id vào ô ẩn -->
            <input type="hidden" name="tour_id" x-model="tour.id">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Tên Tour</label>
                <!-- Dùng x-model để dữ liệu tự động điền -->
                <input type="text" name="name" x-model="tour.name" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Giá (đ)</label>
                    <input type="number" name="price" x-model="tour.price" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Thời lượng</label>
                    <input type="text" name="duration" x-model="tour.duration" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Điểm đến</label>
                <input type="text" name="departure_location" x-model="tour.departure_location" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Mô tả ngắn</label>
                <textarea name="description" x-model="tour.description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

            <!-- PHẦN CẬP NHẬT ẢNH -->
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Hình ảnh Tour</label>
                
                <div class="flex gap-4 mb-3">
                    <label class="flex items-center text-xs cursor-pointer">
                        <!-- Ràng buộc giá trị với biến imageType -->
                        <input type="radio" name="image_type" value="link" x-model="imageType" class="mr-1"> Dán Link
                    </label>
                    <label class="flex items-center text-xs cursor-pointer">
                        <input type="radio" name="image_type" value="upload" x-model="imageType" class="mr-1"> Tải tệp lên
                    </label>
                </div>

                <!-- Ẩn/Hiện bằng x-show cực gọn -->
                <div x-show="imageType === 'link'" x-transition>
                    <input type="text" name="image_link" x-model="tour.image" placeholder="https://example.com/image.jpg"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div x-show="imageType === 'upload'" x-transition style="display: none;">
                    <input type="file" name="image_file" 
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" @click="isOpen = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Hủy</button>
                <button type="submit" class="flex-1 py-3 bg-blue-700 text-white font-bold rounded-xl hover:bg-blue-800 shadow-lg shadow-blue-500/30 transition">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL THÊM / SỬA FAQ (SỬ DỤNG ALPINE.JS) -->
<!-- ========================================== -->
<div x-data="{ 
        isOpen: false, 
        faq: { id: '', question: '', answer: '' },
        isEdit: false
     }" 
     @open-faq-modal.window="
        faq.id = $event.detail.id || '';
        faq.question = $event.detail.question || '';
        faq.answer = $event.detail.answer || '';
        isEdit = faq.id !== '';
        isOpen = true;
     "
     x-show="isOpen"
     x-transition.opacity.duration.300ms
     style="display: none;"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
     
    <div @click.away="isOpen = false"
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">
         
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-900" x-text="isEdit ? 'Chỉnh Sửa Câu Hỏi' : 'Thêm Câu Hỏi Mới'"></h3>
            <button type="button" @click="isOpen = false" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="/Project/public/index.php?url=tour/saveFaq" method="POST" class="p-6 space-y-4 keep-scroll">
            <input type="hidden" name="faq_id" x-model="faq.id">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Câu hỏi</label>
                <input type="text" name="question" x-model="faq.question" required class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Câu trả lời</label>
                <textarea name="answer" x-model="faq.answer" rows="5" required class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" @click="isOpen = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Hủy</button>
                <button type="submit" class="flex-1 py-3 bg-blue-700 text-white font-bold rounded-xl hover:bg-blue-800 shadow-lg shadow-blue-500/30 transition">Lưu câu hỏi</button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- MODAL LIÊN HỆ (LƯU FILE JSON) -->
<!-- ========================================== -->
<div x-data="{ 
        isOpen: false, 
        contact: { hotline: '', email: '' } 
     }" 
     @open-contact-modal.window="
        contact.hotline = document.getElementById('display_phone').innerText;
        contact.email = document.getElementById('display_email').innerText;
        isOpen = true;
     "
     x-show="isOpen"
     x-transition.opacity.duration.300ms
     style="display: none;"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
     
    <div @click.away="isOpen = false"
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
         
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-xl font-bold text-gray-900">Cập nhật Liên hệ</h3>
            <button type="button" @click="isOpen = false" class="text-gray-400 hover:text-red-500 transition"><i class="fas fa-times"></i></button>
        </div>
        
        <!-- Bắn POST về hàm updateContact trong TourController -->
        <form action="/Project/public/index.php?url=tour/updateContact" method="POST" class="p-6 space-y-4 keep-scroll">
              
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Hotline</label>
                <input type="text" name="hotline" x-model="contact.hotline" required class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Email hỗ trợ</label>
                <input type="email" name="email" x-model="contact.email" required class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" @click="isOpen = false" class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Hủy</button>
                <button type="submit" class="flex-1 py-3 bg-blue-700 text-white font-bold rounded-xl hover:bg-blue-800 shadow-lg shadow-blue-500/30 transition">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>


<!-- ========================================== -->
<!-- SCRIPT CHỈ GIỮ VỊ TRÍ CUỘN KHI LƯU MODAL -->
<!-- ========================================== -->
<script>
    // 1. Phục hồi vị trí cuộn khi load trang (nếu có lưu)
    window.addEventListener('DOMContentLoaded', function() {
        let scrollPos = sessionStorage.getItem('scrollPosition');
        if (scrollPos !== null) {
            window.scrollTo({
                top: parseInt(scrollPos),
                behavior: 'instant'
            });
            sessionStorage.removeItem('scrollPosition'); // Phục hồi xong thì xóa đi
        }
    });

    // 2. CHỈ lưu vị trí cuộn khi submit các form có gắn class 'keep-scroll'
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form.keep-scroll').forEach(form => {
            form.addEventListener('submit', function() {
                sessionStorage.setItem('scrollPosition', window.scrollY);
            });
        });
    });

    // 3. Hàm hỗ trợ dành riêng cho các thẻ <a> (như nút Xóa)
    function saveScrollPos() {
        sessionStorage.setItem('scrollPosition', window.scrollY);
    }
</script>

<?php require_once '../app/views/inc/footer.php'; ?>



