<!-- Tệp: app/views/inc/header.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CloudJourney - Trải nghiệm không giới hạn</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Nhúng Alpine.js vào Header để xài chung cho Dropdown và toàn bộ trang -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        /* Ẩn phần tử trước khi Alpine load xong tránh giật lag */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8f9fa] text-gray-800 antialiased flex flex-col min-h-screen">

    <?php
    // 1. XỬ LÝ URL
    $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
    $urlParts = explode('/', $url);
    $currentController = isset($urlParts[0]) && $urlParts[0] != '' ? $urlParts[0] : 'home';
    $currentAction = isset($urlParts[1]) && $urlParts[1] != '' ? $urlParts[1] : 'index';

    // 2. LẤY ID TOUR ĐỂ LÀM LINK ĐIỀU HƯỚNG TRỞ LẠI
    // (Lấy từ biến $data truyền vào view, hoặc từ $_POST nếu đang ở trang checkout)
    $tourIdForLink = null;
    if (isset($data['tour']['id'])) {
        $tourIdForLink = $data['tour']['id'];
    } elseif (isset($_POST['tour_id'])) {
        $tourIdForLink = $_POST['tour_id'];
    } elseif (isset($urlParts[2])) {
        $tourIdForLink = $urlParts[2]; // Lấy từ URL nếu có (VD: tour/detail/15)
    }

    // 3. LOGIC ĐỔI MÀU & TRẠNG THÁI TAB NAVIGATION
    $activeTab = 'khampha'; 
    if ($currentController === 'home' || ($currentController === 'tour' && $currentAction === 'index')) {
        $activeTab = 'khampha';
    } elseif ($currentController === 'tour' && $currentAction === 'detail') {
        $activeTab = 'diemden';
    } elseif ($currentController === 'tour' && in_array($currentAction, ['checkout', 'processBooking', 'success'])) {
        $activeTab = 'hanhtrinh';
    }

    // 4. LẤY TỪ KHÓA TÌM KIẾM
    $currentKeyword = isset($keyword) ? $keyword : (isset($_GET['keyword']) ? $_GET['keyword'] : '');
    ?>

    <header class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/Project/public/index.php" class="text-2xl font-bold text-blue-700 tracking-tight">CloudJourney</a>
                </div>

                <!-- Navigation Tabs (Đã gắn Logic chuyển hướng) -->
                <nav class="hidden md:flex space-x-8 h-full">
                    <!-- KHÁM PHÁ: Luôn trỏ về trang danh sách tour -->
                    <a href="/Project/public/index.php?url=tour/index" class="flex items-center text-sm font-semibold transition-colors h-full border-b-2 <?php echo ($activeTab === 'khampha') ? 'text-blue-700 border-blue-700' : 'text-gray-500 border-transparent hover:text-blue-700'; ?>">
                        Khám phá
                    </a>
                    
                    <!-- ĐIỂM ĐẾN: Nếu có ID thì trỏ về Detail đó, không thì nằm im -->
                    <a href="<?= $tourIdForLink ? '/Project/public/index.php?url=tour/detail/' . $tourIdForLink : '#' ?>" class="flex items-center text-sm font-semibold transition-colors h-full border-b-2 <?php echo ($activeTab === 'diemden') ? 'text-blue-700 border-blue-700' : 'text-gray-500 border-transparent hover:text-blue-700'; ?>">
                        Điểm đến
                    </a>
                    
                    <!-- HÀNH TRÌNH -->
                    <a href="#" class="flex items-center text-sm font-semibold transition-colors h-full border-b-2 <?php echo ($activeTab === 'hanhtrinh') ? 'text-blue-700 border-blue-700' : 'text-gray-500 border-transparent hover:text-blue-700'; ?>">
                        Hành trình
                    </a>
                    
                    <a href="#" class="flex items-center text-sm font-semibold text-gray-500 border-b-2 border-transparent hover:text-blue-700 transition-colors h-full">
                        Liên hệ
                    </a>
                </nav>

                <!-- Right Section (Search & Buttons) -->
                <div class="flex items-center space-x-6">
                    
                    <?php if ($currentController !== 'home'): ?>
                    <div class="hidden lg:block relative group">
                        <form action="/Project/public/index.php" method="GET" class="flex items-center">
                            <input type="hidden" name="url" value="tour/index">
                            <div class="relative flex items-center text-gray-400 focus-within:text-blue-600">
                                <i class="fas fa-search absolute ml-4 pointer-events-none text-sm"></i>
                                <input type="text" name="keyword" value="<?= htmlspecialchars($currentKeyword) ?>" placeholder="Tìm điểm đến..." autocomplete="off" 
                                    class="w-56 pr-4 pl-10 py-2.5 font-medium text-gray-800 rounded-full bg-gray-50 border border-gray-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:bg-white focus:outline-none transition-all text-sm shadow-inner">
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>

                    <button class="text-gray-500 hover:text-blue-700 flex items-center gap-1 text-sm font-medium">
                        <i class="fas fa-globe text-lg"></i> VN(VND)
                    </button>
                    
                    <!-- XỬ LÝ TÀI KHOẢN: Nút Đăng Nhập HOẶC Avatar Dropdown -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        
                        <!-- Alpine.js Dropdown Component -->
                        <div x-data="{ open: false }" class="relative">
                            <!-- Nút Avatar -->
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 text-white flex items-center justify-center font-bold shadow-md">
                                    <!-- Lấy chữ cái đầu của Tên -->
                                    <?= mb_substr(htmlspecialchars($_SESSION['user_fullname']), 0, 1, "UTF-8") ?>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>

                            <!-- Menu thả xuống -->
                            <div x-show="open" x-transition x-cloak class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                                <!-- Chào mừng -->
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Xin chào,</p>
                                    <p class="text-sm font-bold text-gray-800 truncate"><?= htmlspecialchars($_SESSION['user_fullname']) ?></p>
                                </div>
                                
                                <div class="py-2">
                                    <!-- NẾU LÀ ADMIN -> HIỆN NÚT VÀO DASHBOARD -->
                                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                        <a href="/Project/public/index.php?url=admin/index" class="flex items-center px-4 py-2.5 text-sm font-bold text-blue-700 hover:bg-blue-50 transition">
                                            <i class="fas fa-shield-alt w-5 text-center mr-2"></i> Trang Quản Trị
                                        </a>
                                        <hr class="my-1 border-gray-100">
                                    <?php endif; ?>
                                    
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                                        <i class="far fa-user-circle w-5 text-center mr-2 text-gray-400"></i> Hồ sơ của tôi
                                    </a>
                                    <a href="/Project/public/index.php?url=user/logout" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition font-medium">
                                        <i class="fas fa-sign-out-alt w-5 text-center mr-2 text-red-400"></i> Đăng xuất
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Nút Đăng nhập cho khách -->
                        <a href="/Project/public/index.php?url=user/login" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5">
                            Đăng nhập
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">