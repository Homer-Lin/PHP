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
</body>
</html>
