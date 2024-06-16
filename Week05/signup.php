<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: fail.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資管晚會報名表</title>
</head>
<body>
    <h1>資管晚會報名表</h1>
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
