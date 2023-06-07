<?php
session_start();
include "../db_conn.php";
$data = $conn->query("SELECT * FROM hutang WHERE id_peminjam ='$_GET[id]'");
if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {   ?>

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
                            <?php
                            while ($dta = mysqli_fetch_assoc($data)) :
                            ?>
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control" type="hidden" name="id_peminjam" value="<?= $dta['id_peminjam'] ?>">
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $dta['username'] ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $dta['keterangan'] ?>">
                                </div>
                                <div class="col-12">
                                    <label for="jumlah_htg" class="form-label">Harga</label>
                                    <input type="text" class="form-control" id="jumlah_htg" name="jumlah_htg" value="<?= $dta['jumlah_htg'] ?>">
                                </div>
                                <div class="col-12">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $dta['tanggal'] ?>">
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" onclick="window.location.href='../home.php'">Kembali</button>
                                    <button type="submit" name="ubah" class="btn btn-primary">Perbarui</button>
                                </div>
                        </form>
                    <?php endwhile; ?>
                    <?php
                    if (isset($_POST['ubah'])) {
                        $id   = $_POST['id_peminjam'];
                        $nama = $_POST['username'];
                        $keterangan = $_POST['keterangan'];
                        $jmlh = $_POST['jumlah_htg'];
                        $tanggal = $_POST['tanggal'];

                        $ubah = $conn->query("UPDATE hutang SET username = '$nama', keterangan = '$keterangan', jumlah_htg = '$jmlh', tanggal = '$tanggal' WHERE id_peminjam = " . $id);
                        if ($ubah) {
                            echo "
                            <script>
                            alert('data hutang berhasil diedit');
                            document.location.href = '../home.php';
                            </script>
                            ";
                        } else {
                            echo "
                            <script>
                            alert('data hutang gagal diedit');
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