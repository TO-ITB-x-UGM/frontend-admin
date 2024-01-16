<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <form action="<?= base_url('user/import') ?>" method="post" enctype="multipart/form-data">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Upload Xlsx</h3>

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
                    <label for="fileinput" class="col-lg-3 col-form-label">File Xlsx</label>
                    <div class="col-lg-5">
                        <input type="file" name="file" id="fileinput" class="">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-next"></i> Selanjutnya</button>
            </div>
        </div>
    </form>
</section>
<?= $this->endSection(); ?>