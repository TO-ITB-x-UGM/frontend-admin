<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <?= showAlert() ?>

    <div class="card">
        <form action="<?= base_url("package/$package_id/question/save") ?>" method="post">
            <div class="card-header">
                <h3 class="card-title">Question Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="user_id">ID</label>
                    <div class="col-lg-3">
                        <input name="id" type="text" class="form-control" readonly value="<?= old('id') ? old('id') : $id ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="user_id">Package ID</label>
                    <div class="col-lg-3">
                        <input name="package_id" type="text" class="form-control" readonly value="<?= old('package_id') ? old('package_id') : $package_id ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="question_text">Question Text</label>
                    <div class="col-lg-9">
                        <textarea name="question_text" id="question_text" cols="30" rows="5" class="form-control summernote-question"><?= old('question_text') ? old('question_text') : $question_text ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="option_text_1">Option 1</label>
                    <div class="col-lg-9">
                        <textarea name="option_text_1" id="option_text_1" cols="30" rows="5" class="form-control summernote-option"><?= old('option_text_1') ? old('option_text_1') : $option_text_1 ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="option_text_2">Option 2</label>
                    <div class="col-lg-9">
                        <textarea name="option_text_2" id="option_text_2" cols="30" rows="5" class="form-control summernote-option"><?= old('option_text_2') ? old('option_text_2') : $option_text_2 ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="option_text_3">Option 3</label>
                    <div class="col-lg-9">
                        <textarea name="option_text_3" id="option_text_3" cols="30" rows="5" class="form-control summernote-option"><?= old('option_text_3') ? old('option_text_3') : $option_text_3 ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="option_text_4">Option 4</label>
                    <div class="col-lg-9">
                        <textarea name="option_text_4" id="option_text_4" cols="30" rows="5" class="form-control summernote-option"><?= old('option_text_4') ? old('option_text_4') : $option_text_4 ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="option_text_5">Option 5</label>
                    <div class="col-lg-9">
                        <textarea name="option_text_5" id="option_text_5" cols="30" rows="5" class="form-control summernote-option"><?= old('option_text_5') ? old('option_text_5') : $option_text_5 ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="correct_option_id">Correct Option</label>
                    <div class="col-lg-3">
                        <select name="correct_option_id" id="correct_option_id" class="custom-select" required>
                            <option selected disabled>Pilih Opsi yang Benar</option>
                            <option value="1" <?= ($correct_option_id == 1) ? 'selected' : '' ?>>A</option>
                            <option value="2" <?= ($correct_option_id == 2) ? 'selected' : '' ?>>B</option>
                            <option value="3" <?= ($correct_option_id == 3) ? 'selected' : '' ?>>C</option>
                            <option value="4" <?= ($correct_option_id == 4) ? 'selected' : '' ?>>D</option>
                            <option value="5" <?= ($correct_option_id == 5) ? 'selected' : '' ?>>E</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= base_url("package") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js" integrity="sha512-ZESy0bnJYbtgTNGlAD+C2hIZCt4jKGF41T5jZnIXy4oP8CQqcrBGWyxNP16z70z/5Xy6TS/nUZ026WmvOcjNIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $('#question_text').summernote({
        //     height: 300,
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear']],
        //         ['font', ['strikethrough', 'superscript', 'subscript']],
        //         ['color', ['color']],
        //         ['para', ['ul', 'ol']],
        //         ['insert', ['picture']],
        //     ],
        //     callbacks: {
        //         onImageUpload: function(image) {
        //             uploadImage($(this), image[0]);
        //         },
        //         onMediaDelete: function(target) {
        //             deleteImage(target[0].src);
        //         }
        //     }
        // });

        // $('.summernote-option').summernote({
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear']],
        //         ['font', ['strikethrough', 'superscript', 'subscript']],
        //     ]
        // });

        function uploadImage(obj, image) {
            var data = new FormData();
            data.append("image", image);
            $.ajax({
                url: '<?= env("Server_Base_URL") ?>/upload',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "post",
                success: function(res) {
                    console.log(res);
                    if (res.ok) {
                        $('#question_text').summernote("insertImage", res.data.url);
                    }
                },
                error: function(data) {
                    console.error(data);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: {
                    src: src
                },
                type: "post",
                url: "<?= env("Server_Base_URL") ?>/uploadDelete",
                cache: false,
                success: function(response) {
                    console.log(response);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#btn-delete').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Soal yang dihapus tidak bisa dipulihkan',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("question/$id") ?>",
                        method: 'DELETE',
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Soal berhasil dihapus'
                                }).then(() => {
                                    window.location.replace("<?= base_url("package/$package_id") ?>");
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
        })
    });
</script>
<?= $this->endSection(); ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<?= $this->endSection(); ?>