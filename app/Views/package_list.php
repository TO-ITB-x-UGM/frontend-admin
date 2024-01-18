<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <a href="<?= base_url('package/create') ?>" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Tambah Paket Soal</a>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Paket Soal</h3>

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
                                <th>Judul Paket</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($packages as $i => $package) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><a href="<?= base_url("package/$package->id") ?>" class="text-reset"><b><?= $package->title ?></b></a></td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?= base_url("package/$package->id/edit") ?>"><i class="fas fa-fw fa-edit"></i></a>
                                        <a class="btn btn-primary btn-xs" href="<?= base_url("package/$package->id") ?>"><i class="fas fa-fw fa-question"></i></a>
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