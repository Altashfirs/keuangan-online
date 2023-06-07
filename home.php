<?php
session_start();
include "db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>HOME</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    </head>

    <body>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh">
            <?php if ($_SESSION['role'] == 'admin') { ?>
                <!-- For Admin -->
                <div class="card" style="width: 18rem;">
                    <img src="img/admin-default.png" class="card-img-top" alt="admin image">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <?= $_SESSION['name'] ?>
                        </h5>
                        <a href="logout.php" class="btn btn-dark">Logout</a>
                    </div>
                </div>
                <div class="p-3">
                    <?php
                    $sql = "SELECT users.id, users.name, SUM(hutang.jumlah_htg) AS total FROM users LEFT JOIN hutang ON users.id = hutang.id_peminjam GROUP BY users.id";
                    $res = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($res) >= 0) { ?>

                        <h1 class="display-4 fs-1">Transaksi</h1>
                        <table class="table" style="width: 32rem;" id="tabel-data">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($rows = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $rows['name'] ?></td>
                                        <td><?= "Rp " . number_format($rows['total'], 0, '', '.') ?></td>
                                        <td>
                                            <button type="button" class="btn p-0" onclick="window.location.href='profile.php?id=<?= $rows['id'] ?>';">
                                                <i class="bi bi-eye" style="color: blue;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php $i++;
                                } ?>
                            </tbody>
                            <script>
                                $(document).ready(function() {
                                    $('#tabel-data').DataTable();
                                });
                            </script>
                        </table>
                        <div class="text-end mt-3 col-12">
                            <a href="upload_csv.php">
                                <button type="button" class="btn btn-primary">Tambah</button>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <!-- FOR USERS -->
                <div class="card" style="width: 18rem;">
                    <img src="img/user-default.png" class="card-img-top" alt="admin image">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <?= $_SESSION['name'] ?>
                        </h5>
                        <a href="logout.php" class="btn btn-dark">Logout</a>
                    </div>
                </div>
                <div class="p-3">
                    <?php
                    $id_user = $_SESSION['id'];
                    $query = "SELECT * FROM hutang WHERE id_peminjam = $id_user";
                    $respon = mysqli_query($conn, $query);

                    if (mysqli_num_rows($respon) > 0) { ?>
                        <h1 class="display-4 fs-1">Transaksi</h1>
                        <table class="table" style="width: 32rem;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($rows = mysqli_fetch_assoc($respon)) { ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $rows['tanggal'] ?></td>
                                        <td><?= $rows['username'] ?></td>
                                        <td><?= $rows['keterangan'] ?></td>
                                        <td><?= "Rp " . number_format($rows['jumlah_htg'], 0, '', '.') ?></td>
                                    </tr>
                                <?php $i++;
                                } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: index.php");
}
?>