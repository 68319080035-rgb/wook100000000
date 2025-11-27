<?php
$connect = mysqli_connect('localhost', 'root', '', 'wee');
if (!$connect) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . mysqli_connect_error());
}
mysqli_set_charset($connect, "utf8mb4");
?>
