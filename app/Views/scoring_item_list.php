<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">

    <div class="callout callout-warning">
        <h5>Perhatian!</h5>
        <p>Sebelum melakukan scoring, pastikan semua peserta telah selesai mengerjakan subtest.</p>
        <p class="mb-0">Penjelasan mengenai tahapan scoring:</p>
        <ul>
            <li><span class="badge badge-primary">Prescoring</span> adalah tahapan menentukan benar dan salah jawaban peserta berdasarkan kunci jawaban yang ada dan menghitung total B, K, S dari masing-masing soal</li>
            <li><span class="badge badge-danger">Weighting</span> adalah tahapan menghitung nilai untuk setiap soal apabila peserta menjawab benar</li>
            <li><span class="badge badge-warning">Distributing</span> adalah tahapan mendistribusikan nilai setiap nomor untuk setiap peserta</li>
            <li><span class="badge badge-success">Summarizing</span> adalah tahapan menghitung nilai peserta untuk subtest tertentu</li>
        </ul>
    </div>
    <a href="<?= base_url("tryout/$exam_id") ?>" class="btn btn-info mb-3"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
    <button type="button" id="btn-preparing" class="btn btn-primary mb-3"><i class="fas fa-fw fa-sync"></i> Prescoring</button>
    <button type="button" id="btn-weighting" class="btn btn-danger mb-3"><i class="fas fa-fw fa-balance-scale"></i> Weighting</button>
    <button type="button" id="btn-distributing" class="btn btn-warning mb-3"><i class="fas fa-fw fa-paper-plane"></i> Distributing</button>
    <button type="button" id="btn-summarizing" class="btn btn-success mb-3"><i class="fas fa-fw fa-book"></i> Summarizing</button>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row form-group">
                        <label for="" class="col-form-label col-4">Jumlah Soal</label>
                        <div class="col-8">
                            <input type="text" name="" id="" class="form-control" readonly value="<?= count($questions) ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="" class="col-form-label col-4">Jumlah Peserta</label>
                        <div class="col-8">
                            <input type="text" name="" id="" class="form-control" readonly value="<?= $questions[0]->total_attempt ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Soal dan Statistik Jawaban Peserta</h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Soal ID</th>
                        <th>Benar</th>
                        <th>Salah</th>
                        <th>Kosong</th>
                        <th>% benar</th>
                        <th>Score</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $i => $question) : ?>
                        <tr>
                            <td><?= ($i + 1) ?></td>
                            <td><?= $question->question_id ?></td>
                            <td><?= $question->total_correct ?></td>
                            <td><?= $question->total_incorrect ?></td>
                            <td><?= $question->total_null ?></td>
                            <td><?= ($question->total_attempt) ? round($question->total_correct / $question->total_attempt, 4) * 100 : 0 ?>%</td>
                            <td><?= $question->marks  ?></td>
                            <td>
                                <a href="" class="btn btn-warning btn-xs btn-edit"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            Footer
        </div>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    $(document).ready(function() {
        $('#btn-preparing').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Pastikan semua peserta telah menyelesaikan tryout',
                confirmButtonText: "Ya, lakukan",
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("scoring/preparing/$subtest_id") ?>",
                        method: 'POST',
                        data: {

                        },
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Preparing berhasil'
                                }).then(() => {
                                    window.location.reload();
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
            });
        });

        $('#btn-weighting').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Pastikan anda telah melakukan tahapan sebelumnya',
                confirmButtonText: "Ya, lakukan",
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("scoring/weighting/$subtest_id") ?>",
                        method: 'POST',
                        data: {

                        },
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Weighting berhasil'
                                }).then(() => {
                                    window.location.reload();
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
            });
        });

        $('#btn-distributing').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Pastikan anda telah melakukan tahapan sebelumnya',
                confirmButtonText: "Ya, lakukan",
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("scoring/distributing/$subtest_id") ?>",
                        method: 'POST',
                        data: {

                        },
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Distributing berhasil'
                                }).then(() => {
                                    window.location.reload();
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
            });
        });

        $('#btn-summarizing').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'Pastikan anda telah melakukan tahapan sebelumnya',
                confirmButtonText: "Ya, lakukan",
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("scoring/summarizing/$subtest_id") ?>",
                        method: 'POST',
                        data: {

                        },
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Summarizing berhasil'
                                }).then(() => {
                                    window.location.reload();
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
            });
        });

    });
</script>
<?= $this->endSection(); ?>