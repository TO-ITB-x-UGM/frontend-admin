<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <?= showAlert() ?>

    <a href="<?= base_url("package") ?>" class="btn btn-info mb-2"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
    <a class="btn btn-primary mb-2" id="btnTambahSoal"><i class="fas fa-plus-circle"></i> Tambah Soal</a>
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
                                    <td><?= substr(strip_tags($question->question_text), 0, 150) ?>...</td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?= base_url("package/$package_id/question/$question->id/edit") ?>" title="Lihat detail"><i class="fas fa-fw fa-edit"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal Pilihan Jenis Soal -->
    <div class="modal fade" id="jenisSoalModal" tabindex="-1" role="dialog" aria-labelledby="jenisSoalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jenisSoalModalLabel">Pilih Jenis Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Pilih jenis soal yang ingin Anda tambahkan:</p>
                    <button type="button" class="btn btn-primary" id="btnPilihanGanda">Pilihan Ganda</button>
                    <button type="button" class="btn btn-success" id="btnIsianSingkat">Isian Singkat</button>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js" integrity="sha512-ZESy0bnJYbtgTNGlAD+C2hIZCt4jKGF41T5jZnIXy4oP8CQqcrBGWyxNP16z70z/5Xy6TS/nUZ026WmvOcjNIQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Tampilkan modal jenis soal ketika tombol tambah soal ditekan
        $('#btnTambahSoal').click(function() {
            $('#jenisSoalModal').modal('show');
        });

        // Aksi saat tombol Pilihan Ganda ditekan
        $('#btnPilihanGanda').click(function() {
            window.location.href = "<?= base_url("package/$package_id/question/create/multiple_choice") ?>";
        });

        // Aksi saat tombol Isian Singkat ditekan
        $('#btnIsianSingkat').click(function() {
            window.location.href = "<?= base_url("package/$package_id/question/create/short_answer") ?>";
        });
    });
</script>
<?= $this->endSection(); ?>