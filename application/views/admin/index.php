<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5>Settings</h5>
                    
                    <hr>
<?php if($this->session->flashdata('err_msg')){ ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?= $this->session->flashdata('err_msg') ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php } else if($this->session->flashdata('scs_msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong><?= $this->session->flashdata('scs_msg') ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <?php } ?>
                    <form action="<?= base_url('admin'); ?>" method="post">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Nama Admin</label>
                                <input type="text" name="nama" value="<?= $admin->nama_admin ?>" id="nama" class="form-control">
                                <?= form_error('nama','<small class="text-danger">','</small>'); ?>
                            </div>
                            <div class="form-group mt-2">
                                <label>Username Admin</label>
                                <input type="text" name="username" disabled value="<?= $admin->username ?>" id="username" class="form-control">
                                <?= form_error('username','<small class="text-danger">','</small>'); ?>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Simpan</button>
                            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fas fa-key"></i> Ubah Password</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Ubah Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('admin/edit_pass'); ?>" method="post">
      <div class="modal-body">
        <div class="form-group">
          <label>Password Lama</label>
          <input type="password" name="pl" id="pl" class="form-control">
        </div>
        <div class="form-group">
          <label>Password Baru</label>
          <input type="password" name="pb" id="pb" class="form-control">
        </div>
        <div class="form-group">
          <label>Konfirmasi Password Baru</label>
          <input type="password" name="kp" id="kp" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Ubah</button>
      </div>
      </form>
    </div>
  </div>
</div>