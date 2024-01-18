<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <a href="<?= base_url('tryout/create') ?>" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Tambah</a>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Tryout Tersedia</h3>

            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Tryout</th>
                        <th>Mulai Pengerjaan</th>
                        <th>Deadline Pengerjaan</th>
                        <th>Durasi Global</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tryouts as $i => $tryout) : ?>
                        <tr>
                            <td><?= ($i + 1) ?></td>
                            <td><a href="<?= base_url("tryout/$tryout->id") ?>" class="text-reset"><b><?= $tryout->title ?></b></a></td>
                            <td><?= tanggal($tryout->attempt_open_at) ?></td>
                            <td><?= tanggal($tryout->attempt_closed_at) ?></td>
                            <td><?= $tryout->attempt_duration ?> menit</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>