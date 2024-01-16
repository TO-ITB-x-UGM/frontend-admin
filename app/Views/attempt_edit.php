<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <div class="row">
        <div class="col-lg-12">
            <form action="<?= base_url("tryout/$exam_id/participant/save") ?>" method="post">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Attempt</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="user_id">ID</label>
                            <div class="col-lg-3">
                                <input name="id" type="text" class="form-control" id="id" readonly value="<?= old('id') ? old('id') : $id ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="user_id">Tryout ID</label>
                            <div class="col-lg-3">
                                <input name="exam_id" type="text" class="form-control" id="exam_id" readonly value="<?= old('exam_id') ? old('exam_id') : $exam_id ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-lg-3 col-form-label">Email</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" name="email" id="email" class="form-control" value="<?= old('email') ? old('email') : $email ?>">
                                    <span class="input-group-append">
                                        <button type="button" id="email-check" class="btn btn-info btn-flat">Cek Email</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="user_id">Nama Peserta</label>
                            <div class="col-lg-6">
                                <input name="user_name" type="text" class="form-control" id="user_name" readonly value="<?= old('user_name') ? old('user_name') : $user_name ?>">
                                <input type="hidden" name="user_id" id="user_id" value="<?= old('user_id') ? old('user_id') : $user_id ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="started_at">Mulai Pengerjaan</label>
                            <div class="col-lg-6">
                                <div class="input-group date" id="started_at" data-target-input="nearest">
                                    <input name="started_at" type="text" class="form-control datetimepicker-input" data-target="#started_at" value="<?= old('started_at') ? old('started_at') : tanggalN($started_at) ?>" />
                                    <div class="input-group-append" data-target="#started_at" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="ended_at">Batas Akhir Pengerjaan</label>
                            <div class="col-lg-6">
                                <div class="input-group date" id="ended_at" data-target-input="nearest">
                                    <input name="ended_at" type="text" class="form-control datetimepicker-input" data-target="#ended_at" value="<?= old('ended_at') ? old('ended_at') : tanggalN($ended_at) ?>" />
                                    <div class="input-group-append" data-target="#ended_at" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="score_agregate">Score Agregate</label>
                            <div class="col-lg-3">
                                <input type="text" class="form-control" id="score_agregate" readonly value="<?= old('score_agregate') ? old('score_agregate') : $score_agregate ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url("tryout/$exam_id/participant") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                        <button type="reset" class="btn btn-warning"><i class="fas fa-fw fa-undo"></i> Reset</button>
                        <button type="button" id="btn-delete" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i> Hapus</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<?= $this->section('js') ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#started_at').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#ended_at').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
    });
</script>
<script>
    $('#email-check').on('click', function() {
        email = $('#email').val();
        $.ajax({
            url: '<?= base_url("user/check?email=") ?>' + email,
            method: 'GET',
            success: (result) => {
                if (result.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'User ditemukan',
                        timer: 1500
                    });
                    $('#user_name').val(result.data.name);
                    $('#user_id').val(result.data.id);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.message,
                    });
                }
            }
        });
    });

    $(document).ready(function() {
        $('#btn-delete').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Peserta yang dihapus tidak bisa dipulihkan',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("attempt/$id") ?>",
                        method: 'DELETE',
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Peserta berhasil dihapus'
                                }).then(() => {
                                    window.location.replace("<?= base_url("tryout/$exam_id/participant") ?>");
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
                                text: err.responseJSON.message
                            });
                        }
                    })

                }
            })
        })
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
<?= $this->endSection(); ?>