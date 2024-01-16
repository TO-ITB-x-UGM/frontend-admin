<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <a href="<?= base_url("tryout/$exam_id") ?>" class="btn btn-info mb-2"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
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
                                <th>Selesai Pengerjaan</th>
                                <th>Durasi</th>
                                <th>Score</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subattempts as $i => $attempt) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $attempt->name ?></td>
                                    <td><?= $attempt->email ?></td>
                                    <td><?= tanggal($attempt->started_at) ?></td>
                                    <td><?= tanggal($attempt->ended_at) ?></td>
                                    <td><?= round(($attempt->ended_at - $attempt->started_at) / 60, 1) ?> menit</td>
                                    <td><?= $attempt->score ?></td>
                                    <td>
                                        <a href="<?= base_url("tryout/$exam_id/participant/$attempt->attempt_id/subattempt/$attempt->id") ?>" class="btn btn-primary btn-xs" title="Review"><i class="fas fa-fw fa-eye"></i></a>
                                        <button class="btn btn-danger btn-xs btn-delete" data-subattempt_id="<?= $attempt->id ?>" type="button" title="Hapus"><i class="fas fa-fw fa-trash"></i></button>
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
                                    window.location.replace("<?= base_url("tryout/$exam_id/subtest/$subtest_id/attempt") ?>");
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