<?php
include 'koneksi.php';

$query ="SELECT * FROM tb_siswa";
 $sql = mysqli_query($conn, $query);
 $no = 0;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Font -->
 <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>belajar_crud</title>
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        belajar_crud - BS5
    </a>
  </div>

  <!-- judul -->
  <div class="container">
 <h1 class="mt-4">Data siswa</h1>
<figure>
  <blockquote class="blockquote">
    <p>Berisi Data yang telah disimpan di data base</p>
  </blockquote>
  <figcaption class="blockquote-footer">
    CRUD <cite title="Source Title">Create read Update delete</cite>
  </figcaption>
</figure>
<!-- button -->
<a href="kelola.php" type="button" class="btn btn-primary mb-3">
    <i class="fa fa-plus"></i>
    Tambah Data
</a>
<div class="table-responsive">
  <table class="table align-middle table-bordered table-hover">
    <thead>
      <tr>
        <th><center>No. </center></th>
        <th>NISN</th>
        <th>Nama Siswa</th>
        <th>Jenis Kelamin</th>
        <th>Foto Siswa</th>
        <th>Alamat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
while($result = mysqli_fetch_assoc( $sql)){
 
    ?>
      <tr>
        <td><center>
          <?php
          echo ++$no;
          ?>
        </center></td>
        <td><?php
          echo $result['nisn'];
          ?></td>
        <td><?php
          echo $result['nama_siswa'];
          ?></td>
        <td><?php
          echo $result['jenis_kelamin'];
          ?></td>
        <td>
            <img src="img/<?php
          echo $result['foto_siswa'];
          ?>" style="width: 150px;">
        </td>
        <td><?php
          echo $result['alamat'];
          ?></td>
        <td>
            <a href="kelola.php?ubah=<?php
          echo $result['id_siswa'];
          ?>" type="button" class="btn btn-success btn-sm" >
                <i class="fa fa-pencil" ></i>
                
            </a>
            <a href="proses.php?hapus=<?php
          echo $result['id_siswa'];
          ?>" name ="hapus" value ="delete" type="button" class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i>
                
            </a>
        </td>
    </tr>
    <?php
}
    ?>
      
        
      
     
  </table>
</div>
</nav>
  </div>


</body>
</html>