<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <a href="<?= base_url("user/create?role=$role_id") ?>" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Tambah</a>
    <a href="<?= base_url("user/import") ?>" class="btn btn-success mb-2"><i class="fas fa-download"></i> Impor</a>

    <?= showAlert() ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Akun</h3>

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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $user) : ?>
                        <tr>
                            <td><?= ($i + 1) ?></td>
                            <td><?= $user->name ?></td>
                            <td><?= $user->email ?></td>
                            <td>
                                <?php if ($user->status == 1) : ?>
                                    <span class="badge badge-primary">active</span>
                                <?php else : ?>
                                    <span class="badge badge-warning">inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url("user/$user->id") ?>" class="btn btn-warning btn-xs btn-edit" data-id="<?= $user->id ?>"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>