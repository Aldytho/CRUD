<?php
include 'koneksi.php';

// fungsi bantu untuk upload file
function upload_foto($file)
{
    if (!isset($file) || $file['error'] == 4) {
        return ''; // tidak ada file diupload
    }
    if ($file['error'] !== 0)
        return '';

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed))
        return '';

    // buat nama unik
    $newName = uniqid('foto_') . '.' . $ext;
    $target = __DIR__ . '/img/' . $newName;
    if (move_uploaded_file($file['tmp_name'], $target)) {
        return $newName;
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = isset($_POST['aksi']) ? $_POST['aksi'] : '';
    $nisn = isset($_POST['nisn']) ? mysqli_real_escape_string($conn, $_POST['nisn']) : '';
    $nama = isset($_POST['nama_siswa']) ? mysqli_real_escape_string($conn, $_POST['nama_siswa']) : '';
    $jkel = isset($_POST['jenis_kelamin']) ? mysqli_real_escape_string($conn, $_POST['jenis_kelamin']) : '';
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($conn, $_POST['alamat']) : '';

    if ($aksi === 'add') {
        $foto_nama = upload_foto($_FILES['foto']);
        $sql = "INSERT INTO tb_siswa (nisn, nama_siswa, jenis_kelamin, foto_siswa, alamat) VALUES ('$nisn','$nama','$jkel','$foto_nama','$alamat')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } elseif ($aksi === 'edit') {
        $id = (int) $_POST['id_siswa'];
        // cek foto baru
        $foto_baru = upload_foto($_FILES['foto']);
        if ($foto_baru !== '') {
            // ambil foto lama untuk dihapus
            $res = mysqli_query($conn, "SELECT foto_siswa FROM tb_siswa WHERE id_siswa = $id LIMIT 1");
            if ($res && mysqli_num_rows($res) == 1) {
                $r = mysqli_fetch_assoc($res);
                if (!empty($r['foto_siswa']) && file_exists('img/' . $r['foto_siswa'])) {
                    @unlink('img/' . $r['foto_siswa']);
                }
            }
            $sql = "UPDATE tb_siswa SET nisn='$nisn', nama_siswa='$nama', jenis_kelamin='$jkel', foto_siswa='$foto_baru', alamat='$alamat' WHERE id_siswa = $id";
        } else {
            $sql = "UPDATE tb_siswa SET nisn='$nisn', nama_siswa='$nama', jenis_kelamin='$jkel', alamat='$alamat' WHERE id_siswa = $id";
        }
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Aksi tidak dikenali.";
    }
    exit;
}

// HAPUS via GET
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    // ambil foto untuk dihapus
    $res = mysqli_query($conn, "SELECT foto_siswa FROM tb_siswa WHERE id_siswa = $id LIMIT 1");
    if ($res && mysqli_num_rows($res) == 1) {
        $r = mysqli_fetch_assoc($res);
        if (!empty($r['foto_siswa']) && file_exists('img/' . $r['foto_siswa'])) {
            @unlink('img/' . $r['foto_siswa']);
        }
    }
    $del = mysqli_query($conn, "DELETE FROM tb_siswa WHERE id_siswa = $id");
    if ($del) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menghapus: " . mysqli_error($conn);
    }
}