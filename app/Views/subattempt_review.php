<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <div class="row">
        <div class="col-lg-9">
            <div class="mb-3">
                <a href="<?= base_url("tryout/$exam_id/participant/$attempt_id") ?>" class="btn btn-info"><i class="fas fa-fw fa-arrow-circle-left"></i> Kembali</a>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Peserta</h3>

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
                        <label class="col-lg-3 col-form-label" for="user_id">Attempt ID/Subattempt ID</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" readonly value="<?= $attempt_id ?>">
                        </div>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" readonly value="<?= $subattempt->id ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Tryout ID</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" readonly value="<?= $exam->id ?>">
                        </div>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" readonly value="<?= $exam->title ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Peserta ID</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" readonly value="<?= $user->id ?>">
                        </div>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" readonly value="<?= $user->name ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Subtest ID</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" readonly value="<?= $subtest->id ?>">
                        </div>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" readonly value="<?= $subtest->title ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label" for="user_id">Pengerjaan</label>
                        <div class="col-lg-1">
                            <input type="text" class="form-control" readonly value="<?= round(($subattempt->ended_at - $subattempt->started_at) / 60, 1) ?> mins">
                        </div>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" readonly value="<?= tanggal($subattempt->started_at) ?>">
                        </div>
                        <div class="col-lg-1">
                            <label class="col-form-label text-center">Sampai</label>
                        </div>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" readonly value="<?= tanggal($subattempt->ended_at) ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jawaban</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <th>No</th>
                            <th>Soal ID</th>
                            <th>Jawaban</th>
                            <th>Kunci</th>
                            <th>Score</th>
                        </thead>
                        <tbody>
                            <?php foreach ($answers as $i => $answer) : ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= $answer->question_id ?></td>
                                    <td><?= $answer->selected_id ?></td>
                                    <td><?= $answer->key_id ?></td>
                                    <td><?= $answer->marks ?></td>
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