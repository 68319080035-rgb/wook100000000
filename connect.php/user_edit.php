<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['cus_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    exit("คุณไม่มีสิทธิ์เข้าถึงหน้านี้");
}

$user_id = $_GET['id'] ?? 0;
if(!$user_id) exit("ไม่พบผู้ใช้");

$sql = "SELECT username, fullname, phone, status FROM users WHERE cus_id=?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if(!$user) exit("ไม่พบผู้ใช้ที่ต้องการแก้ไข");
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>แก้ไขผู้ใช้ | Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="padding:20px; background-color:#f0f2f5;">
<div class="container">
    <div class="card mx-auto" style="max-width:600px;">
        <div class="card-header bg-primary text-white">
            แก้ไขผู้ใช้: <?php echo htmlspecialchars($user['username']); ?>
        </div>
        <div class="card-body">
            <form action="user_edit_save.php" method="POST">
                <input type="hidden" name="cus_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label>ชื่อเต็ม</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                </div>
                <div class="mb-3">
                    <label>เบอร์โทร</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="user" <?php echo ($user['status']=='user')?'selected':''; ?>>User</option>
                        <option value="admin" <?php echo ($user['status']=='admin')?'selected':''; ?>>Admin</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">กลับ</a>
                    <button type="submit" class="btn btn-success">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
