<?php
session_start();

// ตรวจสอบสิทธิ์ Admin
if (!isset($_SESSION['cus_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    echo "<div class='alert alert-danger'>คุณไม่มีสิทธิ์เข้าถึงหน้านี้</div>";
    exit();
}

$admin_name = htmlspecialchars($_SESSION['fullname'] ?? 'ผู้ดูแลระบบ');
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | ข้อมูลผู้ใช้งาน</title>
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
            <a class="btn btn-outline-light btn-sm" href="logout.php"><i class="bi bi-box-arrow-right"></i> ออก</a>
        </div>
    </div>
</nav>

<div class="admin-card">
    <h2 class="fw-bold"><i class="bi bi-person-lines-fill"></i> ข้อมูลผู้ใช้งาน</h2>
    <hr>
    <button class="btn btn-success btn-lg mb-4" id="fetchDataBtn">
        <i class="bi bi-database-check"></i> ดึงข้อมูลผู้ใช้
    </button>
    <div id="dataOutput">
        <div class="alert alert-info text-center" role="alert">คลิกปุ่มด้านบนเพื่อแสดงข้อมูล</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ดึงข้อมูลผู้ใช้
document.getElementById('fetchDataBtn').addEventListener('click', function() {
    const outputDiv = document.getElementById('dataOutput');
    const button = this;

    outputDiv.innerHTML = `<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">กำลังดึงข้อมูล...</p></div>`;
    button.disabled = true;

    fetch('fetch_user_data.php')
        .then(res => {
            if (res.status === 403) throw new Error('การเข้าถึงถูกปฏิเสธ (ไม่มีสิทธิ์ Admin)');
            if (!res.ok) throw new Error(`HTTP Error! Status: ${res.status}`);
            return res.text();
        })
        .then(data => { outputDiv.innerHTML = data.trim() || `<div class="alert alert-warning text-center">ไม่พบข้อมูล</div>`; })
        .catch(err => { outputDiv.innerHTML = `<div class="alert alert-danger text-center">**ข้อผิดพลาด** ${err.message}</div>`; })
        .finally(() => { button.disabled = false; });
});

// Delete user
document.addEventListener("click", function(e){
    const btn = e.target.closest(".deleteBtn");
    if(btn){
        let user_id = btn.dataset.id;
        if(!confirm("ต้องการลบผู้ใช้นี้จริงหรือไม่?")) return;
        fetch("user_delete.php?id=" + user_id)
            .then(res => res.text())
            .then(msg => {
                alert(msg);
                document.getElementById("fetchDataBtn").click();
            });
    }
});

// Edit user
document.addEventListener("click", function(e){
    const btn = e.target.closest(".editBtn");
    if(btn){
        let user_id = btn.dataset.id;
        window.location = "user_edit.php?id=" + user_id;
    }
});
</script>
</body>
</html>
