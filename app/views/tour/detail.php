<!-- Tệp: app/views/tour/detail.php -->
<?php require_once '../app/views/inc/header.php'; ?>


<!-- Nhúng Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<?php 
    // Dữ liệu từ Controller truyền qua
    $tour = $data['tour'];
    
    // 1. Giải mã JSON Gallery & Itinerary
    $gallery = !empty($tour['gallery']) ? json_decode($tour['gallery'], true) : [];
    $itinerary = !empty($tour['itinerary']) ? json_decode($tour['itinerary'], true) : [];

    // 2. Map dữ liệu chuẩn theo cấu trúc Database mới
    $location = $tour['departure_location'] ?? 'Đang cập nhật';
    $duration = $tour['duration'] ?? 'Đang cập nhật';
    $rate = !empty($tour['rate']) ? $tour['rate'] : ''; // Nếu chưa có rate, mặc định 5.0
    $reviewCount = $tour['review_count'] ?? 0;
    $availableSeats = $tour['available_seats'] ?? 0;
    $price = $tour['price'] ?? 0;
    $discount = $tour['discount'] ?? 0;
    $departureDate = $tour['departure_date'] ?? '';
    $description = $tour['description'] ?? 'Đang cập nhật thông tin chi tiết.';
    
    // 3. Xử lý giá sau khi giảm (Nếu có discount > 0)
    // Giả sử discount là số tiền giảm thẳng (VD: 200000), nếu là phần trăm thì Toni sửa lại logic nhé
    $finalPrice = $price - $discount;
    if ($finalPrice < 0) $finalPrice = 0;

    // Các biến dự phòng cho UI (vì Database chưa có cột này)
    $language = 'Tiếng Việt';
    $serviceLevel = 'Tiêu chuẩn';
?>

