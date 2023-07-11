<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5>Tambah Anggota KK</h5>
                    <hr>

                    <!-- anggota -->
                    <form action="<?= base_url('dashboard/add_anggota_kk/') . $id_kk; ?>" method="post">
                    <div class="control-group after-add-more">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik[]" id="nik" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama[]" id="nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk[]" id="jk" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                   <!--  <select name="th[]" id="th" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <?php
                                            for($i=date('Y'); $i>=date('Y')-100; $i-=1){
                                            echo"<option value='$i'> $i </option>";
                                            }
                                        ?>
                                    </select> -->
                                    <input type="date" class="form-control" name="th[]" id="th">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Status Warga</label>
                                    <select name="status_warga[]" id="status_warga" class="form-control">
                                    <option value="">--pilih--</option>
                                    <?php foreach($status_warga as $sw) { ?>
                                        <option value="<?= $sw->id_status ?>"><?= $sw->status_warga ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-1">
                                <span class="btn btn-secondary btn-sm mt-4 btn-add"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- end-anggota -->
                            <div class="mt-3">
                                <a href="<?= base_url('dashboard'); ?>" class="btn btn-dark btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah data</button>
                            </div>
                    
                    </form>

                    <!-- copy -->
                    <div class="copy" style="display: none;">
                    <div class="control-group">
                        <div class="row mt-3">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="number" name="nik[]" id="nik" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama[]" id="nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk[]" id="jk" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
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
                                            echo"<option value='$i'> $i </option>";
                                            }
                                        ?>
                                    </select> -->
                                    <input type="date" name="th[]" id="th" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Status Warga</label>
                                    <select name="status_warga[]" id="status_warga" class="form-control">
                                    <option value="">--pilih--</option>
                                    <?php foreach($status_warga as $sw) { ?>
                                        <option value="<?= $sw->id_status ?>"><?= $sw->status_warga ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <span class="btn btn-danger btn-sm mt-4 btn-remove"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- end-copy -->

                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function() {
        $(".btn-add").click(function(){ 
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".btn-remove",function(){ 
            $(this).parents(".control-group").remove();
        });
    });
</script>