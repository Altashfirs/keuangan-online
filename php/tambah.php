<?php
session_start();
include "../db_conn.php";
if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {
    $data = $conn->query("SELECT * FROM hutang WHERE id_peminjam ='$_GET[id]'");
    $dta = mysqli_fetch_assoc($data)
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>HOME</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    </head>

    <body>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <div class="card" style="width: 18rem;">
                <img src="../img/admin-default.png" class="card-img-top" alt="admin image">
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <?= $_SESSION['name'] ?>
                    </h5>
                    <a href="logout.php" class="btn btn-dark">Logout</a>
                </div>
            </div>


            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-10">
                        <form class="row g-3" method="post">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $dta['username'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan">
                            </div>
                            <div class="col-12">
                                <label for="jumlah_htg" class="form-label">Harga</label>
                                <input type="text" class="form-control" id="jumlah_htg" name="jumlah_htg" placeholder="Masukkan Harga">
                            </div>
                            <div class="col-12">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='../home.php'">Kembali</button>
                                <button type="submit" name="ubah" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['ubah'])) {
                            $id = $_GET['id'];
                            $nama = $_POST['username'];
                            $keterangan = $_POST['keterangan'];
                            $jmlh = $_POST['jumlah_htg'];
                            $tanggal = $_POST['tanggal'];

                            // ID_HUTANG
                            $today = date("ymd");
                            $query = mysqli_query($conn, "SELECT max(id_hutang) AS last FROM hutang WHERE id_hutang LIKE '$today%'");
                            $data = mysqli_fetch_assoc($query);
                            $lastNobayar = $data['last'];
                            $lastNoUrut  = intval(substr($lastNobayar, 6, 4));
                            $nextNoUrut  = $lastNoUrut + 1;
                            $randomNumber = rand(1000, 9999); // Generate a random 4-digit number
                            $nextNobayar = $today . sprintf('%03s', $nextNoUrut) . $randomNumber;
                            $cekid = mysqli_num_rows($conn->query("SELECT id_hutang FROM hutang WHERE id_hutang='$nextNobayar'"));

                            if($cekid > 0) {
                                $nextNobayar = $today . sprintf('%03s', $nextNoUrut) . $randomNumber;
                                $simpan = $conn->query("INSERT INTO hutang (id_peminjam, username, keterangan, jumlah_htg, tanggal, id_hutang) VALUES('$id', '$nama', '$keterangan', '$jmlh', '$tanggal', '$nextNobayar')");
                            } else {
                            $simpan = $conn->query("INSERT INTO hutang (id_peminjam, username, keterangan, jumlah_htg, tanggal, id_hutang) VALUES('$id', '$nama', '$keterangan', '$jmlh', '$tanggal', '$nextNobayar')");
                            } 
                            if (!$ubah) {
                                echo "
                            <script>
                            alert('data berhasil ditambahkan');
                            document.location.href = '../home.php';
                            </script>
                            ";
                            } else {
                                echo "
                            <script>
                            alert('data gagal ditambahkan');
                            document.location.href = '../home.php';
                            </script>
                            ";
                            }
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </body>

    </html>
<?php } else {
    header("Location: ../home.php");
} ?>