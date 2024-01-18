<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <div class="callout callout-warning">
        <h5>Perhatian!</h5>
        <p>Sebelum melakukan scoring, pastikan semua peserta telah selesai mengerjakan tryout.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Tryout dan Status Pengerjaan</h3>

            <div class="card-tools">

            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Tryout</th>
                        <th>Mulai Pengerjaan</th>
                        <th>Batas Akhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exams as $i => $exam) : ?>
                        <tr>
                            <td><?= ($i + 1) ?></td>
                            <td><a href="<?= base_url("scoring/$exam->id") ?>" class="text-reset"><b><?= $exam->title ?></a></b></td>
                            <td><?= tanggal($exam->attempt_open_at) ?></td>
                            <td><?= tanggal($exam->attempt_closed_at) ?></td>
                            <td>
                                <?php if ($exam->attempt_open_at > time()) : ?>
                                    <span class="badge badge-info">READY</span>
                                <?php elseif ($exam->attempt_closed_at > time()) : ?>
                                    <span class="badge badge-primary">ONGOING</span>
                                <?php else : ?>
                                    <span class="badge badge-success">CLOSED</span>
                                <?php endif; ?>
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
</section>
<?= $this->endSection(); ?>