<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <div class="row">
        <div class="col-lg-9">
            <div class="mb-3">
                <a href="<?= base_url("tryout") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
                <a href="<?= base_url("tryout/$exam_id/participant") ?>" class="btn btn-warning"><i class="fas fa-fw fa-users"></i> Lihat Peserta</a>
                <a href="<?= base_url("tryout/$exam_id/rank") ?>" class="btn btn-success"><i class="fas fa-fw fa-sort-numeric-down"></i> Perangkingan</a>
                <a href="<?= base_url("tryout/$exam_id/stats") ?>" class="btn btn-primary"><i class="fas fa-fw fa-chart-area"></i> Statistik</a>
                <button type="button" id="btn-delete" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i> Hapus Tryout</button>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tryout Info</h3>

                    <div class="card-tools">
                        <a href="<?= base_url("tryout/$exam_id/edit") ?>" class="btn btn-primary btn-xs" title="Edit Tryout Info">
                            <i class="fas fa-fw fa-edit"></i> Edit Tryout
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">ID</label>
                        <div class="col-lg-3">
                            <input type="text" class="form-control" readonly value="<?= $tryout->id ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="title">Judul Tryout</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" readonly value="<?= $tryout->title ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="description">Deskripsi</label>
                        <div class="col-lg-6">
                            <textarea cols="30" rows="3" class="form-control" readonly><?= $tryout->description ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="description">Mulai Pengerjaan</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="title" readonly value="<?= tanggal($tryout->attempt_open_at) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="description">Batas Akhir Pengerjaan</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="title" readonly value="<?= tanggal($tryout->attempt_closed_at) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="description">Durasi Pengerjaan Global (mins)</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" readonly value="<?= $tryout->attempt_duration ?> menit">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Subtes</h3>
                    <div class="card-tools">
                        <a href="<?= base_url("tryout/$exam_id/subtest/create") ?>" class="btn btn-primary btn-xs" title="Tambah Subtes">
                            <i class="fas fa-fw fa-plus-circle"></i> Buat Subtest
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Subtes</th>
                                <th>Jenis</th>
                                <th>Durasi Pengerjaan</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subtests as $i => $subtest) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $subtest->title ?></td>
                                    <td>
                                        <?php if ($subtest->type == 1) : ?>
                                            <span class="badge badge-primary">TPS</span>
                                        <?php else : ?>
                                            <span class="badge badge-danger">TKA</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= round($subtest->attempt_duration / 60, 1) ?> menit</td>
                                    <td>
                                        <a href="<?= base_url("tryout/$exam_id/subtest/$subtest->id/edit") ?>" class="btn btn-warning btn-xs" title="Edit Subtes"><i class="fas fa-fw fa-edit"></i></a>
                                        <a href="<?= base_url("tryout/$exam_id/subtest/$subtest->id/question") ?>" class="btn btn-primary btn-xs" title="Lihat Daftar Soal"><i class="fas fa-fw fa-question"></i></a>
                                        <a href="<?= base_url("tryout/$exam_id/subtest/$subtest->id/scoring") ?>" class="btn btn-info btn-xs" title="Scoring"><i class="fas fa-fw fa-poll"></i></a>
                                        <a href="<?= base_url("tryout/$exam_id/subtest/$subtest->id/rank") ?>" class="btn btn-success btn-xs" title="Rank Subtest"><i class="fas fa-fw fa-sort-numeric-down"></i></a>
                                        <a href="<?= base_url("tryout/$exam_id/subtest/$subtest->id/attempt") ?>" class="btn btn-danger btn-xs" title="Pengerjaan"><i class="fas fa-fw fa-user-edit"></i></a>
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
        $('#btn-delete').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Tryout yang dihapus tidak bisa dipulihkan',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("tryout/$exam_id") ?>",
                        method: 'DELETE',
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Tryout berhasil dihapus'
                                }).then(() => {
                                    window.location.replace("<?= base_url("tryout") ?>");
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: result.message
                                });
                            }
                        },
                        error: (err) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.statusText
                            });
                        }
                    })

                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>