<div class="bg-[#f8f9fa] pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6 font-medium">
            <a href="/Project/public/index.php" class="hover:text-blue-700 transition">Trang chủ</a>
            <span class="mx-2">›</span>
            <a href="/Project/public/index.php?url=tour/index" class="hover:text-blue-700 transition">Điểm đến</a>
            <span class="mx-2">›</span>
            <span class="text-blue-900"><?= htmlspecialchars($tour['name']) ?></span>
        </nav>

        <!-- Tiêu đề & Đánh giá -->
        <div class="mb-6">
            <h1 class="text-4xl font-extrabold text-blue-950 mb-3"><?= htmlspecialchars($tour['name']) ?></h1>
            <div class="flex items-center text-sm text-gray-600 gap-4">
                <div class="flex items-center text-orange-500 font-bold">
                    <?php if (is_null($tour['rate']) || $tour['review_count'] == 0): ?>
                    <?php else: ?>
                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                        <?= number_format($tour['rate'], 1) ?>
                        <span class="text-gray-400 font-normal ml-1 hover:underline cursor-pointer">(<?= htmlspecialchars($tour['review_count']) ?>)</span>
                    <?php endif; ?>
                    <span class="text-gray-500 font-normal ml-1 hover:underline cursor-pointer">(<?= htmlspecialchars($reviewCount) ?> đánh giá)</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i> <?= htmlspecialchars($location) ?>
                </div>
            </div>
        </div>

        <!-- XỬ LÝ DỮ LIỆU GALLERY -->
        <?php 
            function getImageUrl($imgName) {
                if (empty($imgName)) return '/Project/public/images/default-tour.jpg'; 
                if (strpos($imgName, 'http') === 0) return $imgName;
                return '/Project/public/images/tours/' . $imgName;
            }
        ?>

        <!-- Thư viện Ảnh (Grid CSS) -->
        <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-3 h-auto md:h-[450px] mb-12 rounded-2xl overflow-hidden">
            <?php if (!empty($gallery) && count($gallery) >= 4): ?>
                <div class="md:col-span-2 md:row-span-2 h-64 md:h-full">
                    <img src="<?= htmlspecialchars(getImageUrl($gallery[0])) ?>" alt="Main Image" class="w-full h-full object-cover hover:scale-105 transition duration-700 cursor-pointer">
                </div>
                <div class="h-48 md:h-full">
                    <img src="<?= htmlspecialchars(getImageUrl($gallery[1])) ?>" alt="Gallery 1" class="w-full h-full object-cover hover:scale-105 transition duration-700 cursor-pointer">
                </div>
                <div class="h-48 md:h-full">
                    <img src="<?= htmlspecialchars(getImageUrl($gallery[2])) ?>" alt="Gallery 2" class="w-full h-full object-cover hover:scale-105 transition duration-700 cursor-pointer">
                </div>
                <div class="md:col-span-2 h-48 md:h-full relative group overflow-hidden">
                    <img src="<?= htmlspecialchars(getImageUrl($gallery[3])) ?>" alt="Gallery 3" class="w-full h-full object-cover hover:scale-105 transition duration-700 cursor-pointer">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition duration-300 pointer-events-none"></div>
                </div>
            <?php else: ?>
                <div class="md:col-span-4 md:row-span-2 h-64 md:h-[450px]">
                    <img src="<?= htmlspecialchars(getImageUrl($tour['image'] ?? '')) ?>" alt="<?= htmlspecialchars($tour['name']) ?>" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>
        </div>
        
        <!-- BỐ CỤC CHÍNH 2 CỘT -->
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- CỘT TRÁI -->
            <div class="w-full lg:w-2/3">
                <section class="mb-10">
                    <h2 class="text-2xl font-bold text-blue-950 mb-4">Về tour này</h2>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        <?= nl2br(htmlspecialchars($description)) ?>
                    </p>
                </section>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <div class="bg-[#f0f4f8] p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2 text-lg"><i class="far fa-clock"></i></div>
                        <span class="text-xs text-gray-500 uppercase font-bold mb-1">Thời gian</span>
                        <span class="text-sm font-bold text-gray-800"><?= htmlspecialchars($duration) ?></span>
                    </div>
                    <div class="bg-[#f0f4f8] p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2 text-lg"><i class="fas fa-user-friends"></i></div>
                        <span class="text-xs text-gray-500 uppercase font-bold mb-1">Số lượng</span>
                        <span class="text-sm font-bold text-gray-800">Còn <?= htmlspecialchars($availableSeats) ?> chỗ</span>
                    </div>
                    <div class="bg-[#f0f4f8] p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2 text-lg"><i class="fas fa-globe"></i></div>
                        <span class="text-xs text-gray-500 uppercase font-bold mb-1">Ngôn ngữ</span>
                        <span class="text-sm font-bold text-gray-800"><?= htmlspecialchars($language) ?></span>
                    </div>
                    <div class="bg-[#f0f4f8] p-4 rounded-2xl flex flex-col items-center justify-center text-center">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2 text-lg"><i class="fas fa-gem"></i></div>
                        <span class="text-xs text-gray-500 uppercase font-bold mb-1">Dịch vụ</span>
                        <span class="text-sm font-bold text-gray-800"><?= htmlspecialchars($serviceLevel) ?></span>
                    </div>
                </div>

                <!-- XÁC THỰC ADMIN (Toni nhớ thay biến này bằng logic kiểm tra Session Admin thực tế nhé) -->
                <?php $isAdmin = true; ?>

                <!-- LỊCH TRÌNH CHI TIẾT (Đã tích hợp Alpine.js quản lý State và Edit) -->
                <section x-data='itineraryManager(<?= json_encode($itinerary, JSON_HEX_APOS | JSON_HEX_QUOT) ?>, <?= $tour['id'] ?? 0 ?>)'>
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-blue-950">Lịch trình chi tiết</h2>
                        
                        <!-- NÚT MỞ FORM SỬA (Thêm .stop.prevent để chặn click xuyên thủng) -->
                        <?php if ($isAdmin): ?>
                            <button @click.stop.prevent="isOpen = true" type="button" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center transition shadow-sm cursor-pointer">
                                <i class="fas fa-edit mr-2"></i> Chỉnh sửa
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <!-- HIỂN THỊ TIMELINE BÌNH THƯỜNG -->
                    <div class="relative border-l-2 border-blue-100 ml-4 space-y-4 pb-4">
                        <template x-for="(day, index) in originalItinerary" :key="index">
                            <div class="relative pl-8">
                                <div class="absolute -left-[11px] top-5 w-5 h-5 bg-white border-4 border-blue-600 rounded-full shadow-sm z-10"></div>
                                
                                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                                    <button @click="activeDay === index ? activeDay = null : activeDay = index" class="w-full flex items-center justify-between p-5 text-left hover:bg-blue-50/50 transition focus:outline-none">
                                        <h3 class="text-lg font-bold text-blue-900 flex items-center">
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm mr-3" x-text="'Ngày ' + (index + 1)"></span>
                                            <span x-text="day.title"></span>
                                        </h3>
                                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="activeDay === index ? 'rotate-180' : ''"></i>
                                    </button>

                                    <!-- Nội dung thu gọn / mở rộng -->
                                    <div x-show="activeDay === index" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 -translate-y-2"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="px-5 pb-6 border-t border-gray-50">
                                        
                                        <p class="text-gray-600 text-sm my-4 leading-relaxed italic" x-text="day.description"></p>
                                        
                                        <template x-if="Object.keys(day.activities || {}).length > 0">
                                            <div class="bg-[#fcfdfe] rounded-xl p-4 border border-blue-50">
                                                <ul class="space-y-3 text-sm text-gray-600">
                                                    <template x-for="(desc, time) in day.activities" :key="time">
                                                        <li class="flex items-start">
                                                            <span class="bg-white border border-blue-100 text-blue-600 font-bold text-[11px] px-2 py-0.5 rounded shadow-sm mr-3 shrink-0" x-text="time"></span> 
                                                            <span class="pt-0.5" x-text="desc"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template x-if="originalItinerary.length === 0">
                            <div class="text-gray-500 italic ml-8">Chưa có thông tin lịch trình cho chuyến đi này.</div>
                        </template>
                    </div>

                    <!-- MODAL CHỈNH SỬA CHO ADMIN -->
                    <template x-if="isOpen">
                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                            <!-- Đổi @click.away thành @click.outside (Chuẩn của Alpine V3) -->
                            <div class="bg-white w-full max-w-4xl max-h-[90vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden" @click.outside="isOpen = false">
                                
                                <!-- Modal Header -->
                                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                                    <h3 class="text-xl font-bold text-gray-800">Cập nhật Lịch Trình</h3>
                                    <button @click="isOpen = false" class="text-gray-400 hover:text-red-500 text-xl"><i class="fas fa-times"></i></button>
                                </div>

                                <!-- Modal Body (Form) -->
                                <div class="p-6 overflow-y-auto flex-1 bg-gray-100/50 space-y-6">
                                    <template x-for="(day, dIndex) in editData" :key="dIndex">
                                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                                            <div class="flex justify-between items-center mb-4">
                                                <h4 class="font-bold text-blue-700">Ngày <span x-text="dIndex + 1"></span></h4>
                                                <button @click="removeDay(dIndex)" class="text-red-500 hover:bg-red-50 px-2 py-1 rounded text-sm"><i class="fas fa-trash"></i> Xóa ngày này</button>
                                            </div>
                                            
                                            <input x-model="day.title" type="text" placeholder="Tiêu đề ngày (VD: Ngày 1: Khám phá...)" class="w-full mb-3 px-3 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-400 text-sm font-medium">
                                            <textarea x-model="day.description" rows="2" placeholder="Mô tả chung cho ngày này" class="w-full mb-4 px-3 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-400 text-sm"></textarea>
                                            
                                            <!-- Hoạt động chi tiết -->
                                            <div class="space-y-2 mb-3">
                                                <label class="text-sm font-bold text-gray-600 block">Các hoạt động trong ngày:</label>
                                                <template x-for="(act, aIndex) in day.activitiesArr" :key="aIndex">
                                                    <div class="flex gap-2">
                                                        <input x-model="act.time" type="time" class="w-32 px-3 py-2 border rounded-lg outline-none text-sm">
                                                        <input x-model="act.text" type="text" placeholder="Nội dung hoạt động" class="flex-1 px-3 py-2 border rounded-lg outline-none text-sm">
                                                        <button @click="removeActivity(dIndex, aIndex)" class="text-gray-400 hover:text-red-500 px-3"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </template>
                                            </div>
                                            <button @click="addActivity(dIndex)" class="text-sm text-blue-600 hover:text-blue-800 font-bold border border-blue-200 px-3 py-1.5 rounded-lg border-dashed w-full"><i class="fas fa-plus mr-1"></i> Thêm mốc thời gian</button>
                                        </div>
                                    </template>
                                    
                                    <button @click="addDay" class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700 font-bold py-4 rounded-xl border border-blue-300 border-dashed transition"><i class="fas fa-calendar-plus mr-2"></i> THÊM NGÀY MỚI</button>
                                </div>

                                <!-- Modal Footer -->
                                <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-3 bg-white">
                                    <button @click="isOpen = false" class="px-5 py-2.5 rounded-xl font-bold text-gray-600 hover:bg-gray-100">Hủy</button>
                                    <button @click="saveData" class="px-5 py-2.5 rounded-xl font-bold text-white bg-blue-600 hover:bg-blue-700 flex items-center">
                                        <i class="fas fa-save mr-2"></i> Lưu Lịch Trình
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </section>
            </div>

            <!-- CỘT PHẢI: WIDGET ĐẶT TOUR -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100 sticky top-24">
                    
                    <?php 
                        // Tính toán giá để truyền vào AlpineJS
                        $finalPrice = $tour['price'] - ($tour['discount'] ?? 0); 
                    ?>

                    <!-- CHỈ DÙNG 1 FORM DUY NHẤT BAO BỌC TOÀN BỘ -->
                    <form action="/Project/public/index.php?url=tour/checkout" method="POST" 
                        x-data="{ 
                            guests: 1, 
                            price: <?= $finalPrice ?>, 
                            maxSeats: <?= $availableSeats ?>,
                            formatMoney(val) {
                                return new Intl.NumberFormat('vi-VN').format(val) + 'đ';
                            }
                        }">
                        
                        <div class="mb-6 flex items-end justify-between border-b border-gray-100 pb-4">
                            <div>
                                <?php if($discount > 0): ?>
                                    <p class="text-sm text-gray-400 line-through mb-1"><?= number_format($price, 0, ',', '.') ?>đ</p>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500 font-medium mb-1">Giá từ</p>
                                <?php endif; ?>
                                <!-- Giá tự nhảy ngay lập tức -->
                                <h3 class="text-3xl font-extrabold text-blue-900" x-text="formatMoney(price)"></h3>
                            </div>
                            <span class="text-sm text-gray-500 mb-1">/người</span>
                        </div>

                        <!-- CÁC INPUT ẨN ĐỂ GỬI DỮ LIỆU VỀ CONTROLLER -->
                        <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tour['id']) ?>"> 
                        <input type="hidden" name="quantity" :value="guests">
                        <input type="hidden" name="departure_date" value="<?= htmlspecialchars($departureDate) ?>">

                        <!-- NGÀY KHỞI HÀNH -->
                        <div class="mb-5">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ngày khởi hành cố định</label>
                            <div class="flex items-center bg-[#f8f9fa] text-blue-900 font-bold rounded-xl py-3 px-4 border border-blue-50">
                                <i class="far fa-calendar-check mr-3 text-blue-500"></i>
                                <span><?= date('d/m/Y', strtotime($departureDate)) ?></span>
                            </div>
                        </div>

                        <!-- CHỌN SỐ LƯỢNG KHÁCH -->
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Số lượng khách</label>
                            <div class="flex items-center justify-between bg-[#f8f9fa] rounded-xl p-2 border border-gray-100">
                                <button type="button" @click="if(guests > 1) guests--" 
                                        class="w-10 h-10 bg-white rounded-lg shadow-sm text-gray-600 hover:text-blue-600 font-bold text-lg flex items-center justify-center transition">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                
                                <span class="text-lg font-extrabold text-gray-800" x-text="guests < 10 ? '0'+guests : guests"></span>
                                
                                <button type="button" @click="if(guests < maxSeats) guests++" 
                                        class="w-10 h-10 bg-white rounded-lg shadow-sm text-gray-600 hover:text-blue-600 font-bold text-lg flex items-center justify-center transition"
                                        :class="{'opacity-50 cursor-not-allowed': guests >= maxSeats}">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            <p x-show="guests >= maxSeats" class="text-[10px] text-red-500 mt-2 font-medium" style="display: none;">Đã đạt giới hạn số chỗ trống!</p>
                        </div>

                        <!-- TÍNH TỔNG TIỀN TỰ ĐỘNG -->
                        <div class="flex justify-between items-center mb-6 pt-4 border-t border-gray-100">
                            <span class="text-gray-800 font-bold">Tổng tiền:</span>
                            <span class="text-2xl font-extrabold text-orange-600" x-text="formatMoney(guests * price)"></span>
                        </div>

                        <!-- NÚT ĐẶT NGAY -->
                        <button type="submit" 
                                <?= $availableSeats <= 0 ? 'disabled' : '' ?>
                                class="w-full <?= $availableSeats <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-orange-500 hover:bg-orange-600 shadow-lg shadow-orange-500/30 hover:-translate-y-0.5' ?> text-white font-bold text-lg py-4 rounded-xl transition-all">
                            <?= $availableSeats <= 0 ? 'Đã hết chỗ' : 'Đặt ngay' ?>
                        </button>
                    </form>

                    <p class="text-center text-xs text-gray-400 mt-4">Giá cố định cho ngày khởi hành này</p>
                </div>
            </div>
        </div>


       <!-- PHẦN ĐÁNH GIÁ & BÌNH LUẬN -->
        <?php 
            // Giả định Controller đã truyền danh sách bình luận qua biến $data['comments']
            $comments = $data['comments'] ?? []; 

            // Hàm hỗ trợ vẽ ngôi sao đánh giá (Đã bọc chống lỗi Cannot redeclare)
            if (!function_exists('renderStars')) {
                function renderStars($rating) {
                    $html = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            $html .= '<i class="fas fa-star text-yellow-400"></i>';
                        } else {
                            $html .= '<i class="far fa-star text-gray-300"></i>';
                        }
                    }
                    return $html;
                }
            }
        ?>

        <section id="review-section" class="mt-16 pt-12 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-blue-950 mb-8">Đánh giá từ khách hàng</h2>
            
            <div class="flex flex-col lg:flex-row gap-10">
                
                <!-- CỘT TRÁI: TỔNG QUAN & FORM BÌNH LUẬN -->
                <div class="w-full lg:w-1/3">
                    <!-- Bảng Tổng Quan Rating -->
                    <div class="bg-blue-50 rounded-3xl p-6 text-center border border-blue-100 mb-6">
                        <h3 class="text-gray-600 font-bold mb-2">Đánh giá trung bình</h3>
                        <div class="text-5xl font-extrabold text-blue-900 mb-3"><?= !empty($tour['rate']) ? number_format($tour['rate'], 1) : '5.0' ?></div>
                        <div class="flex justify-center text-xl mb-2">
                            <?= renderStars(round($tour['rate'] ?? 5)) ?>
                        </div>
                        <p class="text-sm text-gray-500">Dựa trên <?= htmlspecialchars($reviewCount) ?> đánh giá</p>
                    </div>

                    <!-- Form Viết Bình Luận -->
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">Chia sẻ trải nghiệm của bạn</h3>
                        
                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <!-- Giao diện khi chưa đăng nhập -->
                            <div class="text-center py-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <i class="fas fa-user-lock text-3xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 text-sm mb-4 px-4">Vui lòng đăng nhập để có thể gửi đánh giá và nhận xét về chuyến đi này.</p>
                                <a href="/Project/public/user/login" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-xl transition shadow-md">
                                    Đăng nhập ngay
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Form này sẽ gửi lên route tour/postComment khi ĐÃ đăng nhập -->
                            <form action="/Project/public/index.php?url=tour/postComment" method="POST">
                                <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tour['id']) ?>">
                                
                                <!-- Hiển thị tên User đang thao tác cho thân thiện -->
                                <div class="mb-4 flex items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <div class="w-10 h-10 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center font-bold">
                                        <?= mb_substr($_SESSION['user_fullname'], 0, 1, "UTF-8") ?>
                                    </div>
                                    <div>
                                        <p class="text-[11px] text-gray-500 uppercase font-bold tracking-wider">Đánh giá dưới tên</p>
                                        <p class="font-bold text-gray-800"><?= htmlspecialchars($_SESSION['user_fullname']) ?></p>
                                    </div>
                                </div>

                                <!-- Chọn Rating -->
                                <div class="mb-4">
                                    <label class="block text-sm text-gray-600 font-medium mb-2">Chất lượng tour:</label>
                                    <select name="rating" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none text-sm text-gray-700 cursor-pointer hover:border-blue-300 transition">
                                        <option value="5">⭐⭐⭐⭐⭐ - Tuyệt vời</option>
                                        <option value="4">⭐⭐⭐⭐ - Rất tốt</option>
                                        <option value="3">⭐⭐⭐ - Bình thường</option>
                                        <option value="2">⭐⭐ - Tệ</option>
                                        <option value="1">⭐ - Rất tệ</option>
                                    </select>
                                </div>

                                <textarea name="content" required rows="3" placeholder="Tour đi vui không? Hướng dẫn viên thế nào?..." class="w-full mb-4 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500 text-sm resize-none"></textarea>
                                
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-md shadow-blue-500/30">
                                    <i class="fas fa-paper-plane mr-2"></i> Gửi đánh giá
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CỘT PHẢI: DANH SÁCH BÌNH LUẬN -->
                <div class="w-full lg:w-2/3">
                    <?php if (!empty($comments)): ?>
                        <div class="space-y-6">
                            <?php foreach ($comments as $cmt): ?>
                                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                                    <!-- Avatar mặc định tạo từ chữ cái đầu của tên -->
                                    <div class="w-12 h-12 shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center rounded-full font-bold text-lg shadow-sm">
                                        <?= mb_substr($cmt['customer_name'] ?? 'U', 0, 1, "UTF-8") ?>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="font-bold text-gray-900"><?= htmlspecialchars($cmt['customer_name'] ?? 'Khách hàng') ?></h4>
                                            <span class="text-xs text-gray-400"><i class="far fa-clock mr-1"></i> <?= date('d/m/Y', strtotime($cmt['created_at'])) ?></span>
                                        </div>
                                        <div class="text-sm mb-2">
                                            <?= renderStars($cmt['rating']) ?>
                                        </div>
                                        <p class="text-gray-600 text-sm leading-relaxed">
                                            <?= nl2br(htmlspecialchars($cmt['content'])) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <!-- Giao diện trống khi chưa có comment -->
                        <div class="h-full flex flex-col items-center justify-center bg-gray-50 rounded-3xl border border-dashed border-gray-200 p-10 text-center">
                            <i class="far fa-comments text-5xl text-gray-300 mb-4"></i>
                            <h4 class="text-lg font-bold text-gray-700 mb-1">Chưa có đánh giá nào</h4>
                            <p class="text-gray-500 text-sm">Hãy trở thành người đầu tiên chia sẻ cảm nhận về chuyến đi này nhé!</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </section>
        <!-- NHỮNG CHUYẾN ĐI TƯƠNG TỰ (Đã được xử lý Logic Động & Lấy tên DB) -->
        <?php 
            // Nhận dữ liệu từ Controller
            $suggestedTours = $data['suggestedTours'] ?? []; 
        ?>

        <?php if (!empty($suggestedTours)): ?>
        <section class="mt-20 border-t border-gray-200 pt-16">
            <h2 class="text-2xl font-bold text-blue-950 mb-8">Những chuyến đi tương tự</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($suggestedTours as $sTour): ?>
                    <?php 
                        // Xử lý giá giảm
                        $sPrice = $sTour['price'] ?? 0;
                        $sDiscount = $sTour['discount'] ?? 0;
                        $sFinalPrice = max(0, $sPrice - $sDiscount);
                        $sRate = !empty($sTour['rate']) ? $sTour['rate'] : '5.0';
                        
                        // Lấy trực tiếp tên danh mục từ cú JOIN trong SQL
                        $catName = $sTour['category_name'] ?? 'Khám phá'; 
                    ?>
                    
                    <a href="/Project/public/index.php?url=tour/detail/<?= $sTour['id'] ?>" class="block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group cursor-pointer flex flex-col h-full">
                        
                        <!-- Ảnh bìa -->
                        <div class="h-48 overflow-hidden shrink-0">
                            <img src="<?= htmlspecialchars(getImageUrl($sTour['image'])) ?>" alt="<?= htmlspecialchars($sTour['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        
                        <!-- Nội dung card -->
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex justify-between items-center text-xs font-bold mb-2 uppercase tracking-wider">
                                <span class="text-gray-500 bg-gray-100 px-2 py-1 rounded"><?= htmlspecialchars($catName) ?></span>
                                 <?php if (is_null($tour['rate']) || $tour['review_count'] == 0): ?>
                                 <?php else: ?>
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                                                <?= number_format($sTour['rate'], 1) ?>
                                                <span class="text-gray-400 font-normal ml-1 hover:underline cursor-pointer">(<?= htmlspecialchars($sTour['review_count']) ?>)</span>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition line-clamp-2 text-sm">
                                <?= htmlspecialchars($sTour['name']) ?>
                            </h3>
                            
                            <div class="text-xs text-gray-500 mb-4 flex items-center">
                                <i class="far fa-clock mr-1"></i> <?= htmlspecialchars($sTour['duration']) ?>
                            </div>
                            
                            <!-- Đẩy giá tiền xuống đáy -->
                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <?php if($sDiscount > 0): ?>
                                    <p class="text-xs text-gray-400 line-through mb-0.5"><?= number_format($sPrice, 0, ',', '.') ?>đ</p>
                                <?php endif; ?>
                                <p class="font-extrabold text-blue-800 text-lg">
                                    <?= number_format($sFinalPrice, 0, ',', '.') ?>đ
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
        
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('itineraryManager', (initialData, tourId) => ({
        originalItinerary: initialData,
        editData: [],
        tourId: tourId,
        isOpen: false,
        activeDay: 0,
        
        init() {
            // Chuẩn bị dữ liệu khi form mở lên
            this.$watch('isOpen', value => {
                if(value) {
                    this.editData = JSON.parse(JSON.stringify(this.originalItinerary)).map(day => {
                        let acts = [];
                        if (day.activities) {
                            Object.keys(day.activities).forEach(time => {
                                acts.push({ time: time, text: day.activities[time] });
                            });
                        }
                        return { ...day, activitiesArr: acts };
                    });
                }
            });
        },
        
        addDay() {
            this.editData.push({ title: '', description: '', activitiesArr: [] });
        },
        removeDay(index) {
            this.editData.splice(index, 1);
        },
        addActivity(dayIndex) {
            this.editData[dayIndex].activitiesArr.push({ time: '', text: '' });
        },
        removeActivity(dayIndex, actIndex) {
            this.editData[dayIndex].activitiesArr.splice(actIndex, 1);
        },
        
        saveData() {
            // Chuyển lại mảng array thành object theo định dạng { "08:00": "Hoạt động" }
            let payload = this.editData.map(day => {
                let actObj = {};
                day.activitiesArr.forEach(act => {
                    if(act.time && act.text) actObj[act.time] = act.text;
                });
                return { title: day.title, description: day.description, activities: actObj };
            });
            
            // Gửi qua Controller (Nhớ tạo hàm updateItinerary trong Controller Tour nhé)
            fetch('/Project/public/index.php?url=tour/updateItinerary', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tour_id: this.tourId, itinerary: payload })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Đã cập nhật Lịch trình thành công!');
                    location.reload(); 
                } else {
                    alert('Có lỗi xảy ra: ' + (data.message || 'Không thể lưu lên DB'));
                }
            })
            .catch(err => alert('Lỗi hệ thống: ' + err));
        }
    }));
});
</script>

<?php require_once '../app/views/inc/footer.php'; ?>