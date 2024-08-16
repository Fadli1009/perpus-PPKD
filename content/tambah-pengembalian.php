<?php
// include "../function/helper.php";
// if (isset($_POST['simpan'])) {
//     // jika param edit ada maka update, selain itu maka tambah
//     $id = isset($_GET['edit']) ? $_GET['edit'] : '';

//     $kode_transaksi = $_POST['kode_transaksi'];
//     $id_anggota = $_POST['id_anggota'];
//     $id_buku = $_POST['id_buku'];
//     $tgl_pinjam = $_POST['tanggal_pinjam'];
//     $tanggal_pinjam = $_POST['tanggal_pinjam'];
//     $tanggal_kembali = $_POST['tanggal_kembali'];
//     $id_user = $_POST['id_user'];
//     $id_kategori = $_POST['id_kategori'];
//     $queryInsert = mysqli_query($koneksi, "INSERT INTO peminjaman (kode_transaksi, id_anggota, tgl_pinjam, tgl_kembali,id_user,status) VALUES ('$kode_transaksi', $id_anggota, '$tgl_pinjam', '$tanggal_kembali',$id_user,'1') ");
//     if ($queryInsert) {
//         $id_peminjam = mysqli_insert_id($koneksi);
//         foreach ($id_kategori as $key => $value) {
//             $id_buku = $_POST['id_buku'][$key];
//             $id_kategori = $_POST['id_kategori'][$key];
//             $queryInsert = mysqli_query($koneksi, "INSERT INTO detail_peminjam (id_buku, id_peminjaman, id_kategori) VALUES ('$id_buku', '$id_peminjam', '$id_kategori') ");
//         }
//         header("Location:?pg=peminjaman&tambah=berhasil");
//         exit; // add this to prevent further execution
//     }
//     if (!$id) {
//         header("Location:?pg=peminjaman&tambah=berhasil");
//     } else {
//         $updateUser = mysqli_query($koneksi, "UPDATE user SET  nama_lengkap = '$nama_lengkap',  email = '$email', id_level = '$id_level', password ='$password' WHERE id ='$id' ");
//         header("Location:?pg=user&edit=berhasil");
//     }
// }

// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $delete = mysqli_query($koneksi, "UPDATE peminjaman SET deleted_at = 1 WHERE id = $id");
//     header("location:?pg=peminjaman&delete=berhasil");
// }
// if (isset($_GET['edit'])) {
//     $id = $_GET['edit'];
//     $edit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
//     $rowEdit = mysqli_fetch_assoc($edit);
// }
// if (isset($_GET['detail'])) {
//     $id = $_GET['detail'];
//     $detail = mysqli_query($koneksi, "SELECT anggota.nama_lengkap as nama_anggota ,peminjaman.*,user.nama_lengkap
//           FROM peminjaman 
//           LEFT JOIN anggota ON anggota.id=peminjaman.id_anggota 
//           LEFT JOIN user ON user.id = peminjaman.id_user 

//           WHERE peminjaman.id = '$id'");
//     $rowDetail = mysqli_fetch_assoc($detail);

//     // GetBuku

//     $getDetaiBook = mysqli_query($koneksi, "SELECT * FROM detail_peminjam LEFT JOIN buku on buku.id = detail_peminjam.id_buku 
//      LEFT JOIN kategori on kategori.id = buku.id_kategori WHERE id_peminjaman = '$id' ");

//     // menghitung durasi peminjaman

//     $tangga_pinjam = $rowDetail['tgl_pinjam'];
//     $tangga_kembali = $rowDetail['tgl_kembali'];
//     $date_pinjam = new DateTime($tangga_pinjam);
//     $date_kembali = new DateTime($tangga_kembali);
//     $interval = $date_pinjam->diff($date_kembali);
//     // echo "ini adalah jumlah hari peminjaman selama" . $interval->days . "hari";
// }

if (isset($_POST['submitPengembalian'])) {
    $denda = $_POST['denda'];
    // $kode_pengembalian = $_POST['kode_pengembalian'];
    $id_peminjaman = $_POST['id_peminjaman'];
    $tgl_kembali = $_POST['tanggal_kembali'];
    $terlambat = $_POST['total_terlambat'];
    $id_anggota = $_POST['id_anggota'];
    $queryPengembalian = mysqli_query($koneksi, "INSERT INTO pengembalian (id_peminjaman,id_anggota,denda,tgl_pengembalian,terlambat) VALUES ($id_peminjaman,$id_anggota,$denda,$tgl_kembali,$terlambat)");
    if ($queryPengembalian) {
        $updateStatus = mysqli_query($koneksi, "UPDATE peminjaman SET status = 2 WHERE id = $id_peminjaman");
        header("Location:?pg=pengembalian");;
    }
}
$anggota = mysqli_query($koneksi, "SELECT * FROM anggota ORDER BY id DESC");
$queryPeminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 1 ORDER BY id DESC");

// kode transaksi

// $mysqliQuery = mysqli_query($koneksi, "SELECT max(id) as id_transaksi FROM peminjaman");
// $kodeTransaksi = mysqli_fetch_assoc($mysqliQuery);
// $nomorUrut = $kodeTransaksi['id_transaksi'];
// $nomorUrut++;

?>
<div class="container">

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">Transaksi Pengembalian</div>
            <div class="card-body">
                <form action="" method="post">

                    <div class="mb-3 row">
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label for="" class="form-label">Tanggal Kembali</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="tanggal_kembali" id="tgl-kembali" class="form-control"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label for="" class="form-label">Nama Petugas</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="" id="" value="<?= $_SESSION['NAMA_LENGKAP'] ?>" readonly
                                        class="form-control">
                                    <input type="hidden" name="" id="" value="<?= $_SESSION['ID'] ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <label for="" class="form-label">Kode Peminjaman</label>
                                </div>
                                <div class="col-sm-9">
                                    <select name="id_peminjaman" id="kode_peminjaman" class="form-select"
                                        name="id_peminjam">
                                        <option value="" selected>Pilih Kode Peminjaman</option>
                                        <?php while ($rowPinjam = mysqli_fetch_assoc($queryPeminjaman)) : ?>
                                            <option value="<?= $rowPinjam['id'] ?>">
                                                <?= $rowPinjam['kode_transaksi'] ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Nama Anggota</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" readonly id="nama_anggota" class="form-control">
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Tanggal Pinjam</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" readonly id="tanggal_pinjam" class="form-control">
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Tanggal Kembali</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" readonly id="tanggal_kembali" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <label for="" class="form-label">Terlambat</label>
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" readonly id="tgl_terlambat" class="form-control"
                                                name="total_terlambat">
                                            <input type="hidden" name="terlambat" id="denda">
                                            <input type="hidden" name="denda" id="total_dendaInput">
                                            <input type="hidden" name="id_anggota" id="id_anggota">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mb-5 mt-5">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori Buku</th>
                                        <th>Judul Buku</th>
                                        <th>Tahun Terbit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div align="right" class="total_denda">

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-primary" name="submitPengembalian" type="submit">Masukan</button>
                    <a href="?pg=pengembalian" class="btn btn-sm btn-danger">Kembali</a>
                </form>
                <!-- table -->

            </div>
        </div>