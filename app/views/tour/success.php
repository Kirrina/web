<?php require_once '../app/views/inc/header.php'; ?>

<!-- Nền xám nhạt đồng bộ với trang Checkout -->
<div class="bg-[#f8f9fc] py-10 font-sans min-h-[80vh] flex flex-col items-center">
    <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Thanh Tiến Trình (Progress Bar) - Bước 3 đang Active -->
        <div class="flex justify-center items-start mb-12">
            <div class="flex items-center w-full max-w-2xl">
                <!-- Step 1: Đã xong (Hiện dấu tick) -->
                <div class="flex flex-col items-center relative w-1/3">
                    <div class="w-10 h-10 rounded-full bg-blue-800 text-white flex items-center justify-center font-bold text-lg z-10 shadow-md">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-blue-800 font-bold text-sm mt-3">Thông tin</span>
                </div>
                <!-- Line 1: Đã qua (Màu xanh) -->
                <div class="flex-1 h-0.5 bg-blue-800 -ml-10 -mr-10 mt-5 z-0"></div>
                
                <!-- Step 2: Đã xong (Hiện dấu tick) -->
                <div class="flex flex-col items-center relative w-1/3">
                    <div class="w-10 h-10 rounded-full bg-blue-800 text-white flex items-center justify-center font-bold text-lg z-10 shadow-md">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="text-blue-800 font-bold text-sm mt-3">Thanh toán</span>
                </div>
                <!-- Line 2: Đã qua (Màu xanh) -->
                <div class="flex-1 h-0.5 bg-blue-800 -ml-10 -mr-10 mt-5 z-0"></div>
                
                <!-- Step 3: Đang ở hiện tại (Active) -->
                <div class="flex flex-col items-center relative w-1/3">
                    <div class="w-10 h-10 rounded-full bg-blue-800 text-white flex items-center justify-center font-bold text-lg z-10 shadow-md ring-4 ring-blue-100">3</div>
                    <span class="text-blue-800 font-bold text-sm mt-3">Hoàn tất</span>
                </div>
            </div>
        </div>

        <!-- Khối Thông Báo Thành Công -->
        <div class="bg-white p-10 md:p-14 rounded-[2rem] shadow-sm border border-gray-100 text-center transform transition-all duration-500 hover:-translate-y-1 mt-4">
            
            <!-- Icon Checkmark (Hiệu ứng vòng tròn xanh) -->
            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8 relative">
                <!-- Vòng tròn tỏa ra -->
                <div class="absolute inset-0 bg-green-100 rounded-full animate-ping opacity-30"></div>
                <i class="fas fa-check-circle text-6xl text-green-500 relative z-10"></i>
            </div>
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">Đặt Tour Thành Công!</h1>
            
            <p class="text-gray-500 mb-8 leading-relaxed text-lg max-w-2xl mx-auto">
                Cảm ơn <strong class="text-blue-700"><?= htmlspecialchars($_SESSION['user_fullname'] ?? 'bạn') ?></strong> đã tin tưởng lựa chọn CloudJourney. <br>
                Hệ thống đã ghi nhận đơn đặt chỗ của bạn. Nhân viên CSKH sẽ liên hệ qua số điện thoại bạn cung cấp trong vòng 24h tới để xác nhận lịch trình.
            </p>
            
            <!-- Các nút điều hướng -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                <a href="/Project/public/index.php?url=tour/index" class="px-8 py-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-bold rounded-2xl transition-all flex items-center justify-center">
                    <i class="fas fa-search-location mr-2"></i> Khám phá thêm
                </a>
                <a href="/Project/public/index.php" class="px-8 py-4 bg-blue-800 hover:bg-blue-900 text-white font-bold rounded-2xl shadow-lg shadow-blue-800/30 transition-all flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i> Về Trang Chủ
                </a>
            </div>
            
        </div>
        
    </div>
</div>

<?php require_once '../app/views/inc/footer.php'; ?>