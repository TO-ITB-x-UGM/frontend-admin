<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <div class="mb-3">
        <a href="<?= base_url("tryout/$exam->id") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
        <button type="button" id="btn-reload" class="btn btn-danger"><i class="fas fa-fw fa-sync"></i> Reload</button>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ranking</h3>

            <div class="card-tools">

            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Nama</th>
                        <th>Sekolah</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $i => $participant) : ?>
                        <tr>
                            <td><?= ($i + 1) ?></td>
                            <td><a href="<?= base_url("tryout/$exam->id/participant/$participant->attempt_id/subattempt/$participant->id") ?>" class="text-reset"><?= $participant->name ?></a></td>
                            <td><?= $participant->school ?></td>
                            <td><?= $participant->score ?></td>
                            <td>
                                <a href="<?= base_url("tryout/$exam->id/participant/$participant->attempt_id/subattempt/$participant->id") ?>" class="badge badge-info">DETAIL</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('#btn-reload').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi',
                text: 'Pemeringkatan akan dilakukan',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya'
            }).then((response) => {
                if (response.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("scoring/agregating/$exam->id") ?>",
                        method: 'POST',
                        success: (result) => {
                            if (result.ok) {
                                console.log(result);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Pemeringkatan selesai'
                                }).then(() => {
                                    window.location.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: result.message
                                })
                            }
                        },
                        error: (err) => {
                            console.log(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.statusText
                            })
                        }
                    })
                }
            })
        });
    });
</script>
<?= $this->endSection(); ?>