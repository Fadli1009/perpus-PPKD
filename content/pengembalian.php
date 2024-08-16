<?php
$queryPinjam = mysqli_query($koneksi, "
    SELECT pengembalian.*, anggota.nama_lengkap as nama_anggota 
    FROM pengembalian 
    LEFT JOIN anggota ON pengembalian.id_anggota = anggota.id 
    ORDER BY pengembalian.id DESC
");

?>

<div class=" mt-4">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah Pengembalian</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3" align="right">
                        <a href="?pg=tambah-pengembalian" class="btn btn-primary">Tambah </a>
                    </div>
                    <?php
                    if (isset($_GET['tambah']) && $_GET['tambah'] == "berhasil") :  ?>
                        <div class="alert alert-success" role="alert">
                            Data berhasil di simpan
                        </div>
                    <?php endif; ?>
                    <?php
                    if (isset($_GET['hapus']) && $_GET['hapus'] == "berhasil") :  ?>
                        <div class="alert alert-success" role="alert">
                            Data berhasil di hapus
                        </div>
                    <?php endif; ?>
                    <?php
                    if (isset($_GET['edit']) && $_GET['edit'] == "berhasil") :  ?>
                        <div class="alert alert-success" role="alert">
                            Data Mengedit Data
                        </div>
                    <?php endif; ?>

                    <div class="table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Pengembalian</th>
                                    <th>Anggota</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Terlambat</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $no = 1;
                                while ($row = mysqli_fetch_assoc($queryPinjam)) : ?>

                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['kode_pengembalian'] ?></td>
                                        <td><?= $row['nama_anggota'] ?></td>
                                        <td><?= $row['tgl_pengembalian'] ?></td>
                                        <td><?= $row['denda'] ?></td>
                                        <td><?= $row['terlambat'] ?></td>


                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>