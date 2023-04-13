<?php
$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $file_name = basename($file['name']);
        $target_file = $upload_dir . $file_name;
        $upload_ok = 1;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // 文件类型检查
        $allowed_types = ['php','exe'];
        if (in_array($file_type, $allowed_types)) {
            $upload_ok = 0;
            echo "不允许的文件类型";
        }

        // 检查是否有同名文件
        if (file_exists($target_file)) {
            $upload_ok = 0;
            echo "文件已存在";
        }

        // // 检查文件大小
        // if ($file['size'] > 2500000000) { // 限制文件大小为2.5GB
        // $upload_ok = 0;
        // echo "文件过大";
        // }
            // 尝试上传文件
    if ($upload_ok == 1) {
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            echo "文件 " . htmlspecialchars($file_name) . " 上传成功";
        } else {
            echo "文件上传失败";
        }
    }
}
} else {
http_response_code(405);
echo "请求方法不允许";
}
?>
