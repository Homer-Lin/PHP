<?php
session_start();

// 檢查是否登入
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: fail.php');
    exit();
}
$link = @mysqli_connect('localhost', 'root', '', 'homework');

if (!$link) {
    die("無法開啟資料庫<br>");
}

// 獲取用戶信息
$username = $_SESSION['username'];
$stmt = mysqli_prepare($link, "SELECT photo FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $profile_picture);
mysqli_stmt_fetch($stmt);

mysqli_stmt_close($stmt);
mysqli_close($link);
?>


<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* 調整圖片大小為原來的10% */
        img.profile-picture {
            width: 10%;
            height: auto; /* 保持高度自動調整 */
        }
    </style>
    <title>資管晚會報名表</title>
</head>
<body>
    <h1>資管晚會報名表</h1>
    <h1>歡迎, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <?php if (isset($profile_picture)): ?>
        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Profile Picture" class="profile-picture">
    <?php else: ?>
        <p>未找到用戶的照片</p>
    <?php endif; ?>
    <p><a href="logout.php">登出</a></p>
    <form action="result.php" method="POST">
        <label for="name">姓名：</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="student_id">學號：</label>
        <input type="text" id="student_id" name="student_id" required><br><br>

        <label for="phone">電話：</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="email">Email：</label>
        <input type="email" id="email" name="email" required><br><br>

        <label>性別：</label>
        <input type="radio" id="male" name="gender" value="男" required>
        <label for="male">男</label>
        <input type="radio" id="female" name="gender" value="女" required>
        <label for="female">女</label><br><br>

        <label for="grade">年級：</label>
        <select id="grade" name="grade" required>
            <option value="大一">大一</option>
            <option value="大二">大二</option>
            <option value="大三">大三</option>
            <option value="大四">大四</option>
        </select><br><br>

        <label for="feedback">其他意見回饋：</label><br>
        <textarea id="feedback" name="feedback" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="提交">
    </form>
</body>
</html>
