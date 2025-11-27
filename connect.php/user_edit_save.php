<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['cus_id']) || ($_SESSION['role'] ?? '') !== 'admin') exit("คุณไม่มีสิทธิ์เข้าถึง");

$cus_id = $_POST['cus_id'] ?? 0;
$username = $_POST['username'] ?? '';
$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';
$status = $_POST['status'] ?? 'user';

if(!$cus_id || !$username || !$fullname) exit("ข้อมูลไม่ครบถ้วน");

$sql = "UPDATE users SET username=?, fullname=?, phone=?, status=? WHERE cus_id=?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "ssssi", $username, $fullname, $phone, $status, $cus_id);
if(mysqli_stmt_execute($stmt)){
    mysqli_stmt_close($stmt);
    header("Location: index.php");
    exit();
}else{
    exit("แก้ไขไม่สำเร็จ: " . mysqli_stmt_error($stmt));
}
