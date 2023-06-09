<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil nama pengguna dari session
$username = $_SESSION['username'];

// Proses penambahan data
if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal'];
    // Ubah format tanggal dari dd/mm/yyyy ke yyyy-mm-dd
    $tanggal = date("Y-m-d", strtotime(str_replace('/', '-', $tanggal)));
    $keterangan = $_POST['keterangan'];
    $keperluan = $_POST['keperluan'];
    $jumlah = $_POST['jumlah'];

    // Query SQL untuk menambahkan data ke tabel t_pemasukkan
    $insertQuery = "INSERT INTO t_pengeluaran (tanggal, keterangan, keperluan, jumlah) VALUES ('$tanggal', '$keterangan', '$keperluan', '$jumlah')";

    if ($conn->query($insertQuery) === TRUE) {
        // Redirect ke halaman yang sama setelah berhasil menambahkan data
        header("Location: pengeluaran.php");
        exit();
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }
}

// Proses penghapusan data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Query SQL untuk menghapus data berdasarkan id
    $deleteQuery = "DELETE FROM t_pengeluaran WHERE id = '$id'";

    if ($conn->query($deleteQuery) === TRUE) {
        // Redirect ke halaman yang sama setelah berhasil menghapus data
        header("Location: pengeluaran.php");
        exit();
    } else {
        echo "Error: " . $deleteQuery . "<br>" . $conn->error;
    }
}

// Query SQL untuk mengambil data dari database
$query = "SELECT * FROM t_pengeluaran";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="img/icon.png">
	<title>Uang - Ku - Pengeluaran</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
		crossorigin="anonymous">
	<link rel="stylesheet" href="css/styler.css?v=1.0">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/sweetalert.min.js"></script>
	<style>
	</style>
</head>

