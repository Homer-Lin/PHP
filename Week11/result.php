<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: fail.php');
    exit();
}
// 連接資料庫
$link = @mysqli_connect('localhost', 'root', '', 'homework'); 

// 檢查連接
if (!$link) {
    die("連接失敗: " . mysqli_connect_error());
}

// 準備和綁定
$stmt = mysqli_prepare($link, "INSERT INTO registrations (name, student_id, phone, email, gender, grade, feedback) VALUES (?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssssss", $name, $student_id, $phone, $email, $gender, $grade, $feedback);

$name = $_POST['name'];
$student_id = $_POST['student_id'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$grade = $_POST['grade'];
$feedback = $_POST['feedback'];

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>報名結果</title>
</head>
<body>
    <h1>報名結果</h1>
    <p>姓名：<?php echo $_POST['name']; ?></p>
    <p>學號：<?php echo $_POST['student_id']; ?></p>
    <p>電話：<?php echo $_POST['phone']; ?></p>
    <p>Email：<?php echo $_POST['email']; ?></p>
    <p>性別：<?php echo $_POST['gender']; ?></p>
    <p>年級：<?php echo $_POST['grade']; ?></p>
    <p>其他意見回饋：<?php echo nl2br($_POST['feedback']); ?></p>

    <a href="logout.php">登出</a>
    <br><br>
    <a href="showall.php">顯示</a>
</body>
</html>
