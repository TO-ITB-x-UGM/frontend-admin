<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <div class="row">
        <div class="col-lg-9">
            <div class="mb-3">
                <a href="<?= base_url("tryout/$exam_id/participant") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attempt Detail (Pengerjaan Global)</h3>

                    <div class="card-tools">
                        <a href="<?= base_url("tryout/$exam_id/participant/$attempt->id") ?>" class="btn btn-tool" title="Edit Attempt Info">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Attempt ID</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" readonly value="<?= $attempt->id ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Tryout ID</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" readonly value="<?= $attempt->exam_id ?>">
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly value="<?= $tryout->title ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Peserta ID</label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" readonly value="<?= $attempt->user_id ?>">
                        </div>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" readonly value="<?= $user->name ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="description">Mulai Pengerjaan</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="title" readonly value="<?= tanggal($attempt->started_at) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="description">Batas Akhir Pengerjaan</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="title" readonly value="<?= tanggal($attempt->ended_at) ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subattempt (Pengerjaan Subtes)</h3>
                    <div class="card-tools">
                        <a href="<?= base_url("tryout/$exam_id/subtest/create") ?>" class="btn btn-tool" title="Tambah Subtes">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Subtes</th>
                                <th>Waktu Pengerjaan</th>
                                <th>Deadline Pengerjaan</th>
                                <th>Score</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subattempts as $i => $subattempt) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $subattempt->subtest_title ?></td>
                                    <td><?= ($subattempt->started_at) ? tanggal($subattempt->started_at) : "" ?></td>
                                    <td><?= ($subattempt->ended_at) ? tanggal($subattempt->ended_at) : "" ?></td>
                                    <td><?= $subattempt->score ?></td>
                                    <td>
                                        <a href="<?= base_url("tryout/$exam_id/participant/$attempt->id/subattempt/$subattempt->subattempt_id") ?>" class="btn btn-primary btn-xs" title="Review"><i class="fas fa-fw fa-eye"></i></a>
                                        <button data-subattempt_id="<?= $subattempt->subattempt_id ?>" type="button" class="btn btn-danger btn-xs btn-delete" title="Hapus"><i class="fas fa-fw fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>


<?= $this->section('js'); ?>
<script>
    $(document).ready(function() {
        $('.btn-delete').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Pengerjaan Subtest yang sudah dihapus tidak bisa dipulihkan',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("subattempt") ?>/" + $(this).data('subattempt_id'),
                        method: 'DELETE',
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Pengerjaan Subtest berhasil dihapus'
                                }).then(() => {
                                    window.location.replace("<?= base_url("tryout/$exam_id/participant/$attempt->id") ?>");
                                });
                            } else {
                                console.log(result);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: result.message
                                });
                            }
                        },
                        error: (err) => {
                            console.log(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.statusText
                            });
                        }
                    })

                }
            })
        });
    });
</script>
<?= $this->endSection(); ?>