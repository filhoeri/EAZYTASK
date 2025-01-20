<?php
session_start();
include 'database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Menyimpan username ke session
        $_SESSION['username'] = $username;

        // Pengalihan ke dashboard setelah login berhasil
        header('Location: dashboard.php');
        exit();
    } else {
        $message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <?php if ($message): ?>
    <div class="notification">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </form>

    <script>
        // Hilangkan notifikasi setelah 3 detik
        setTimeout(() => {
            const notification = document.querySelector('.notification');
            if (notification) {
                notification.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html>
