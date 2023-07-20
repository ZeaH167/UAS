<?php
session_start();
// Koneksi
$conn = mysqli_connect("localhost", "root", "", "kasir");

// Ini Fungsi Login 
if (isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' and password='$password'");
    $hitung = mysqli_num_rows($result);

    if($hitung > 0){
        $_SESSION['login'] = true;
        header("location: index.php");
    
    } else{
        echo '
        <script>
        alert("Username atau Password Salah");
        window.location.href="login.php";
        </script>
        ';
    }
}

// Ini fungsi tambah barang
if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $insert = mysqli_query($conn, "INSERT INTO produk (nama_produk, deskripsi, harga, stok) VALUES ('$namaproduk', '$deskripsi', '$harga', '$stok')");

    if($insert){
 
        echo '
        <script>
        alert("Berhasil Menambahkan Barang");
        window.location.href = "stok.php";
        </script>
        ';
        exit();
        
    } else{

        echo '
        <script>
        alert("Gagal  Menambahkan Barang");
        window.location.href = "stok.php";
        </script>
        ';
        
    }
};
// fungsi menambah pelanggan
if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
 

    $insert = mysqli_query($conn, "INSERT INTO pelanggan (namapelanggan, notelp, alamat) VALUES ('$namapelanggan', '$notelp', '$alamat')");

    if($insert){
        echo '
        <script>
        alert("Berhasil Menambahkan Pelanggan");
        window.location.href = "pelanggan.php";
        </script>
        ';
        exit();
    } else {
        echo '
        <script>
        alert("Gagal Menambahkan Pelanggan");
        window.location.href = "pelanggan.php";
        </script>
        ';
    }
}
// fungsi menambah pesanan
if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($conn, "INSERT INTO pesanan (idpelanggan) VALUES ('$idpelanggan')");

    if($insert){
        echo '
        <script>
        alert("Berhasil Menambahkan Pesanan");
        window.location.href = "index.php";
        </script>
        ';
        exit();
    } else {
        echo '
        <script>
        alert("Gagal Menambahkan Pesanan");
        window.location.href = "index.php";
        </script>
        ';
    }
}


if(isset($_POST['addproduk'])){
    $id_produk = $_POST['idproduk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty']; // jumlah

    // Hitung stok sekarang
    $hitung1 = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    if($hitung1 && mysqli_num_rows($hitung1) > 0) {
        $hitung2 = mysqli_fetch_assoc($hitung1);
        $stock_sekarang = $hitung2['stok']; // Stok barang sekarang

        if($stock_sekarang >= $qty){
            // Kurangi stok dengan jumlah yang akan dikeluarkan
            $selisih = $stock_sekarang - $qty;

            // Stok cukup, tambahkan produk ke pesanan
            $insert = mysqli_query($conn, "INSERT INTO detailpesanan (id_pesanan, id_produk, qty) VALUES ('$idp', '$id_produk', '$qty')");
            $update = mysqli_query($conn, "UPDATE produk SET stok='$selisih' WHERE id_produk='$id_produk'");

            if($insert){
                header('location: view.php?idp='.$idp);
            } else{
                echo '
                <script>
                alert("Gagal menambahkan pesanan baru");
                window.location.href="view.php?idp='.$idp.'";
                </script>
                ';
            }
        } else{
            // Stok tidak cukup
            echo '
                <script>
                alert("Stok barang tidak cukup");
                window.location.href="view.php?idp='.$idp.'";
                </script>
            ';
        }
    } else {
        // Produk dengan ID yang diberikan tidak ditemukan
        echo '
            <script>
            alert("Produk tidak ditemukan");
            window.location.href="view.php?idp='.$idp.'";
            </script>
        ';
    }
}



//Menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

$insertb = mysqli_query($conn, "INSERT INTO masuk (id_produk, qty) VALUES ('$idproduk', '$qty')");

if($insertb){
    echo '
    <script>
    alert("Berhasil Menambahkan Data Masuk");
    window.location.href = "masuk.php";
    </script>
    ';
    exit();
} else {
    echo '
    <script>
    alert("Gagal Menambahkan Data Masuk");
    window.location.href = "masuk.php";
    </script>
    ';
}

}

//hapus produk pesanan
if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['iddp'];
    $idproduk = $p['id_produk'];
    $id_pesanan = $p['id_pesanan'];

    //cek qty sekarang
    $cek1= mysqli_query($conn, "SELECT * FROM detailpesanan WHERE id_detailpesanan='$iddp'");
    $cek2= mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty']; //stock barang sekarang

    //cek stok sekarang
    $cek3 = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok']; //stock barang sekarang

    $hitung = $qtysekarang+$stoksekarang;

    $update = mysqli_query($conn, "UPDATE produk SET stok='$hitung' WHERE id_produk='$id_produk'");
    $hapus = mysqli_query($conn, "DELETE FROM detailpesanan WHERE id_produk='$id_produk' AND id_detailpesanan='$iddp'");

    if($update && $hapus){
        header('location: view.php?idp='.$id_pesanan);
    }else{ 
        echo'
        <script>alert("Gagal menghapus barang");
        window.location.href="view.php?idp='.$id_pesanan.'";
        </script>
            ';
    }
}

            //  <!------- Editing Part 7  --------->

//edit barang
if(isset($_POST['editbarang'])){
    $nama_produk = $_POST['nama_produk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $id_produk = $_POST['id_produk']; //id_produk
; //id_produk

    $query = mysqli_query($conn, "update produk set nama_produk='$nama_produk', deskripsi='$desc', harga='$harga' where id_produk = '$id_produk' ");

    if($query){
        header('location: stok.php');
    } else{
        echo '
        <script>
        alert("Gagal");
        window.location.href="stok.php";
        </script>
        ';
    }
}

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idp = $_POST['id_produk'];

    // Periksa apakah ada referensi ke data yang akan dihapus
    $queryCheckReference = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$idp'");
    if(mysqli_num_rows($queryCheckReference) > 0){
        // Ada referensi ke data yang akan dihapus
        echo '
        <script>
        alert("Tidak dapat menghapus data karena masih ada stock!!!");
        window.location.href="stok.php";
        </script>
        ';
    } else {
        // Tidak ada referensi ke data yang akan dihapus
        $queryDelete = mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$idp'");
        if($queryDelete){
            header('location: stok.php');
        } else{
            echo '
            <script>
            alert("Gagal menghapus data.");
            window.location.href="stok.php";
            </script>
            ';
        }
    }
}


// Edit Pelanggan
if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $nt = $_POST['notelp'];
    $a = $_POST['alamat'];
    $id = $_POST['idpl'];

    $query = mysqli_query($conn, "update pelanggan set namapelanggan='$np', notelp='$nt', alamat='$a' where idpelanggan = '$id' ");

    if($query){
        header('location: pelanggan.php');
    } else{
        echo '
        <script>
        alert("Gagal");
        window.location.href="pelanggan.php";
        </script>
        ';
    }
}

// Hapus Pelanggan
if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($conn, "delete from pelanggan where idpelanggan='$idpl'");

    if($query){
        header('location: pelanggan.php');
    } else{
        echo '
        <script>
        alert("Gagal");
        window.location.href="pelanggan.php";
        </script>
        ';
    } 
}

    // <!-- Batas Editing sampai code atas -->

?>
