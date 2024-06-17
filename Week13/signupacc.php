<?php
session_start();

// 顯示所有錯誤
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 檢查是否提交表單
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $photo = $_FILES['photo'];

    // 簡單的資料驗證
    if ($password != $confirm_password) {
        $error = "密碼與確認密碼不一致";
    } else {


        // 上傳照片處理
        $target_dir = "uploads/";
        // 確保上傳目錄存在
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($photo["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // 檢查是否為圖片檔案
        $check = getimagesize($photo["tmp_name"]);
        if ($check !== false) {
            echo "檔案是圖片 - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            $error = "文件不是圖片.";
            if (file_exists($target_file)) 
                $error = "對不起，文件已經存在.";
            else if ($photo["size"] > 500000)
                $error = "對不起，文件太大.";
            else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif")
                $error = "對不起，只允許 JPG, JPEG, PNG & GIF 格式的文件.";
            $uploadOk = 0;
        }

        // 檢查是否有錯誤
        if ($uploadOk == 0) {
            $error = "對不起，您的文件未被上傳.";
        } else {
            if (move_uploaded_file($photo["tmp_name"], $target_file)) {
                echo "文件 " . basename($photo["name"]) . " 已成功上傳.<br>";
                
                // 連接資料庫
                $link = @mysqli_connect("localhost", "root", "", "homework");

                // 檢查連接
                if (!$link) {
                    die("連接失敗: " . mysqli_connect_error());
                }

                // 檢查用戶名是否已存在
                $stmt = mysqli_prepare($link, "SELECT * FROM users WHERE username = ?");
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $error = "用戶名已存在，請選擇其他用戶名.";
                } else {
                    // 準備和執行插入查詢
                    $stmt = mysqli_prepare($link, "INSERT INTO users (username, password, photo) VALUES (?, ?, ?)");
                    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $target_file);

                    if (mysqli_stmt_execute($stmt)) {
                        $success = "註冊成功";
                        header("Location:login.php");
                    } else {
                        $error = "註冊失敗: " . mysqli_error($link);
                    }
                }

                mysqli_stmt_close($stmt);
                mysqli_close($link);
            } else {
                $error = "對不起，上傳文件時出錯.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊</title>
</head>
<body>
    <h1>註冊</h1>
    <form action="signupacc.php" method="POST" enctype="multipart/form-data">
        <label for="username">用戶名：</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">密碼：</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">確認密碼：</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <label for="photo">上傳照片：</label>
        <input type="file" id="photo" name="photo" required><br><br>
        
        <input type="submit" value="註冊">
    </form>
    <?php
    if (isset($error)) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    if (isset($success)) {
        echo '<p style="color:green;">' . htmlspecialchars($success) . '</p>';
    }
    ?>
</body>
</html>
