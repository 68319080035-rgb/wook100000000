<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['cus_id']) || ($_SESSION['role'] ?? '') !== 'admin') exit("คุณไม่มีสิทธิ์เข้าถึง");

$user_id = $_GET['id'] ?? 0;
if(!$user_id) exit("ไม่พบผู้ใช้");

$sql = "DELETE FROM users WHERE cus_id=?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
if(mysqli_stmt_execute($stmt)){
    echo "ลบผู้ใช้สำเร็จ";
}else{
    echo "ลบไม่สำเร็จ: " . mysqli_stmt_error($stmt);
}
