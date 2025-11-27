<?php
session_start();
if (!isset($_SESSION['cus_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อน'); window.location='login.php';</script>";
    exit();
}

$fullname = htmlspecialchars($_SESSION['fullname'] ?? 'ชื่อผู้ใช้ ไม่ระบุ');
$username = htmlspecialchars($_SESSION['username'] ?? 'username_not_found');
$phone = htmlspecialchars($_SESSION['phone'] ?? '0XX-XXX-XXXX');
$bio = htmlspecialchars($_SESSION['bio'] ?? 'ยินดีที่ได้รู้จักค่ะ! 🌟');
$job = htmlspecialchars($_SESSION['job'] ?? 'ผู้ใช้งานทั่วไป');
$education = htmlspecialchars($_SESSION['education'] ?? 'ไม่ได้ระบุ');
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fullname; ?> | โปรไฟล์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@400;600&family=Noto+Sans+Thai:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Noto Sans Thai', sans-serif;
            background-color: #f0f2f5;
            padding-top: 56px; 
            margin: 0;
            min-height: 100vh;
        }
        .navbar-custom {
            background-color: #1877f2;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff !important;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .profile-container {
            max-width: 600px;
            margin: 20px auto; 
            background-color: #fff;
            border-radius: 8px; /* เพิ่มขอบมนเล็กน้อย */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .cover-photo {
            width: 100%;
            height: 200px;
            background: url('https://picsum.photos/600/200?random=1') no-repeat center center/cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .profile-header {
            padding: 0 20px 20px;
            margin-top: -60px;
        }

        .profile-avatar-wrapper {
            display: inline-block;
            border-radius: 50%;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0 0 0 1px #fff, 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: url('https://picsum.photos/120/120?random=2') no-repeat center center/cover;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #050505;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .bio-text {
            color: #606770;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .profile-info {
            border-top: 1px solid #ced0d4;
            padding-top: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #050505;
            font-size: 15px;
        }

        .info-item i {
            margin-right: 10px;
            color: #606770;
            font-size: 18px;
        }
        
        .btn-action {
            width: 100%;
            padding: 10px 0;
            margin-bottom: 10px;
            font-weight: 500;
            border-radius: 6px;
        }

        .btn-edit {
            background-color: #e4e6eb;
            color: #050505;
            border: none;
        }

        .btn-logout {
            background-color: #e7f3ff;
            color: #1877f2;
            border: none;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> **ชื่อเว็บไซต์**
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="profile.php"><i class="bi bi-person-circle"></i> โปรไฟล์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="bi bi-bag-fill"></i> ตะกร้าสินค้า</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                     <li class="nav-item d-lg-none">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> ออกจากระบบ</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> <?php echo $fullname; ?> (ออกจากระบบ)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="profile-container">
        <div class="cover-photo"></div>

        <div class="profile-header">
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar"></div>
            </div>

            <h1><?php echo $fullname; ?></h1>
            <p class="bio-text"><?php echo $bio; ?></p>
            
            <a href="#" class="btn btn-action btn-primary btn-edit">แก้ไขโปรไฟล์</a>
            <a href="logout.php" class="btn btn-action btn-logout d-lg-none">ออกจากระบบ</a> <div class="profile-info">
                <div class="info-item"><i class="bi bi-tag-fill"></i> ชื่อผู้ใช้: **<?php echo $username; ?>**</div>
                <div class="info-item"><i class="bi bi-telephone-fill"></i> เบอร์โทร: **<?php echo $phone; ?>**</div>
                <div class="info-item"><i class="bi bi-briefcase-fill"></i> ทำงานที่: **<?php echo $job; ?>**</div>
                <div class="info-item"><i class="bi bi-mortarboard-fill"></i> ศึกษาที่: **<?php echo $education; ?>**</div>
            </div>
        </div>
        
        <div class="p-3 text-center" style="color: #606770; border-top: 1px solid #ced0d4;">
            <p>... ส่วนสำหรับแสดงโพสต์ หรือเมนูอื่นๆ ...</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>