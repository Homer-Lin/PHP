<?php
session_start();
session_unset();
session_destroy();
header('Location: login.php');

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登出</title>
</head>
<body>
    <h1>您已成功登出</h1>
    <a href="login.php">返回登入頁面</a>
</body>
</html>
