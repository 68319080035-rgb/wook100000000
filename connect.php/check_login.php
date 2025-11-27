<?php
session_start();
// ตรวจสอบให้แน่ใจว่า 'connect.php' ใช้ชื่อตัวแปรเชื่อมต่อที่ถูกต้อง เช่น $connect
include('connect.php');

// ตรวจสอบว่ามีการส่งข้อมูล POST มาครบถ้วนหรือไม่
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "<script>alert('ข้อมูล Username หรือ Password ไม่ครบถ้วน'); window.history.back();</script>";
    exit();
}

// ดึงข้อมูลที่ส่งมาจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// 1. เตรียมคำสั่ง SQL (เพิ่มคอลัมน์ status)
// ต้องตรวจสอบว่าคอลัมน์ status ในตาราง users มีชื่อตรงกับโค้ดนี้
$sql = "SELECT cus_id, fullname, phone, username, password, status FROM users WHERE username = ?";
$stmt = mysqli_prepare($connect, $sql);

// ตรวจสอบว่าเตรียมคำสั่งสำเร็จหรือไม่
if ($stmt === false) {
    echo "<script>alert('เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($connect) . "'); window.history.back();</script>";
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 2. ตรวจสอบว่าพบชื่อผู้ใช้หรือไม่
if ($row = mysqli_fetch_assoc($result)) {
    
    // 3. ตรวจสอบรหัสผ่านโดยใช้ password_verify
    if (password_verify($password, $row['password'])) {
        
        // **A. ตั้งค่า Session (รวม status)**
        $_SESSION['cus_id'] = $row['cus_id'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['phone'] = $row['phone'];
        $_SESSION['username'] = $row['username']; 
        $_SESSION['status'] = $row['status']; // <<< เก็บสถานะไว้ใน Session

        // ปิด Statement
        mysqli_stmt_close($stmt);
        
        // **B. ตรวจสอบสถานะและเปลี่ยนเส้นทาง**
        $redirect_page = '';
        
        if ($row['status'] == 'admin') {
            $redirect_page = 'index.php'; // หรือหน้าสำหรับ Admin
        } else {
            $redirect_page = 'profile.php'; // สำหรับ User ทั่วไป
        }

        // แสดง Alert และเปลี่ยนเส้นทาง
        echo "<script>";
        echo "alert('ล็อกอินสำเร็จ! ยินดีต้อนรับ');";
        echo "window.location.href = '" . $redirect_page . "';"; // เปลี่ยนเส้นทางตามสถานะ
        echo "</script>";
        exit();
        
    } else {
        // รหัสผ่านไม่ถูกต้อง
        mysqli_stmt_close($stmt);
        echo "<script>alert('รหัสผ่านไม่ถูกต้อง'); window.history.back();</script>";
    }
} else {
    // ไม่พบชื่อผู้ใช้
    mysqli_stmt_close($stmt);
    echo "<script>alert('ไม่พบชื่อผู้ใช้นี้ในระบบ'); window.history.back();</script>";
}
?>