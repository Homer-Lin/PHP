<?php
session_start();

// 檢查是否登入
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != true) {
    header('Location: fail.php');
    exit();
}

// 連接資料庫
$link = @mysqli_connect("localhost", "root", "", "homework");

// 檢查連接
if (!$link) {
    die("連接失敗: " . mysqli_connect_error());
}

// 查詢資料
$sql = "SELECT * FROM registrations";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顯示所有資料</title>
</head>
<body>
    <h1>顯示所有資料</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>學號</th>
            <th>電話</th>
            <th>Email</th>
            <th>性別</th>
            <th>年級</th>
            <th>意見回饋</th>
            <th>操作</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
                echo "<td>" . htmlspecialchars($row['feedback']) . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $row['id'] . "'>修改</a> | ";
                echo "<a href='delete.php?id=" . $row['id'] . "'>刪除</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>無資料</td></tr>";
        }
        mysqli_close($link);
        ?>
    </table>
    <a href="logout.php">登出</a>
</body>
</html>