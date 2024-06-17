<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 獲取使用者角色

    //連接資料庫
    $link = @mysqli_connect('localhost', 'root', '', 'homework'); 

    if (!$link) {
        die("無法開啟資料庫<br>");
    } else {
        echo "成功開啟資料庫<br>";
    }
    
    //SQL指令
    $SQL = "SELECT * FROM users";
    //資料表查詢
    $result = mysqli_query($link, $SQL);

    while ($row = mysqli_fetch_assoc($result)) {
        if($row["username"] == $username && $row["password"] == $password && $row["role"] == $role ){
            if($row["role"] == "user"){
                $_SESSION["loggedin"] = true;
                header("Location: signup.php");
                break;}
            else{
                $_SESSION["admin"] = true ;
                header("Location: showall.php");
                break;
            } 
    }else {
        $error = "輸入錯誤";
    }

    mysqli_close($link);
}}
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

        <label for="role">選擇登入身分：</label>
        <select id="role" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>
        
        <input type="submit" value="登入">
    </form>
    <?php
    if (isset($error)) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    ?>
</body>
</html>