<?php
session_start();

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // *** 1. เชื่อมต่อฐานข้อมูลและตรวจสอบผู้ใช้จริงในโค้ดของคุณ (จุดที่ต้องแก้ไข) ***
    // ในตัวอย่างนี้ เราจะใช้การจำลองข้อมูลผู้ดูแลระบบ
    
    // ข้อมูลจำลองสำหรับผู้ดูแลระบบ
    $admin_data = [
        'user' => 'admin_user',
        'pass' => 'admin_pass123', // ในโค้ดจริงต้องใช้ HASHED PASSWORD!
        'id' => 1,
        'name' => 'แอดมินใจดี',
        'role' => 'admin'
    ];
    
    // ตรวจสอบ Username และ Password
    if ($username === $admin_data['user'] && $password === $admin_data['pass']) {
        
        // *** 2. การกำหนด Session สำหรับผู้ดูแลระบบ (จุดสำคัญ) ***
        $_SESSION['cus_id'] = $admin_data['id'];
        $_SESSION['fullname'] = $admin_data['name'];
        $_SESSION['role'] = $admin_data['role']; // *** กำหนดเป็น 'admin' ที่นี่ ***

        // Redirect ไปยัง Admin Dashboard (index.php)
        header('Location: index.php');
        exit();
        
    } else {
        $error_message = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background: linear-gradient(135deg, #ffb6c1, #b3e5fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .login-card h3 {
            color: #ff6fb3;
            margin-bottom: 1.5rem;
            font-weight: 700; /* เพิ่มความเข้มเพื่อให้ดูชัดขึ้น */
        }

        .form-control {
            border-radius: 15px;
            border: 2px solid #ffd6e0;
            padding: 0.75rem 1.25rem;
        }

        .form-control:focus {
            border-color: #ff9ecd;
            box-shadow: 0 0 5px rgba(255, 111, 179, 0.3);
        }

        .btn-login {
            background: linear-gradient(90deg, #ff9ecd, #a5d8ff);
            border: none;
            color: white;
            font-weight: 500;
            border-radius: 20px;
            padding: 0.75rem 0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(255, 111, 179, 0.4);
        }

        .footer-links a {
            color: #ff6fb3;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .cute-bg {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.6;
            z-index: -1;
        }

        .bg1 { background-color: #ffc1e3; top: -30px; left: -40px; }
        .bg2 { background-color: #b3e5fc; bottom: -30px; right: -40px; }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="cute-bg bg1"></div>
        <div class="cute-bg bg2"></div>

        <h3><i class="bi bi-person-heart me-2"></i>เข้าสู่ระบบ</h3>

        <p class="text-center text-muted small mb-3">
            Admin User: **admin_user** | Password: **admin_pass123** (สำหรับทดสอบ)
        </p>
        
        <!-- แสดงข้อผิดพลาด -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Form: ลบ action="check_login.php" ออกเพื่อให้โพสต์กลับมาที่ login.php -->
        <form method="POST">
            <div class="mb-3 text-start">
                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="กรอกชื่อผู้ใช้" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่าน" required>
            </div>

            <button type="submit" class="btn btn-login w-100 mt-3">
                <i class="bi bi-door-open-fill me-1"></i> เข้าสู่ระบบ
            </button>
        </form>

        <div class="footer-links mt-4">
            <a href="#">ลืมรหัสผ่าน?</a> | 
            <a href="register_form.php">สมัครสมาชิก</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>