<body>
	<div class="header">
		<img src="img/icon.png" width="25px" height="25px" class="float-left logo-fav">
		<h3 class="text-secondary font-weight-bold float-left logo">Uang</h3>
		<h3 class="text-secondary float-left logo2">- ku</h3>
		<a href="index.php">
			<div class="logout">
					<i class="fas fa-sign-out-alt float-right log"></i>
					<p class="float-right logout">Logout</p>
			</div>
		</a>
	</div>

	<div class="sidebar">
		<nav>
			<ul>
					<li>
						<img src="img/user.png" class="img-fluid profile float-left" width="60px">
						<h5 class="admin"><?= substr($username, 0, 7) ?></h5>
						<div class="online online2">
							<p class="float-right ontext">Online</p>
							<div class="on float-right"></div>
						</div>
					</li>
					<!-- fungsi slide -->
					<script>
						$(document).ready(function(){
						$("#flip").click(function(){
							$("#panel").slideToggle("medium");
							$("#panel2").slideToggle("medium");
						});
						$("#flip2").click(function(){
							$("#panel3").slideToggle("medium");
							$("#panel4").slideToggle("medium");
						});
					});
					</script>

					<!-- dashboard -->
					<a href="dashboard.php" style="text-decoration: none;">
						<li>
							<div>
									<span class="fas fa-tachometer-alt"></span>
									<span>Dashboard</span>
							</div>
						</li>
					</a>

					<!-- data -->
					<li class="klik" id="flip" style="cursor:pointer;">
						<div>
							<span class="fas fa-database"></span>
							<span>Data Harian</span>
							<i class="fas fa-caret-up float-right" style="line-height: 20px;"></i>
						</div>
					</li>

					<a href="pemasukkan.php" class="linkAktif">
						<li id="panel">
							<div style="margin-left: 20px;">
									<span><i class="fas fa-file-invoice-dollar"></i></span>
									<span>Data Pemasukkan</span>
							</div>
						</li>
					</a>

					<a href="pengeluaran.php" class="linkAktif">
						<li id="panel2" class="aktif" style="border-left: 5px solid #306bff;">
							<div style="margin-left: 20px;">
									<span><i class="fas fa-hand-holding-usd"></i></span>
									<span>Data Pengeluaran</span>
							</div>
						</li>
					</a>
					<!-- data -->

					<!-- Input -->
					<li class="klik2" id="flip2" style="cursor:pointer;">
						<div>
							<span class="fas fa-plus-circle"></span>
							<span>Input Data</span>
							<i class="fas fa-caret-right float-right" style="line-height: 20px;"></i>
						</div>
					</li>

					<a href="tambahPemasukkan" class="linkAktif">
						<li id="panel3" style="display: none;">
							<div style="margin-left: 20px;">
									<span><i class="fas fa-file-invoice-dollar"></i></span>
									<span>Pemasukkan</span>
							</div>
						</li>
					</a>

					<a href="tambahPengeluaran" class="linkAktif">
						<li id="panel4" style="display: none;">
							<div style="margin-left: 20px;">
									<span><i class="fas fa-hand-holding-usd"></i></span>
									<span>Pengeluaran</span>
							</div>
						</li>
					</a>
					<!-- Input -->

					<!-- laporan -->
					<a href="laporan" style="text-decoration: none;">
						<li>
							<div>
									<span><i class="fas fa-clipboard-list"></i></span>
									<span>Laporan</span>
							</div>
						</li>
					</a>

					<!-- change icon -->
					<script>
						$(".klik").click(function () {
							$(this).find('i').toggleClass('fa-caret-up fa-caret-right');
							if ($(".klik").not(this).find("i").hasClass("fa-caret-right")) {
									$(".klik").not(this).find("i").toggleClass('fa-caret-up fa-caret-right');
							}
						});
						$(".klik2").click(function () {
							$(this).find('i').toggleClass('fa-caret-up fa-caret-right');
							if ($(".klik2").not(this).find("i").hasClass("fa-caret-right")) {
									$(".klik2").not(this).find("i").toggleClass('fa-caret-up fa-caret-right');
							}
						});
					</script>
					<!-- change icon -->
			</ul>
		</nav>
	</div>

	<div class="main-content khusus">
		<div class="konten khusus2">
			<div class="konten_dalem khusus3">
					<h2 class="head" style="color: #4b4f58;">Pengeluaran</h2>
					<hr style="margin-top: -2px;">

					<!-- bagian filter dan pencarian -->
					<div class="row cari-filter">
						<div class="col-lg-5">
							<table class="tabel-data">
									<tr>
									<td><label>Pilih tanggal</label></td>
                                    <td style="width: 71%">
                                    <input type="date" value="<?= date('Y-m-d', strtotime($today)) ?>" class="form-control filter" id="filter" placeholder="dd/mm/yyyy">
                                    </td>
									</tr>
							</table>
							
						</div>
						<div class="col-lg-4">
							<input type="hidden" id="username" value="<?= $username ?>">
						</div>

						<div class="col-lg-3">
							<div class="input-group">
									<input type="text" name="cari" class="form-control border-right-0 cari" id="keyword" placeholder="Search" autocomplete="off">
									<div class="input-group-append">
										<span class="input-group-text bg-white border-left-0 icone"><i class="fa fa-search"></i></span>
									</div>
							</div>
						</div>
					</div>
					<!-- bagian filter dan pencarian -->
					
					<!-- bagian isi tabel -->
					<div class="headline">
    <h5>Data Pengeluaran</h5>
</div>
<div class="container" id="container">
    <div class="row tampil" id="row">
        <div class="col-md-12">
            <div class="table-responsive">
			<table id="tabelPemasukkan" class="table table-sm table-hover table-striped table-bordered">
    <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Keterangan Pengeluaran</th>
        <th>Keperluan Pengeluaran</th>
        <th>Jumlah Pengeluaran</th>
        <th>Aksi</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $i . "</td>";
            echo "<td>" . date('d/m/Y', strtotime($row['tanggal'])) . "</td>";
            echo "<td>" . $row['keterangan'] . "</td>";
            echo "<td>" . $row['keperluan'] . "</td>";
            echo "<td>" . $row['jumlah'] . "</td>";
            echo "<td>
                <a href='pengeluaran.php?hapus=" . $row['id'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                <a href='#' class='btn btn-primary btn-sm btn-edit' data-id='" . $row['id'] . "' data-toggle='modal' data-target='#exampleModalCenter'>Edit</a>
            </td>";
            $i++;
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data pemasukkan</td></tr>";
    }
    ?>
</table>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn2" data-toggle="modal" data-target="#exampleModalCenter">
        <i class="fas fa-hand-holding-usd"></i> Tambah Data
    </button>
