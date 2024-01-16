<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <?= showAlert() ?>

    <div class="card">
        <form action="<?= base_url("tryout/$exam_id/subtest/save") ?>" method="post">
            <div class="card-header">
                <h3 class="card-title">Subtest Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="user_id">ID</label>
                    <div class="col-lg-3">
                        <input name="id" type="text" class="form-control" id="user_id" readonly value="<?= old('id') ? old('id') : $id ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="exam_id">Tryout ID</label>
                    <div class="col-lg-6">
                        <input name="exam_id" type="text" class="form-control" id="exam_id" readonly value="<?= old('exam_id') ? old('exam_id') : $exam_id ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="title">Judul Subtest</label>
                    <div class="col-lg-6">
                        <input name="title" type="text" class="form-control" id="title" required value="<?= old('title') ? old('title') : $subtest_title ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="title">Jenis</label>
                    <div class="col-lg-6">
                        <select name="type" id="type" class="custom-select">
                            <option value="1">TPS</option>
                            <option value="2">TKA</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="description">Durasi Pengerjaan (detik)</label>
                    <div class="col-lg-6">
                        <input name="attempt_duration" type="text" class="form-control" id="attempt_duration" value="<?= old('attempt_duration') ? old('attempt_duration') : $attempt_duration ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= base_url("tryout/$exam_id") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                <button type="reset" class="btn btn-warning"><i class="fas fa-fw fa-undo"></i> Reset</button>
                <button type="button" id="btn-delete" data-id="<?= $id ?>" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i> Hapus</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#attempt_open_at').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#attempt_closed_at').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#btn-delete').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Subtest yang sudah dihapus tidak bisa dipulihkan',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("subtest/$id") ?>",
                        method: 'DELETE',
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Subtest berhasil dihapus'
                                }).then(() => {
                                    window.location.replace("<?= base_url("tryout/$exam_id") ?>");
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

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
<?= $this->endSection(); ?>