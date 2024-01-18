<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <form action="<?= base_url('user/import') ?>" method="post" enctype="multipart/form-data">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Imported Users</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Sekolah</th>
                            <th>Nomor HP</th>
                            <th>Role ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $i => $user) : ?>
                            <tr>
                                <td><?= ($i + 1) ?></td>
                                <td><?= $user->name ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->school ?></td>
                                <td><?= $user->phone_number ?></td>
                                <td><?= $user->role_id ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="<?= base_url('user/participant') ?>" class="btn btn-primary"><i class="fas fa-next"></i> Selesai</a>
            </div>
        </div>
    </form>
</section>
<?= $this->endSection(); ?>