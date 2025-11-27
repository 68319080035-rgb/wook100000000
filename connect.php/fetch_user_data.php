<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['cus_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403); 
    exit("Access Denied. Admin privileges required.");
}

$sql = "SELECT cus_id, username, fullname, phone, status FROM users";
$result = mysqli_query($connect, $sql);

$html = '<div class="table-responsive"><table class="table table-striped table-hover table-bordered caption-top">';
$html .= '<caption>ข้อมูลผู้ใช้งาน</caption>';
$html .= '<thead><tr><th>ID</th><th>Username</th><th>ชื่อเต็ม</th><th>เบอร์โทร</th><th>Status</th><th>Action</th></tr></thead><tbody>';

if(mysqli_num_rows($result) == 0){
    $html .= '<tr><td colspan="6" class="text-center text-muted">ไม่พบผู้ใช้งาน</td></tr>';
} else {
    while($row = mysqli_fetch_assoc($result)){
        $html .= '<tr>';
        $html .= '<td>'.htmlspecialchars($row['cus_id']).'</td>';
        $html .= '<td>'.htmlspecialchars($row['username']).'</td>';
        $html .= '<td>'.htmlspecialchars($row['fullname']).'</td>';
        $html .= '<td>'.htmlspecialchars($row['phone']).'</td>';
        $html .= '<td>'.htmlspecialchars($row['status']).'</td>';
        $html .= '<td>
                    <button class="btn btn-sm btn-primary editBtn" data-id="'.$row['cus_id'].'">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row['cus_id'].'">Delete</button>
                  </td>';
        $html .= '</tr>';
    }
}
$html .= '</tbody></table></div>';

echo $html;
