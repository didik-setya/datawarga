<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5>Tambah Data</h5>
                    <hr>
                    <form action="<?= base_url('dashboard/add'); ?>" method="post" enctype="multipart/form-data">

                    <!-- form kk -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>No. KK</label>
                                <input type="number" value="<?= set_value('nokk'); ?>" name="nokk" id="nokk" class="form-control">
                                <?= form_error('nokk','<small class="text-danger">','</small>'); ?>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. RW</label>
                                <select name="rw" id="rw" class="form-control" required>
                                    <option value="">--pilih--</option>
                                    <?php foreach($rw as $rw){ ?>
                                        <option value="<?= $rw->id_rw ?>"><?= $rw->no_rw ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. RT</label>
                                <select name="rt" id="rt" required class="form-control">
                                    <option value="">--pilih--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah</label>
                                <input type="text" value="<?= set_value('no_rumah'); ?>" name="no_rumah" id="no_rumah" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah Baru</label>
                                <input type="text" value="<?= set_value('no_new'); ?>" name="no_new" id="no_new" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Status Rumah</label>
                                <select name="status_rumah" required id="status_rumah" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php foreach($status_rumah as $sr){ ?>
                                        <option value="<?= $sr->id_status ?>"><?= $sr->nama_status ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat KK</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="5"><?= set_value('alamat'); ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat Domisili Tegalgede</label>
                                <textarea name="alamat_domisili" id="alamat_domisili" class="form-control" rows="5"><?= set_value('alamat_domisili'); ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Ket. Rumah</label>
                                <textarea name="rumah" id="rumah" class="form-control" rows="5"><?= set_value('rumah'); ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="ket-bantuan">
                            <div class="form-group">
                                <label>Ket. Bantuan</label>
                                <select name="bantuan" id="bantuan" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>
                            </div>

                            <div class="thn-bantuan d-none">
                                <div class="form-group mt-2">
                                            <label>Tahun Menerima Bantuan</label>
                                            <select name="thnbantuan" id="thnbantuan" class="form-control">
                                                <option value="">--Pilih--</option>
                                                <?php
                                                for($i=date('Y'); $i>=date('Y')-30; $i-=1){
                                                echo"<option value='$i'> $i </option>";
                                                }
                                            ?>
                                            </select>
                                </div>
                            </div>

                            <div class="jenis-bantuan d-none">
                                <div class="form-group mt-2">
                                    <label>Jenis Bantuan</label>
                                    <select name="jenis_bantuan" id="jenis_bantuan" class="form-control">
                                        <option value="">--pilih--</option>
                                        <?php foreach($jenis_bantuan as $jb){ ?>
                                            <option value="<?= $jb->id_jenis ?>"><?= $jb->jenis_bantuan ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="col-lg-6 mt-3">

                            <div class="form-group mt-2">
                                    <label>No. PBB</label>
                                    <input type="text" name="no_nop" id="no_nop" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Status PBB</label>
                                <select name="nop_pbb" required id="nop_pbb" class="form-control">
                                    <option value="">--pilih--</option>
                                    <option value="Sudah">Sudah</option>
                                    <option value="Belum">Belum</option>
                                </select>
                            </div>

                            <div class="tahun-nop d-none mt-2">
                                <div class="form-group">
                                    <label>Tahun PBB</label>
                                    <select name="tahun_nop" class="form-control" id="tahun_nop">
                                        <option value="">--pilih--</option>
                                        <?php
                                            for($i=date('Y'); $i>=date('Y')-30; $i-=1){
                                                echo"<option value='$i'> $i </option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Dokumen KK</label>
                                <input type="file" name="docs" id="docs" class="form-control">
                                <small class="text-danger">File JPG, PNG, JPEG & PDF</small>
                            </div>
                        </div>
                        
                        <hr class="mt-3">
                    </div>
                    <!-- end form kk -->


                    <h5>Anggota KK</h5>
                    
                    <!-- Anggota kk -->
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
                    <!-- end Anggota kk -->

                    

                    <!-- btn submit -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Tambah Data</button>

                        </div>
                    </div>
                    <!-- end btn submit -->

                    </form>


                   
                    
                    <!-- copy-form -->

                <div class="copy" style="display: none;">
                    <div class="control-group theCopy">
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
                                <span class="btn btn-danger btn-sm mt-4 btn-remove"><i class="fa fa-times"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- end-copy-form -->


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


        $('#bantuan').on('change', function(){
            let bantuan = $(this).val();

            if(bantuan == 'Belum'){
                $('.thn-bantuan').addClass('d-none');
                $('.jenis-bantuan').addClass('d-none');

                $('#thnbantuan').removeAttr('required');
                $('#jenis_bantuan').removeAttr('required');
            } else if(bantuan == 'Sudah'){
                $('.thn-bantuan').removeClass('d-none');
                $('.jenis-bantuan').removeClass('d-none');

                $('#thnbantuan').attr('required', true);
                $('#jenis_bantuan').attr('required', true);
            } else if(bantuan == ''){
                $('.thn-bantuan').addClass('d-none');
                $('.jenis-bantuan').addClass('d-none');

                $('#thnbantuan').removeAttr('required');
                $('#jenis_bantuan').removeAttr('required');
            }

           
        });
    });


    $('#rw').change(function(){
        let rw = $(this).val();
        $.ajax({
            url: '<?= base_url('dashboard/getRTbyRW'); ?>',
            data: {rw: rw},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                let rt = '<option value="">--pilih--</option>';
                let i;
                for(i=0; i < d.length; i++){
                    rt += '<option value="'+ d[i].id_rt +'">'+ d[i].no_rt +'</option>';
                }
                $('#rt').html(rt);
            }   
        });
    });
    
    $('#nop_pbb').change(function(){
        let nop = $(this).val();

            if(nop == 'Sudah'){
                $('.tahun-nop').removeClass('d-none');
                $('#tahun_nop').attr('required', true);
                $('#no_nop').attr('required', true);
            //    console.log('sudah');
            } else if(nop == 'Belum'){
                $('.tahun-nop').addClass('d-none');
                $('#tahun_nop').removeAttr('required');
                $('#no_nop').removeAttr('required');
                $('#tahun_nop').val('');
            //    console.log('belum');
            } else if(nop == ''){
                $('.tahun-nop').addClass('d-none');
                $('#tahun_nop').removeAttr('required');
                $('#no_nop').removeAttr('required');
                $('#tahun_nop').val('');
            }
    });

</script>