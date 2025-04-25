<?php
// Membuat koneksi ke database MySQL
$conn = new mysqli("localhost","root","","todolist");
// Mengecek apakah koneksi berhasil atau tidak
if ($conn->connect_error) {
    die("Connection Failed " . $conn->connect_error);
}
// Mengecek apakah form add task dikirim
if (isset($_POST["addtask"])) {
    $task = $_POST["task"]; // Mengambil nilai task dari form
    // Menambahkan task ke database
    $conn -> query("INSERT INTO tasks (task) VALUES ('$task')");
    // Redirect kembali ke halaman utama setelah menambahkan
    header("Location: index.php");
}
// Mengecek apakah ada request untuk menghapus task
if (isset($_GET["delete"])) {
    $id = $_GET["delete"]; // Mengambil ID task yang akan dihapus
    // Menghapus task berdasarkan ID
    $conn->query("DELETE FROM tasks WHERE id = '$id'");
    // Redirect ke halaman utama setelah menghapus
    header("Location: index.php");
}
// Mengecek apakah ada request untuk menandai task sebagai selesai
if (isset($_GET["complete"])) {
    $id = $_GET["complete"]; // Mengambil ID task yang akan ditandai selesai
    // Mengupdate status task menjadi 'completed'
    $conn->query("UPDATE tasks SET status ='completed' WHERE id = '$id'");
    // Redirect ke halaman utama setelah update
    header("Location: index.php");
}
// Mengambil semua task dari database, diurutkan dari yang terbaru
$result = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form action="index.php" method="post">
            <input type="text" name="task" placeholder="Enter new task:" id="">
            <button type="submit" name="addtask">Add Task</button>
        </form>
       <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li class="<?php echo $row["status"]; ?>">
                <strong><?php echo $row["task"]; ?></strong>
                <div class="actions">
                    <a href="index.php?complete=<?php echo $row['id']; ?>">Complete</a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
                </div>
            </li>
        <?php endwhile ?>
       </ul>
    </div>
</body>
</html>