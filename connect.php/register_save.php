<?php
include('connect.php');

$username = $_POST['username'];
$phone = $_POST['phone'];
$fullname = $_POST['fullname'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// ตรวจสอบข้อมูลที่กรอก
if (empty($username) || empty($phone) || empty($fullname) || empty($password) || empty($confirm_password)) {
    echo "กรุณากรอกข้อมูลให้ครบ";
    exit();
}

if ($password != $confirm_password) {
    echo "รหัสผ่านไม่ตรงกัน";
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, fullname, phone) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $username, $hashed_password, $fullname, $phone);

if (mysqli_stmt_execute($stmt)) {
    echo " สมัครสมาชิกสำเร็จ! <a href='login.php'>ไปหน้าล็อกอิน</a>";
} else {
    echo " เกิดข้อผิดพลาดในการสมัครสมาชิก: " . mysqli_error($connect);
}
?>
