<?php
require 'ceklogin.php';

//hitung jumlah barang
$h1 = mysqli_query($conn, "SELECT * FROM produk");
$h2 = mysqli_num_rows($h1); //jumlah barang

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">OSI Marketplace</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stok.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="pelanggan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Kelola Pelanggan
                        </a>
                        <a class="nav-link" href="logout.php">Logout
                        </a>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Stok Barang</h1>
                    <div class="row">
                        <div class="col-xl-3 col-md-3">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Selamat Datang!!</div>
                                <div class="card-body">Jumlah Barang: <?= $h2; ?></div>
                            </div>
                        </div>
                    </div>

                    <!---------- Editing Part 7  ---------->

                    <!-- Button to Open the Modal -->
                    <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#myModal">
                        Tambah Barang Baru
                    </button>

                    <!---------- Batas Editing sampai code atas ----------->

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $get = mysqli_query($conn, "SELECT * FROM produk");
                                    $i = 1;
                                    while ($p = mysqli_fetch_array($get)){
                                        $nama_produk = $p['nama_produk'];
                                        $deskripsi = $p['deskripsi'];
                                        $stok = $p['stok'];
                                        $harga = $p['harga'];
                                        $id_produk = $p['id_produk'] // EDITING PART 7
                                    ?>

                                        <tr>
                                            <td><?=$i++; ?></td>
                                            <td><?=$nama_produk; ?></td>
                                            <td><?=$deskripsi; ?></td>
                                            <td><?=$stok; ?></td>
                                            <td>Rp<?= number_format($harga); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $id_produk; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $id_produk; ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!--- Modal Edit --->
                                        <div class="modal fade" id="edit<?=$id_produk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah <?=$nama_produk; ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk" value="<?= $nama_produk; ?>">
                                                        <input type="text" name="deskripsi" class="form-control mt-2" placeholder="Deskripsi" value="<?= $deskripsi; ?>">
                                                        <input type="number" name="harga" class="form-control mt-2" placeholder="Harga Produk" value="<?= $harga; ?>">
                                                        <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="editbarang">Submit</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!--- Modal delete --->
                                        <div class="modal fade" id="delete<?= $id_produk; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus<?= $nama_produk; ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <form method="post">

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin Ingin Menghapus Barang Ini?
                                                            <input type="hidden" name="id_produk" value="<?= $id_produk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapusbarang">Submit</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                        <!-- Batas Editing sampai code atas -->


                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; OSI 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!---------- Editing Part 7  ---------->

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Barang Baru</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form method="post">

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="modal-body mb-3">
                    <input type="text" name="nama_produk" class="form-control" placeholder="Nama Produk">
                    <input type="text" name="deskripsi" class="form-control mt-3" placeholder="Deskripsi">
                    <input type="num" name="stok" class="form-control mt-3" placeholder="Stok Awal Produk">
                    <input type="num" name="harga" class="form-control mt-3" placeholder="Harga Produk">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="tambahbarang">Submit</button>
                    <button type="submit" class="btn btn-danger" name="modal">Close</button>
                </div>

                <!---------- Batas Editing sampai code atas ----------->


            </form>
        </div>
    </div>
</div>

</html>