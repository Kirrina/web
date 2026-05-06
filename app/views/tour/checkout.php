<?php require_once '../app/views/inc/header.php'; ?>

<!-- Nhúng Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<?php 
    $tour = $data['tour'];
    $qty = $data['quantity'];
    $depDate = $_POST['departure_date'] ?? 'Đang cập nhật'; 
    
    $basePricePerPerson = $tour['price'] ?? 0;
    $discountPerPerson = $tour['discount'] ?? 0;
    
    $totalBase = $basePricePerPerson * $qty;
    $totalDiscount = $discountPerPerson * $qty;
    $totalPrice = $totalBase - $totalDiscount;
?>

<!-- Kích hoạt Alpine.js cho toàn bộ Form -->
<div class="bg-[#f8f9fc] py-10 font-sans" x-data="{ payMethod: 'card' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Thanh Tiến Trình (Giữ nguyên) -->
        <div class="flex justify-center items-start mb-12">
            <div class="flex items-center w-full max-w-2xl">
                <a href="/Project/public/index.php?url=tour/detail/<?= $tour['id'] ?>" class="flex flex-col items-center relative w-1/3 group cursor-pointer transition-transform hover:scale-105">
                    <div class="w-10 h-10 rounded-full bg-blue-800 text-white flex items-center justify-center font-bold text-lg z-10 shadow-md group-hover:bg-blue-600 transition-colors">1</div>
                    <span class="text-blue-800 font-bold text-sm mt-3 group-hover:text-blue-600 transition-colors">Thông tin</span>
                </a>
                <div class="flex-1 h-0.5 bg-blue-800 -ml-10 -mr-10 mt-5 z-0"></div>
                <div class="flex flex-col items-center relative w-1/3">
                    <div class="w-10 h-10 rounded-full bg-blue-800 text-white flex items-center justify-center font-bold text-lg z-10 shadow-md">2</div>
                    <span class="text-blue-800 font-bold text-sm mt-3">Thanh toán</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-300 -ml-10 -mr-10 mt-5 z-0"></div>
                <div class="flex flex-col items-center relative w-1/3 opacity-50">
                    <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg z-10">3</div>
                    <span class="text-gray-500 font-medium text-sm mt-3">Hoàn tất</span>
                </div>
            </div>
        </div>

        <form action="/Project/public/index.php?url=tour/processBooking" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
            <input type="hidden" name="quantity" value="<?= $qty ?>">
            <!-- Lấy phương thức thanh toán từ biến Alpine -->
            <input type="hidden" name="payment_method" :value="payMethod">

            <!-- CỘT TRÁI (7/12) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- 1. Thông tin cá nhân -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-user text-blue-800 mr-3"></i> Thông tin cá nhân
                    </h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                            <input type="text" name="full_name" required value="<?= htmlspecialchars($_SESSION['user_fullname'] ?? '') ?>" class="w-full px-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" required placeholder="example@cloudjourney.vn" class="w-full px-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input type="text" name="phone" required placeholder="090 123 4567" class="w-full px-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Chọn Phương Thức Thanh Toán -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-money-check-alt text-blue-800 mr-3"></i> Chi tiết thanh toán
                    </h2>

                    <!-- Hai nút Lựa chọn -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <!-- Option: Thẻ -->
                        <div @click="payMethod = 'card'" 
                             :class="payMethod === 'card' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-gray-200 bg-white hover:bg-gray-50'"
                             class="cursor-pointer border rounded-2xl p-4 flex flex-col justify-center items-center gap-2 transition-all">
                            <i class="fas fa-credit-card text-2xl" :class="payMethod === 'card' ? 'text-blue-600' : 'text-gray-400'"></i>
                            <span class="text-sm font-bold" :class="payMethod === 'card' ? 'text-blue-800' : 'text-gray-600'">Thẻ Tín Dụng</span>
                        </div>
                        
                        <!-- Option: Tiền mặt -->
                        <div @click="payMethod = 'cash'" 
                             :class="payMethod === 'cash' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-gray-200 bg-white hover:bg-gray-50'"
                             class="cursor-pointer border rounded-2xl p-4 flex flex-col justify-center items-center gap-2 transition-all">
                            <i class="fas fa-money-bill-wave text-2xl" :class="payMethod === 'cash' ? 'text-blue-600' : 'text-gray-400'"></i>
                            <span class="text-sm font-bold" :class="payMethod === 'cash' ? 'text-blue-800' : 'text-gray-600'">Tiền Mặt</span>
                        </div>
                    </div>
                    
                    <!-- Khung Nhập Thẻ (Chỉ hiện khi chọn Thẻ) -->
                    <div x-show="payMethod === 'card'" x-transition class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Số thẻ</label>
                            <div class="relative">
                                <i class="far fa-credit-card absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" placeholder="0000 0000 0000 0000" class="w-full pl-12 pr-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm font-mono tracking-widest">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày hết hạn</label>
                                <input type="text" placeholder="MM/YY" class="w-full px-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                <div class="relative">
                                    <input type="password" placeholder="***" class="w-full px-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center bg-[#f2fbf6] text-[#28a745] px-4 py-3 rounded-xl border border-[#d4edda]">
                            <i class="fas fa-shield-alt mr-3"></i>
                            <p class="text-[13px] font-medium">Dữ liệu thẻ của bạn được mã hóa theo tiêu chuẩn quốc tế PCI DSS.</p>
                        </div>
                    </div>

                    <!-- Khung Báo Tiền Mặt (Chỉ hiện khi chọn Tiền mặt) -->
                    <div x-show="payMethod === 'cash'" x-cloak x-transition class="bg-[#fff9e6] border border-[#ffeeba] text-[#856404] p-5 rounded-2xl flex items-start gap-4">
                        <i class="fas fa-info-circle text-xl mt-0.5"></i>
                        <div>
                            <h4 class="font-bold mb-1">Thanh toán trực tiếp</h4>
                            <p class="text-sm">Bạn có thể thanh toán bằng tiền mặt tại văn phòng của chúng tôi hoặc thanh toán trực tiếp cho Hướng dẫn viên vào ngày khởi hành.</p>
                        </div>
                    </div>
                </div>

                <!-- 3. Ghi chú (Note / Description) -->
                <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-comment-dots text-blue-800 mr-3"></i> Ghi chú cho chuyến đi
                    </h2>
                    <textarea name="note" rows="3" placeholder="Yêu cầu ăn kiêng, có người già, trẻ em đi kèm..." class="w-full px-5 py-4 bg-[#f4f6f8] text-gray-800 rounded-xl outline-none focus:ring-2 focus:ring-blue-200 text-sm resize-none"></textarea>
                </div>

            </div>

            <!-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG (Giữ nguyên giao diện đẹp nãy giờ) -->
            <div class="lg:col-span-5">
                <div class="bg-[#f2f4f8] p-8 rounded-[2rem] sticky top-24">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-6">Tóm tắt đơn hàng</h2>
                    
                    <div class="flex gap-4 mb-6">
                        <img src="/Project/public/images/tours/<?= htmlspecialchars($tour['image'] ?? '') ?>" 
                             onerror="this.src='/Project/public/images/default-tour.jpg'"
                             class="w-20 h-20 object-cover rounded-2xl shadow-sm shrink-0">
                        <div>
                            <h3 class="font-bold text-blue-900 text-sm leading-snug line-clamp-2 mb-1"><?= htmlspecialchars($tour['name']) ?></h3>
                            <div class="text-xs text-gray-600 font-medium">
                                <i class="fas fa-star text-gray-800 mr-1 text-[10px]"></i> <?= number_format($tour['rate'] ?? 5, 1) ?> 
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200 mb-5">

                    <div class="space-y-4 text-sm font-medium text-gray-600 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="flex items-center"><i class="far fa-calendar-alt w-5 text-gray-400"></i> Ngày đi</span>
                            <span class="text-gray-900 font-bold"><?= $depDate ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center"><i class="fas fa-user-friends w-5 text-gray-400"></i> Số khách</span>
                            <span class="text-gray-900 font-bold"><?= sprintf("%02d", $qty) ?> Người lớn</span>
                        </div>
                    </div>

                    <div class="bg-gray-100/50 p-5 rounded-2xl mb-6">
                        <div class="flex justify-between items-center mb-3 text-sm">
                            <span class="text-gray-600">Giá tour gốc</span>
                            <span class="font-medium text-gray-900"><?= number_format($totalBase, 0, ',', '.') ?>đ</span>
                        </div>
                        <div class="flex justify-between items-center mb-4 text-sm">
                            <span class="text-gray-600">Giảm giá</span>
                            <span class="font-medium text-red-500">-<?= number_format($totalDiscount, 0, ',', '.') ?>đ</span>
                        </div>
                        <hr class="border-gray-200 mb-4">
                        <div class="flex justify-between items-end">
                            <span class="text-gray-900 font-bold text-lg">Tổng cộng</span>
                            <span class="text-2xl font-extrabold text-blue-700"><?= number_format($totalPrice, 0, ',', '.') ?>đ</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#fa8231] hover:bg-[#eb7424] text-white font-bold py-4 rounded-xl text-lg transition-colors shadow-lg shadow-orange-500/30 flex justify-center items-center">
                        Hoàn tất đặt chỗ <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>