</div>
<!-- bagian isi tabel -->
</div>
</div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Pemasukkan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- isi form -->
                <div class="modal-body">
                    <script type="text/javascript" src="js/pisahTitik.js"></script>
                    <div class="form-group">
                        <label>Masukkan Tanggal</label>
                        <input type="date" value="<?= date('Y-m-d') ?>" name="tanggal" class="form-control" id="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Keterangan Pengeluaran</label>
                        <input type="text" name="keterangan" class="form-control" id="keterangan" required>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Keperluan Pengeluaran</label>
                        <select name="keperluan" class="form-control" id="keperluan">
                            <option>Makan dan Minum</option>
                            <option>Hutang</option>
                            <option>Peralatan</option>
                            <option>Organisasi</option>
                            <option>Kendaraan</option>
                            <option>Keperluan pribadi</option>
                            <option>Lain - lain</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Jumlah Pengeluaran</label>
                        <input type="text" id="jumlah" name="jumlah" class="form-control" onkeydown="return numbersonly(this, event);"
                            onkeyup="javascript:tandaPemisahTitik(this);" required>
                    </div>
                </div>
                <!-- footer form -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary tambahin">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil nama pengguna dari session
$username = $_SESSION['username'];

// Proses penambahan data
if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $keperluan = $_POST['keperluan'];
    $jumlah = $_POST['jumlah'];

    // Query SQL untuk menambahkan data ke tabel pemasukkan
    $insertQuery = "INSERT INTO pengeluaran (tanggal, keterangan, keperluan, jumlah, username) VALUES ('$tanggal', '$keterangan', '$keperluan', '$jumlah', '$username')";

    if (mysqli_query($conn, $insertQuery)) {
        // Redirect ke halaman yang sama setelah berhasil menambahkan data
        header("Location: pengeluaran.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Proses penghapusan data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Query SQL untuk menghapus data berdasarkan id
    $deleteQuery = "DELETE FROM t_pengeluaran WHERE id = '$id'";

    if (mysqli_query($conn, $deleteQuery)) {
        // Redirect ke halaman yang sama setelah berhasil menghapus data
        header("Location: pengeluaran.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Query SQL untuk mengambil data dari database
$query = "SELECT * FROM t_pengeluaran";
$result = mysqli_query($conn, $query);

$conn->close();
?>

			</div>
		</div>
	</div>
	<!-- Modal Tambah Data -->

	<!-- Modal edit data -->
	<div class="modal fade" id="myModal2" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">Ubah Data Pemasukkan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<!-- isi form -->
					<div class="modal-body">
						<input type="hidden" id="userId" class="form-control">
						<div class="form-group">
							<label for="tanggal">Tanggal</label>
							<input type="date" class="form-control" id="tanggal" required>
						</div>
						<div class="form-group">
							<label for="keterangan">Keterangan Pemasukkan</label>
							<input type="text" class="form-control" id="keterangan" required>
						</div>
						<div class="form-group">
							<label for="sumber">Sumber Pemasukkan</label>
							<select class="form-control" id="sumber">
									<option>ATM</option>
									<option>Pemberian</option>
									<option>Piutang</option>
									<option>Laba penjualan</option>
									<option>Pekerjaan</option>
									<option>Lain - lain</option>
							</select>
						</div>
						<div class="form-group">
							<label for="jumlahMasuk">Jumlah Pemasukkan</label>
							<input type="text" class="form-control" id="jumlahMasuk" onkeydown="return numbersonly(this, event);"
										onkeyup="javascript:tandaPemisahTitik(this);" required>
						</div>
					</div>
					<!-- footer form -->
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<a href="#" id="save" class="btn btn-primary">simpan</a>
					</div>
			</div>
		</div>
	</div>
	<!-- Modal edit data -->

	<!-- double modal -->
	<script>
		$('#openBtn').click(function () {
			$('#myModal2').modal({
					show: true
			});
		})
	</script>

	<script src="js/bootstrap.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
	<script>
    $(document).ready(function() {
        $('.btn-edit').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'getdatap.php',
                method: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    $('#tanggal').val(response.tanggal);
                    $('#keterangan').val(response.keterangan);
                    $('#sumber').val(response.sumber);
                    $('#jumlah').val(response.jumlah);
                    $('#id').val(response.id);
                }
            });
        });
    });
</script>

</body>

</html>