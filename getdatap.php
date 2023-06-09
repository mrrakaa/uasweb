<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "SELECT * FROM t_pengeluaran WHERE id = '$id'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        $data = array(
            'id' => $row['id'],
            'tanggal' => $row['tanggal'],
            'keterangan' => $row['keterangan'],
            'keperluan' => $row['keperluan'],
            'jumlah' => $row['jumlah']
        );

        echo json_encode($data);
    }
}
if (isset($_POST['submit'])) {
    $id = $_POST['id']; // Mendapatkan ID dari form
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $keperluan = $_POST['keperluan'];
    $jumlah = $_POST['jumlah'];

    if (empty($id)) {
        // ID kosong, berarti ini adalah operasi penambahan data baru
        // Query SQL untuk menambahkan data ke tabel pemasukkan
        $insertQuery = "INSERT INTO t_pengeluaran (tanggal, keterangan, keperluan, jumlah, username) VALUES ('$tanggal', '$keterangan', '$keperluan', '$jumlah', '$username')";

        if (mysqli_query($conn, $insertQuery)) {
            // Redirect ke halaman yang sama setelah berhasil menambahkan data
            header("Location: pengeluaran.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // ID tidak kosong, berarti ini adalah operasi pembaruan data
        // Query SQL untuk memperbarui data berdasarkan ID
        $updateQuery = "UPDATE t_pengeluaran SET tanggal = '$tanggal', keterangan = '$keterangan', keperluan = '$keperluan', jumlah = '$jumlah' WHERE id = '$id'";

        if (mysqli_query($conn, $updateQuery)) {
            // Redirect ke halaman yang sama setelah berhasil memperbarui data
            header("Location: pengeluaran.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}


$conn->close();
?>
