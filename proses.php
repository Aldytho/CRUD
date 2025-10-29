<?php
include 'koneksi.php';

if (isset($_POST['aksi'])) {
    if ($_POST['aksi'] == "add") {
        
$nisn = $_POST['nisn'];
$nama_siswa = $_POST['nama_siswa'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$foto = "img5.jpg";
$alamat = $_POST['alamat'];

$query = "INSERT INTO tb_siswa VALUES(null, '$nisn', '$nama_siswa', '$jenis_kelamin', '$foto', '$alamat')";
$sql = mysqli_query($conn, $query);

if ($sql){
    echo "Data berhasil ditambahkan <a href='Beranda.php'>[Home]</a>";
} else {
    
}

echo $nisn." | ".$nama_siswa." | ".$jenis_kelamin."|".$foto." | ".$alamat;

        echo "<br> Tambah Data <a href='Beranda.php'>[Home]</a>";
    } elseif ($_POST['aksi'] == "edit") {
        echo "Edit Data <a href='Beranda.php'>[Home]</a>";
    }
}

if (isset($_GET['hapus'])) {
    echo "Hapus Data " . $_GET['hapus'] . " <a href='Beranda.php'>[Home]</a>";
}

?>
