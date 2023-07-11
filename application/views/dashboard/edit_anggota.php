<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-3 shadow">
                <div class="card-body">
                    <h5>Edit Anggota KK</h5>
                    <hr>

                    <?php if($this->session->flashdata('scs_msg')){ ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><?= $this->session->flashdata('scs_msg') ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>

                    <!-- Anggota kk -->
                    <div class="control-group after-add-more">
                        <form action="<?= base_url('dashboard/edit_anggota_kk/') . $id_kk; ?>" method="post">
                        <?php foreach($anggota as $a){ ?>
                        <div class="row mt-2">
                            <div class="col-lg-2">
                                <input type="hidden" name="id_anggota[]" value="<?= $a->id_anggota ?>">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik[]" value="<?= $a->nik ?>" id="nik" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama[]" id="nama" value="<?= $a->nama_lengkap ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk[]" id="jk" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <?php $jk = ['L','P']; foreach($jk as $j){ ?>
                                            <?php if($a->jk == $j){ ?>
                                                <option value="<?= $j ?>" selected><?= $j ?></option>
                                                <?php } else { ?>
                                                <option value="<?= $j ?>"><?= $j ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <!-- <select name="th[]" id="th" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <?php
                                            for($i=date('Y'); $i>=date('Y')-100; $i-=1){
                                        ?>

                                        <?php if($a->tahun_lahir == $i){ ?>
                                            <option value="<?= $i ?>" selected><?= $i ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php } ?>

                                        <?php } ?>
                                    </select> -->

                                    <input type="date" class="form-control" name="th[]" id="th" value="<?= $a->tahun_lahir ?>">
                                </div>
                            </div>
                            
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Status Warga</label>
                                    <select name="status_warga[]" id="status_warga" class="form-control">
                                    <option value="">--pilih--</option>
                                    <?php foreach($status_warga as $sw) { ?>
                                        <?php if($a->status_warga == $sw->id_status){ ?>
                                            <option value="<?= $sw->id_status ?>" selected><?= $sw->status_warga ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $sw->id_status ?>"><?= $sw->status_warga ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <a href="<?= base_url('dashboard/del_people/') . $this->uri->segment(3) . '/' . $a->id_anggota; ?>" onclick="return confirm('Data di hapus permanen, Apakah anda yakin?')" class="btn btn-danger mt-4 btn-sm"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="mt-3">
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-dark btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                        </form>
                    </div>
                    <!-- end Anggota kk -->


                </div>
            </div>
        </div>
    </div>
</div>