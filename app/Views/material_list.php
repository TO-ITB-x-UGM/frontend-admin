<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <a href="<?= base_url("tryout/$exam_id") ?>" class="btn btn-info mb-2"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
    <!-- <a href="<?= base_url("tryout/$exam_id/subtest/$subtest_id/question/add") ?>" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i> Import dari paket soal</a> -->
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#addFromPackage"><i class="fas fa-plus-circle"></i> Import dari paket soal</button>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Soal</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Teks Soal</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $i => $question) : ?>
                                <tr style="max-height: 50px; overflow:hidden;">
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= substr(strip_tags($question->question_text), 0, 150) ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" href="<?= base_url("package/$question->package_id/question/$question->id/view") ?>" title="Lihat soal dan analisis"><i class="fas fa-fw fa-poll"></i></a>
                                        <button class="btn btn-danger btn-xs btn-delete" data-qindex_id="<?= $question->id ?>"><i class="fas fa-fw fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addFromPackage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Impor Paket Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="package_id" class="col-form-label col-md-3">Paket Soal</label>
                        <div class="col-md-9">
                            <select name="package_id" id="package_id" class="custom-select">
                                <option disabled selected>Pilih Paket Soal</option>
                                <?php foreach ($packages as $package) : ?>
                                    <option value="<?= $package->id ?>"><?= $package->title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="btn-import" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function() {
        $('#btn-import').on('click', function() {

            $.ajax({
                url: "<?= base_url("tryout/$exam_id/subtest/$subtest_id/question/import") ?>",
                method: 'POST',
                data: {
                    package_id: $('#package_id').val(),
                    subtest_id: <?= $subtest_id ?>
                },
                success: (res) => {
                    if (res.ok) {
                        console.log(res);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.data.total_inserted + " question(s) imported"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        console.log(res);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message
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
        })

        $('.btn-delete').on('click', function() {
            const qindex_id = $(this).data('qindex_id');

            Swal.fire({
                icon: 'question',
                title: 'Are you sure?',
                text: "Pertanyaan akan dihapus dari tryout, masih ada di database",
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("material") ?>/" + qindex_id,
                        method: "DELETE",
                        success: (res) => {
                            if (res.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Soal telah dihapus'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                console.log(res);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: res.message
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