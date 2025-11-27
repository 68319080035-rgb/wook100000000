<?php
session_start();
if (!isset($_SESSION['cus_id']) || ($_SESSION['role'] ?? 'user') !== 'admin') {
    echo "<div class='alert alert-danger'>คุณไม่มีสิทธิ์เข้าถึงหน้าผู้ดูแลระบบ</div>";
    exit();
}

$admin_name = htmlspecialchars($_SESSION['fullname'] ?? 'ผู้ดูแลระบบ');
$current_role = htmlspecialchars($_SESSION['role'] ?? 'NOT SET'); 
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body { font-family: 'Noto Sans Thai', sans-serif; background-color: #f0f2f5; padding-top: 56px; }
.navbar-custom { background-color: #1877f2; }
.admin-card { max-width: 900px; margin: 20px auto; background-color: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); padding: 20px; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
<div class="container-fluid">
<a class="navbar-brand fw-bold" href="#"><i class="bi bi-shield-lock-fill"></i> ADMIN PANEL</a>
<div class="d-flex align-items-center">
<span class="navbar-text text-white me-3">สวัสดี, <?php echo $admin_name; ?></span>
<span class="badge bg-warning text-dark me-3">ROLE: <?php echo $current_role; ?></span>
<a class="btn btn-outline-light btn-sm" href="logout.php"><i class="bi bi-box-arrow-right"></i> ออก</a>
</div>
</div>
</nav>

<div class="admin-card">
<h2 class="fw-bold"><i class="bi bi-person-lines-fill"></i> ข้อมูลผู้ใช้งาน</h2>
<hr>

<!-- ปุ่มกรองสถานะ -->
<div class="mb-3">
    <button class="btn btn-success me-2 filterBtn" data-status="user"><i class="bi bi-person"></i> User</button>
    <button class="btn btn-danger me-2 filterBtn" data-status="admin"><i class="bi bi-shield-lock-fill"></i> Admin</button>
    <button class="btn btn-secondary filterBtn" data-status="all"><i class="bi bi-list-ul"></i> All</button>
</div>
<a href="register_form.php" class="btn btn-primary">
    สมัครสมาชิกใหม่
</a>
<!-- พื้นที่แสดงตาราง -->
<div id="dataOutput">
<div class="alert alert-info text-center">คลิกปุ่มด้านบนเพื่อแสดงข้อมูล</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ฟังก์ชันดึงข้อมูล
function fetchUsers(status = 'all') {
    const outputDiv = document.getElementById('dataOutput');
    outputDiv.innerHTML = `<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">กำลังดึงข้อมูล...</p></div>`;

    fetch('fetch_user_data.php?status=' + status)
        .then(res => {
            if (res.status === 403) throw new Error('การเข้าถึงถูกปฏิเสธ (ไม่มีสิทธิ์ Admin)');
            if (!res.ok) throw new Error(`HTTP Error! Status: ${res.status}`);
            return res.text();
        })
        .then(data => { outputDiv.innerHTML = data.trim() || `<div class="alert alert-warning text-center">ไม่พบข้อมูล</div>`; })
        .catch(err => { outputDiv.innerHTML = `<div class="alert alert-danger text-center">**ข้อผิดพลาด** ${err.message}</div>`; });
}

// ปุ่มกรอง
document.querySelectorAll('.filterBtn').forEach(btn => {
    btn.addEventListener('click', () => fetchUsers(btn.dataset.status));
});

// ปุ่ม Edit/Delete
document.addEventListener("click", function(e){
    const delBtn = e.target.closest(".deleteBtn");
    const editBtn = e.target.closest(".editBtn");

    if(delBtn){
        if(!confirm("ต้องการลบผู้ใช้นี้จริงหรือไม่?")) return;
        fetch("user_delete.php?id=" + delBtn.dataset.id)
            .then(res => res.text())
            .then(msg => { alert(msg); fetchUsers('all'); });
    }

    if(editBtn){
        window.location = "user_edit.php?id=" + editBtn.dataset.id;
    }
});
</script>
</body>
</html>
