<?php
session_start();

// 檢查是否登入
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header('Location: fail.php');
    exit();
}

// 顯示所有錯誤
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 連接資料庫
$link = @mysqli_connect("localhost", "root", "", "homework");

// 檢查連接
if (!$link) {
    die("連接失敗: " . mysqli_connect_error());
}

// 獲取ID
$id = $_GET['id'];

// 刪除資料
$sql = "DELETE FROM registrations WHERE id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
if (mysqli_stmt_execute($stmt)) {
    echo "刪除成功";
} else {
    echo "刪除失敗: " . mysqli_error($link);
}

mysqli_stmt_close($stmt);
mysqli_close($link);

header('Location: showall.php');
exit();
?>