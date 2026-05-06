
<!-- Tệp: app/views/home/index.php -->
<?php require_once '../app/views/inc/header.php'; ?>

<!-- 1. HERO BANNER & THANH TÌM KIẾM NỔI -->
<section class="relative bg-gray-900 h-[500px]">
    <!-- Ảnh nền (Thay bằng link ảnh vịnh của bạn) -->
    <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?q=80&w=1920&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Hero Background">
    
    <!-- Lớp phủ tối -->
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>

    <!-- Text trung tâm -->
    <div class="relative z-10 flex flex-col justify-center items-center h-full text-center px-4">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 drop-shadow-lg">
            Khám phá hành trình tuyệt vời<br>của bạn
        </h1>
    </div>

    <!-- Thanh tìm kiếm nổi (Nằm đè lên mép dưới của banner) -->
    <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 w-11/12 max-w-5xl bg-white rounded-full shadow-2xl p-2 z-20 hidden md:block">
        <form action="/Project/public/index.php" method="GET" class="flex items-center justify-between w-full h-16">
            <!-- Bắt buộc để Route của MVC hoạt động -->
           
            <input type="hidden" name="url" value="tour/index">

            <!-- Địa điểm -->
            <div class="flex-1 flex items-center px-6 border-r border-gray-200">
                <i class="fas fa-map-marker-alt text-blue-600 text-lg mr-3"></i>
                <div class="flex flex-col w-full">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Địa điểm</span>
                    <!-- Biến keyword sẽ được gửi đi -->
                    <input type="text" name="keyword" placeholder="Bạn muốn đi đâu?" class="w-full text-sm text-gray-800 font-medium focus:outline-none placeholder-gray-500">
                </div>
            </div>

            <!-- Ngày đi -->
            <div class="flex-1 flex items-center px-6 border-r border-gray-200">
                <i class="far fa-calendar-alt text-blue-600 text-lg mr-3"></i>
                <div class="flex flex-col w-full">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Ngày đi</span>
                    <input type="date" name="date" class="w-full text-sm text-gray-800 font-medium focus:outline-none text-gray-500">
                </div>
            </div>

            <!-- Hành khách -->
            <div class="flex-1 flex items-center px-6">
                <i class="fas fa-user-friends text-blue-600 text-lg mr-3"></i>
                <div class="flex flex-col w-full">
                    <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Hành khách</span>
                    <select name="guests" class="w-full text-sm text-gray-800 font-medium focus:outline-none bg-transparent">
                        <option value="1">1 Người lớn</option>
                        <option value="2" selected>2 Người lớn</option>
                        <option value="3">3 Người lớn</option>
                        <option value="4">4 Người lớn</option>
                    </select>
                </div>
            </div>

            <!-- Nút Tìm Kiếm -->
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white h-full px-10 rounded-full font-bold transition-colors text-sm shadow-md whitespace-nowrap">
                <i class="fas fa-search mr-2"></i> Tìm kiếm
            </button>
        </form>
    </div>
</section>

<!-- KHOẢNG TRẮNG ĐỂ ĐẨY NỘI DUNG XUỐNG DƯỚI THANH TÌM KIẾM NỔI -->
<div class="h-20"></div>


<!-- 2. CHUYẾN ĐI NỔI BẬT -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-blue-900 mb-2">Chuyến đi nổi bật</h2>
            <p class="text-gray-500">Những trải nghiệm được tuyển chọn kỹ lưỡng dành riêng cho bạn<br>để khám phá vẻ đẹp thế giới.</p>
        </div>
        <!-- Link nối trực tiếp đi vào List -->
        <div>
            <a href="/Project/public/index.php?url=tour/index" class="text-blue-700 font-bold hover:text-orange-500 transition flex items-center">
                Xem tất cả <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <!-- Vòng lặp hiển thị 3 Tour đầu tiên từ Database -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if (!empty($tours)): ?>
            <?php 
            // Cắt mảng lấy 3 tour đầu tiên để hiển thị cho gọn trang chủ
            $featuredTours = array_slice($tours, 0, 3); 
            foreach ($featuredTours as $tour): 
            ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow group">
                <div class="relative h-56 overflow-hidden">
                    <img src="<?= htmlspecialchars($tour['image']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="<?= htmlspecialchars($tour['name']) ?>">
                    <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-blue-900 px-2 py-1 text-xs font-bold uppercase tracking-wider rounded">
                        <?= htmlspecialchars($tour['category_name'] ?? 'Tour') ?>
                    </span>
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <!-- Tên tour -->
                        <h3 class="font-bold text-lg text-gray-900 line-clamp-1" title="<?= htmlspecialchars($tour['name']) ?>">
                            <?= htmlspecialchars($tour['name']) ?>
                        </h3>
                        <div class="flex items-center text-yellow-500 text-sm ml-2 whitespace-nowrap"><i class="fas fa-star mr-1"></i>4.9</div>
                    </div>
                    <!-- Thời lượng -->
                    <p class="text-gray-500 text-sm mb-4"><i class="far fa-clock mr-1"></i> <?= htmlspecialchars($tour['duration']) ?></p>
                    
                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <p class="text-xs text-gray-400">Giá từ</p>
                            <!-- Giá tiền -->
                            <p class="text-blue-700 font-bold text-xl"><?= number_format($tour['price'], 0, ',', '.') ?>đ</p>
                        </div>
                        <!-- Link nối vào trang Detail của sản phẩm tương ứng -->
                        <a href="index.php?controller=tour&action=detail&id=<?= $tour['id'] ?>" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Đặt ngay
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- 3. TẠI SAO CHỌN CLOUDJOURNEY -->
<section class="max-w-7xl mx-auto px-4 py-16 text-center">
    <h2 class="text-3xl font-bold text-blue-900 mb-3">Tại sao chọn CloudJourney?</h2>
    <p class="text-gray-500 mb-12">Chúng tôi mang đến sự an tâm và những trải nghiệm độc đáo nhất cho mọi hành trình.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl"><i class="fas fa-shield-alt"></i></div>
            <h4 class="font-bold text-gray-900 mb-2">An toàn tuyệt đối</h4>
            <p class="text-sm text-gray-500">Hệ thống bảo hiểm và hỗ trợ khách hàng 24/7 trên mọi nẻo đường.</p>
        </div>
        <!-- Các box khác tương tự, chỉ thay Icon và Text -->
    </div>
</section>

<!-- 4. BANNER ĐĂNG KÝ EMAIL -->
<section class="max-w-7xl mx-auto px-4 py-10 mb-10">
    <div class="bg-blue-700 rounded-3xl p-10 md:p-16 flex flex-col items-center text-center relative overflow-hidden">
        <!-- Vòng tròn trang trí -->
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-white opacity-5 rounded-full"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-white opacity-10 rounded-full"></div>

        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 z-10">Đăng ký để nhận ưu đãi bí mật</h2>
        <p class="text-blue-100 mb-8 max-w-xl z-10">Gia nhập cộng đồng hơn 50.000 người yêu du lịch và nhận những deal hời nhất trực tiếp vào email của bạn.</p>
        
        <form class="w-full max-w-md flex bg-blue-600 p-1.5 rounded-full z-10 border border-blue-500">
            <input type="email" placeholder="Địa chỉ email của bạn" class="flex-1 bg-transparent text-white px-4 focus:outline-none placeholder-blue-300 text-sm">
            <button type="button" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-full transition text-sm">
                Đăng ký ngay
            </button>
        </form>
    </div>
</section>

<?php require_once '../app/views/inc/footer.php'; ?>