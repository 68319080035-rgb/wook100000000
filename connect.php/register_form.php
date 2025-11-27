<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Mali:wght@400;600&display=swap');

    body {
      font-family: 'Mali', cursive;
      background: linear-gradient(135deg, #ffe6f0, #ffeefc, #fff6f6);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: #fff;
      border-radius: 25px;
      box-shadow: 0 6px 15px rgba(255, 192, 203, 0.4);
      padding: 40px;
      width: 320px;
      text-align: center;
    }

    h2 {
      color: #ff6fa8;
      margin-bottom: 25px;
    }

    label {
      color: #ff80b5;
      font-weight: 600;
      display: block;
      text-align: left;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 2px solid #ffc1d6;
      border-radius: 15px;
      outline: none;
      transition: 0.3s;
      font-size: 15px;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #ff85b8;
      box-shadow: 0 0 5px #ffb6d9;
    }

    button {
      background-color: #ff9ccf;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
      transition: 0.3s;
    }

    button:hover {
      background-color: #ff6fa8;
      transform: scale(1.05);
    }

    .form-container:hover {
      transform: translateY(-3px);
      transition: 0.4s;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>ฟอร์มสมัครสมาชิก 💕</h2>
    <form method="POST" action="register_save.php">
      <label>Username:</label>
      <input type="text" name="username" required><br><br>

      <label>Phone:</label>
      <input type="text" name="phone" required><br><br>

      <label>Full Name:</label>
      <input type="text" name="fullname" required><br><br>

      <label>Password:</label>
      <input type="password" name="password" required><br><br>

      <label>Confirm Password:</label>
      <input type="password" name="confirm_password" required><br><br>

      <button type="submit">สมัครสมาชิก 💖</button>
    </form>
  </div>
</body>
</html>
