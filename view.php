<?php
require 'ceklogin.php';

if(isset($_GET['idp'])){
    $idp=$_GET['idp'];

    $ambilnamapelanggan = mysqli_query($conn, "select * from pesanan p, pelanggan pl where p.idpelanggan = pl.idpelanggan and p.id_pesanan = '$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['namapelanggan'];    
}else{
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Pesanan</title>
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
                        <h1 class="mt-4">Data Pesanan: <?php echo $idp; ?></h1>
                        <h4 class="mt-4">Nama Pelanggan: <?php echo $namapel; ?></h4>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Selamat Datang!!</div>
                                </div>
                            </div>
                     
                        </div>
                        <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#myModal">Tambah Barang </button>

                     
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Sub-Total</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
               
                                    <tbody>
                                    <?php
                                    $get = mysqli_query($conn, "SELECT * FROM detailpesanan p, produk pr WHERE p.id_produk = pr.id_produk AND id_pesanan = '$idp'");
                                    $i = 1;
                                    while ($p = mysqli_fetch_array($get)) {
                                        $id_produk = $p['id_produk'];
                                        $qty = $p['qty'];
                                        $harga = $p['harga'];
                                        $namaproduk = $p['nama_produk'];
                                        $desc = $p['deskripsi'];
                                        $subtotal = $qty * $harga;
                                        $iddp = $p['id_detailpesanan'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $namaproduk; ?> (<?=$desc; ?>)</td>
                                        <td>Rp<?php echo number_format($harga); ?></td>
                                        <td><?php echo number_format($qty); ?></td>
                                        <td>Rp<?php echo number_format($subtotal); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$id_produk; ?>">Hapus Barang </button>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                    <!-- Modal -->
                                    <?php
                                    $get = mysqli_query($conn, "SELECT * FROM detailpesanan p, produk pr WHERE p.id_produk = pr.id_produk AND id_pesanan = '$idp'");
                                    while ($p = mysqli_fetch_array($get)) {
                                        $id_produk = $p['id_produk'];
                                        $iddp = $p['id_detailpesanan'];
                                    ?>
                                    <div class="modal" id="delete<?=$id_produk; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Apakah anda yakin ingin menghapus barang ini?</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="post">
                                                    <!-- Modal body -->
                                                    <div class="modal-body mb-3">
                                                        Apakah anda yakin ingin menghapus barang ini?
                                                        <input type="hidden" name="iddp" value="<?=$iddp;?>">
                                                        <input type="hidden" name="id_produk" value="<?=$id_produk;?>">
                                                        <input type="hidden" name="idorder" value="<?=$idp;?>">
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Ya</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                      
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
        <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form method="post">
                
                <!-- Modal body -->
                <div class="modal-body mb-3">
                    Pilih Barang
                    <select name="idproduk" class="form-control">
                
                    <?php
                    $getproduk = mysqli_query($conn, "SELECT * FROM produk where id_produk not in (select id_produk from detailpesanan where id_pesanan = '$idp')");
                    
                    while ($p = mysqli_fetch_array($getproduk)) {
                        $id_produk = $p['id_produk'];
                        $nama_produk = $p['nama_produk'];
                        $stok = $p['stok'];
                        $deskripsi = $p['deskripsi'];
                    ?>
                    
                    <option value="<?= $id_produk; ?>"><?= $nama_produk . ' - ' . $deskripsi; ?>(Stock: <?=$stok;?>)</option>
                
                    <?php
                    }
                    ?>
                    
                    </select>

                    <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" require>
                    <input type="hidden" name="idp" value="<?=$idp;?>">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="addproduk">Submit</button>

                </div>
                
                </form>
            </div>
        </div>
</html>
