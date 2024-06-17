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

// 查詢資料
$sql = "SELECT * FROM registrations WHERE id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "無此資料";
    exit();
}

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $grade = $_POST['grade'];
    $feedback = $_POST['feedback'];

    $sql = "UPDATE registrations SET name=?, student_id=?, phone=?, email=?, gender=?, grade=?, feedback=? WHERE id=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'sssssssi', $name, $student_id, $phone, $email, $gender, $grade, $feedback, $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "更新成功";
    } else {
        echo "更新失敗: " . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

    header('Location: showall.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改資料</title>
</head>
<body>
    <h1>修改資料</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="POST">
        <label for="name">姓名：</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>
        
        <label for="student_id">學號：</label>
        <input type="text" id="student_id" name="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>" required><br><br>
        
        <label for="phone">電話：</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required><br><br>
        
        <label for="email">Email：</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br><br>
        
        <label for="gender">性別：</label>
        <input type="radio" id="male" name="gender" value="男" <?php if ($row['gender'] == '男') echo 'checked'; ?>> 男
        <input type="radio" id="female" name="gender" value="女" <?php if ($row['gender'] == '女') echo 'checked'; ?>> 女<br><br>
        
        <label for="grade">年級：</label>
        <select id="grade" name="grade">
            <option value="大一" <?php if ($row['grade'] == '大一') echo 'selected'; ?>>大一</option>
            <option value="大二" <?php if ($row['grade'] == '大二') echo 'selected'; ?>>大二</option>
            <option value="大三" <?php if ($row['grade'] == '大三') echo 'selected'; ?>>大三</option>
            <option value="大四" <?php if ($row['grade'] == '大四') echo 'selected'; ?>>大四</option>
        </select><br><br>
        
        <label for="feedback">意見回饋：</label>
        <textarea id="feedback" name="feedback"><?php echo htmlspecialchars($row['feedback']); ?></textarea><br><br>
        
        <input type="submit" value="修改">
    </form>
</body>
</html>