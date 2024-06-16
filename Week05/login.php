<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'admin' && $password == 'password') {
        $_SESSION['loggedin'] = true;
        header('Location: signup.php');
        exit();
    } else {
        $error = "帳號或密碼錯誤";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入</title>
</head>
<body>
    <h1>登入</h1>
    <form action="login.php" method="POST">
        <label for="username">用戶名：</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">密碼：</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="登入">
    </form>
    <?php
    if (isset($error)) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    ?>
</body>
</html>
