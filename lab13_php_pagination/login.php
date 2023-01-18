<?php

session_start();

$title = 'Data Barang';
include_once 'koneksi.php';

if (isset($_POST['submit']))
{
    $user = $_POST['user'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE username = '{$user}'
    AND password = md5('{$password}') ";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) != 0)
    {
        $_SESSION['isLogin'] = true;
        $_SESSION['user'] = mysqli_fetch_array($result);
        
        header('location: index.php');
    } else
    $errorMsg = "<p style=\"color:red;\">Gagal Login, Silakan Ulangi Lagi.</p>";
}


if (isset($errorMsg)) echo $errorMsg;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Data Barang</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="container">
        <header>
            <h1>Membuat Database Sederhana</h1>
        </header>
        <nav>
            <a href="index.php">Home</a>
            <a href="login.php" li class=active>Login</a>
        </nav>
<br>
<h2 class="tekslogin">Login</h2><br>
<form method="post">
    <div class="input">
        <label>Username</label>
        <input type="text" name="user" />
    </div>
    <div class="input">
        <label>Password</label>
        <input type="password" name="password" />
    </div>
    <div class="submit">
        <input type="submit" name="submit" value="Login" />
    </div>
    <br><br>
</form>
<footer>
    <p>&copy; 2023, Teknik Informatika, Universitas Pelita Bangsa</p>
</footer>
<?php
?>
</body>
</html>