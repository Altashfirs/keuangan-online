<?php
session_start();
include "db_conn.php";
if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {   ?>

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
                <div class="p-4">
                    <?php include 'php/members.php';
                    if (mysqli_num_rows($res) > 0) { 
                        ?>
                        
                        <h1 class="display-4 fs-1">profil</h1>
                        <table class="table" style="width: auto;" id="tabel-data">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($rows = mysqli_fetch_assoc($res)) {
                                    $tanggal = date("d/m/Y", strtotime($rows['tanggal'])); ?>
                                    <tr>
                                        <th scope="row"><?= $i ?></th>
                                        <td><?= $tanggal; ?></td>
                                        <td><?= $rows['username'] ?></td>
                                        <td><?= $rows['keterangan'] ?></td>
                                        <td><?= "Rp " . number_format($rows['jumlah_htg'], 0, '', '.') ?></td>
                                        <td>
                                            <button type="button" class="btn p-0" onclick="window.location.href='php/ubah.php?id=<?= $rows['id_peminjam'] ?>';"><i class="bi bi-pencil-fill" style="color: green;"></i></button>
                                            <button type="button" class="btn p-0 ms-2" onclick="window.location.href='php/hapus.php?id=<?= $rows['id_hutang'] ?>';"><i class="bi bi-trash-fill" style="color: red;"></i></button>
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
                    <?php } ?>
                    <?php include 'php/members.php';
                         $tambah = mysqli_fetch_assoc($res) ?>
                        <div class="text-end mt-3 col-12">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='home.php'">Kembali</button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='php/tambah.php?id=<?= $tambah['id_peminjam']?>';">Tambah</button>
                        </div>
                </div>
            <?php } else {
                // <!-- FOR USERS -->
                header("Location: home.php");
            } ?>
        </div>
    </body>

    </html>
<?php } else {
    header("Location: index.php");
} ?>