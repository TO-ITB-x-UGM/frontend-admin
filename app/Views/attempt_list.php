<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <a href="<?= base_url("tryout/$exam_id") ?>" class="btn btn-info mb-2"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
    <a href="<?= base_url("tryout/$exam_id/participant/add") ?>" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Tambah Peserta Manual</a>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Peserta</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Peserta</th>
                                <th>Email Peserta</th>
                                <th>Waktu Mulai Pengerjaan</th>
                                <th>Deadline Pengerjaan</th>
                                <th>Score</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attempts as $i => $attempt) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $attempt->name ?></td>
                                    <td><?= $attempt->email ?></td>
                                    <td><?= tanggal($attempt->started_at) ?></td>
                                    <td><?= tanggal($attempt->ended_at) ?></td>
                                    <td><?= $attempt->score_agregate ?></td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?= base_url("tryout/$exam_id/participant/$attempt->id/edit") ?>" title="Edit"><i class="fas fa-fw fa-edit"></i></a>
                                        <a class="btn btn-primary btn-xs" href="<?= base_url("tryout/$exam_id/participant/$attempt->id") ?>" title="Lihat Detail"><i class="fas fa-fw fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
<?= $this->endSection(); ?>