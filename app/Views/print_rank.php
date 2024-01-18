<?= $this->extend('layouts/print'); ?>

<?= $this->section('content'); ?>
<div class="text-center">
    <h3><?= $title ?></h3>
</div>
<section class="fs-6">
    <table class="table">
        <thead>
            <th>#</th>
            <th>Nama</th>
            <th>Sekolah</th>
            <?php foreach ($subtests as $subtest) : ?>
                <th><?= $subtest->acr ?></th>
            <?php endforeach; ?>
            <th><b>Nilai Akhir</b></th>
        </thead>
        <tbody>
            <?php foreach ($participants as $i => $participant) : ?>
                <tr>
                    <td><?= ($i + 1) ?></td>
                    <td><?= $participant->name ?></td>
                    <td><?= $participant->school ?></td>
                    <?php foreach ($participant->subtests as $subtest) : ?>
                        <td><?= $subtest ?></td>
                    <?php endforeach; ?>
                    <td><?= $participant->score_agregate ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?= $this->endSection(); ?>