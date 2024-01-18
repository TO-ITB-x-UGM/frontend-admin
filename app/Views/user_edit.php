<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>
<section class="content">
    <div class="card">
        <form action="<?= base_url('user/save') ?>" method="post">
            <div class="card-header">
                <h3 class="card-title">Form User</h3>

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
                    <label class="col-lg-3 col-form-label" for="username">Nama Lengkap</label>
                    <div class="col-lg-6">
                        <input name="name" type="text" class="form-control" id="username" required value="<?= old('name') ? old('name') : $name ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="email_address">Alamat Email</label>
                    <div class="col-lg-6">
                        <input name="email" type="email" class="form-control" id="email_address" required value="<?= old('email') ? old('email') : $email ?>">
                    </div>
                </div>
		<div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="password">Password</label>
                    <div class="col-lg-6">
                        <input name="password" type="password" class="form-control" id="password" required value="<?= old('password') ? old('password') : $password ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="phone_number">Phone</label>
                    <div class="col-lg-6">
                        <input name="phone_number" type="text" class="form-control" id="phone_number" value="<?= old('phone_number') ? old('phone_number') : $phone_number ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="school">Sekolah</label>
                    <div class="col-lg-6">
                        <input name="school" type="text" class="form-control" id="school" value="<?= old('school') ? old('school') : $school ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label" for="role_id">Role</label>
                    <div class="col-lg-6">
                        <select name="role_id" id="role_id" class="custom-select" required>
                            <option disabled selected>Pilih role</option>
                            <option value="1" <?= $selected_role_id == 1 ? 'selected' : "" ?>>Peserta</option>
                            <option value="9" <?= $selected_role_id == 9 ? 'selected' : "" ?>>Panitia</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                <button type="reset" class="btn btn-warning"><i class="fas fa-fw fa-undo"></i> Reset</button>
                <button type="button" id="btn-delete" data-id="<?= $id ?>" class="btn btn-danger"><i class="fas fa-fw fa-trash"></i> Hapus</button>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        $('#btn-delete').on('click', function() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah anda yakin?',
                text: 'User yang dihapus tidak bisa dipulihkan',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url("user/$id") ?>",
                        method: 'DELETE',
                        success: (result) => {
                            if (result.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'User berhasil dihapus'
                                }).then(() => {
                                    window.location.replace("<?= base_url("user/$role") ?>");
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
    });
</script>
<?= $this->endSection(); ?>
