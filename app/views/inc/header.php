<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Đặt Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="/Project/public/">✈️ BookingTour</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/Project/public/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Project/public/#danh-sach-tour">Danh sách Tour</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                       <a href="/Project/public/user/profile" class="d-flex align-items-center text-light fw-bold me-3 text-decoration-none">
                            <?php 
                                $avatar = $_SESSION['user_avatar'] ??'';
                                if ($avatar == 'default_avatar.jpg' || empty($avatar)) {
                                    $img_src = "https://ui-avatars.com/api/?name=" . urlencode($_SESSION['user_fullname']) . "&background=random";
                                } else {
                                    $img_src = "/Project/public/images/" . $avatar;
                                }
                            ?>
                            <img src="<?php echo $img_src; ?>" alt="Avatar" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover; border: 2px solid white;">
                            <span><?php echo $_SESSION['user_fullname']; ?></span>
                        </a>
                        <a href="/Project/public/user/logout" class="btn btn-danger btn-sm fw-bold">Đăng xuất</a>
                        
                    <?php else: ?>
                        <a href="/Project/public/user/login" class="btn btn-outline-light me-2">Đăng nhập</a>
                        <a href="/Project/public/user/register" class="btn btn-warning fw-bold text-dark">Đăng ký</a>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show text-center shadow-sm fw-bold">
                <?php echo $_SESSION['flash_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php 
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        ?>
    <?php endif; ?>

    <main class="container my-5 flex-grow-1">
