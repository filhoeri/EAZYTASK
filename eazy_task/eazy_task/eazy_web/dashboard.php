<?php
session_start();
include 'database.php';

// Cek jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Menambahkan tugas baru ke database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = $_POST['task'];
    $deadline = $_POST['deadline'];
    $priority = $_POST['priority'];
    $status = 'Belum Dikerjakan'; // Status default saat tugas ditambahkan
    $username = $_SESSION['username'];

    // Memastikan tugas tidak kosong
    if (!empty($task)) {
        $sql = "INSERT INTO tasks (username, task, deadline, priority, status) 
                VALUES ('$username', '$task', '$deadline', '$priority', '$status')";
        if ($conn->query($sql) === TRUE) {
            // Redirect untuk menghindari pengiriman form ulang
            header('Location: dashboard.php');
            exit();
        } else {
            die("Error: " . $conn->error);
        }
    }
}

// Memperbarui status tugas jika status diubah
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status_update']) && isset($_POST['task_id'])) {
    $status = $_POST['status_update'];
    $task_id = $_POST['task_id'];

    // Memperbarui status tugas
    $sql = "UPDATE tasks SET status='$status' WHERE id='$task_id'";
    if ($conn->query($sql) === TRUE) {
        // Redirect untuk menghindari pengiriman form ulang
        header('Location: dashboard.php');
        exit();
    } else {
        die("Error: " . $conn->error);
    }
}

// Menghapus tugas
if (isset($_GET['delete_id'])) {
    $task_id = $_GET['delete_id'];

    // Menghapus tugas dari database
    $sql = "DELETE FROM tasks WHERE id='$task_id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php'); // Redirect setelah menghapus
        exit();
    } else {
        die("Error: " . $conn->error);
    }
}

// Mengambil tugas yang sudah ditambahkan
$username = $_SESSION['username'];
$sql = "SELECT * FROM tasks WHERE username='$username'";

// Menjalankan kueri
$result = $conn->query($sql);

// Cek jika kueri berhasil dijalankan
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="index.css">
    <title>Dashboard</title>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="logo.png" alt="Logo" class="logo-img"> <!-- Ganti logo.png dengan path logo Anda -->
            <h1>EazyTasks</h1>
        </div>
    </header>

    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

        <!-- Form untuk menambahkan tugas -->
        <form action="dashboard.php" method="POST">
            <input type="text" name="task" placeholder="Tambahkan tugas baru" required>
            <input type="date" name="deadline" required>
            <select name="priority" required>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
            <button type="submit">Tambah Tugas</button>
        </form>

        <h3>Daftar Tugas:</h3>
        <ul>
            <?php 
            // Menampilkan tugas jika ada
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($row['task']) . "</strong><br>";
                    echo "Deadline: " . $row['deadline'] . "<br>";
                    echo "Prioritas: " . $row['priority'] . "<br>";
                    echo "Status: " . $row['status'] . "<br>";
                    ?>

                    <!-- Form untuk memperbarui status tugas -->
                    <form action="dashboard.php" method="POST">
                        <input type="hidden" name="task_id" value="<?php echo $row['Id']; ?>">
                        <select name="status_update" required>
                            <option value="Belum Dikerjakan" <?php if ($row['status'] == "Belum Dikerjakan") echo 'selected'; ?>>Belum Dikerjakan</option>
                            <option value="Sedang Dikerjakan" <?php if ($row['status'] == "Sedang Dikerjakan") echo 'selected'; ?>>Sedang Dikerjakan</option>
                            <option value="Selesai" <?php if ($row['status'] == "Selesai") echo 'selected'; ?>>Selesai</option>
                        </select>
                        <button type="submit">Update Status</button>
                    </form>

                    <!-- Tombol Hapus -->
                    <a href="dashboard.php?delete_id=<?php echo $row['Id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">
                        <button type="submit">Hapus</button>
                    </a>

                    <?php
                    echo "</li><hr>";
                }
            } else {
                echo "<li>No tasks found.</li>";
            }
            ?>
        </ul>

        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
