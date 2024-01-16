<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <div class="row">
        <div class="col-lg-6">

            <div class="callout callout-warning">
                <h5>Perhatian!</h5>
                <p>Sebelum melakukan scoring, pastikan semua peserta telah selesai mengerjakan tryout.</p>
            </div>
            <a href="<?= base_url("scoring") ?>" class="btn btn-info mb-2"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
            <a href="<?= base_url("scoring/$exam_id/rank") ?>" class="btn btn-danger mb-2"><i class="fas fa-fw fa-poll"></i> Peringkat</a>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Subtests</h3>

                    <div class="card-tools">

                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Judul Subtest</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subtests as $i => $subtest) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><a href="<?= base_url("scoring/$exam_id/subtest/$subtest->id") ?>" class="text-reset"><b><?= $subtest->title ?></a></b></td>
                                    <td>
                                        <a href="" class="btn btn-warning btn-xs btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    Footer
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>