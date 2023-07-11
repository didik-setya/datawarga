<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mt-3">
                <div class="card-body">
                    <h5>Edit Data</h5>
                    <hr>
                    <div class="rt_hidden" data-rt="<?= $kk->rt ?>"></div>
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

                    <form action="" method="post" enctype="multipart/form-data">
                    <!-- form kk -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>No. KK</label>
                                <input type="number" value="<?= $kk->no_kk ?>" name="nokk" id="nokk" class="form-control">
                                <?= form_error('nokk','<small class="text-danger">','</small>'); ?>
                            </div>
                        </div>
                            
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. RW</label>
                                <select name="rw" id="rw" class="form-control" required>
                                    <option value="">--pilih--</option>
                                    <?php foreach($rw as $rw){ ?>
                                        <?php if($rw->id_rw == $kk->rw){ ?>
                                            <option value="<?= $rw->id_rw ?>" selected><?= $rw->no_rw ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $rw->id_rw ?>"><?= $rw->no_rw ?></option>
                                        <?php } ?>
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
                                <input type="text" value="<?= $kk->rw ?>" name="no_rumah" id="no_rumah" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>No. Rumah Baru</label>
                                <input type="text" value="<?= $kk->no_rumah_baru ?>" name="no_new" id="no_new" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Status Rumah</label>
                                <select name="status_rumah" required id="status_rumah" class="form-control">
                                    <option value="">--Pilih--</option>
                                    <?php foreach($status_rumah as $sr){ ?>
                                        <?php if($kk->status_rumah == $sr->id_status){ ?>
                                            <option value="<?= $sr->id_status ?>" selected><?= $sr->nama_status ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $sr->id_status ?>"><?= $sr->nama_status ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat KK</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="5"><?= $kk->alamat_ktp ?></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Alamat Domisili Tegalgede</label>
                                <textarea name="domisili" id="domisili" class="form-control" rows="5"><?= $kk->alamat_domisili ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Ket. Rumah</label>
                                <textarea name="rumah" id="rumah" class="form-control" rows="5"><?= $kk->ket_rumah ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-3">
                            <div class="ket-bantuan">
                            <div class="form-group">
                                <label>Ket. Bantuan</label>
                                <select name="bantuan" id="bantuan" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <?php $bantuan = ['Sudah','Belum']; foreach($bantuan as $b){ ?>
                                        <?php if($b == $kk->ket_bantuan){ ?>
                                            <option value="<?= $b ?>" selected><?= $b ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $b ?>"><?= $b ?></option>
                                        <?php } ?>
                                        <?php } ?>
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
                                                ?>

                                                    <?php if($i == $kk->tahun_bantuan){ ?>
                                                        <option value="<?= $i ?>" selected><?= $i ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php } ?>

                                                <?php } ?>
                                            </select>
                                </div>
                            </div>

                            <div class="jenis-bantuan d-none">
                                <div class="form-group mt-2">
                                    <label>Jenis Bantuan</label>
                                    <select name="jenis_bantuan" id="jenis_bantuan" class="form-control">
                                        <option value="">--pilih--</option>
                                        <?php foreach($jenis_bantuan as $jb){ ?>
                                            <?php if($kk->jenis_bantuan == $jb->id_jenis) { ?>
                                                <option value="<?= $jb->id_jenis ?>" selected><?= $jb->jenis_bantuan ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $jb->id_jenis ?>"><?= $jb->jenis_bantuan ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="col-lg-6 mt-3">

                            <div class="form-group mt-2">
                                    <label>No. PBB</label>
                                    <input type="text" name="no_nop" value="<?= $kk->no_nop_pbb ?>" id="no_nop" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Status PBB</label>
                                <select name="nop_pbb" required id="nop_pbb" class="form-control">
                                    <option value="">--pilih--</option>
                                    <?php $nop = ['Sudah', 'Belum'];
                                        foreach($nop as $n){
                                    ?>
                                        <?php if($kk->nop_pbb == $n){ ?>
                                                <option value="<?= $n ?>" selected><?= $n ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $n ?>"><?= $n ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="tahun-nop d-none mt-2">
                                <div class="form-group">
                                    <label>Tahun PBB</label>
                                    <select name="tahun_nop" class="form-control" id="tahun_nop">
                                        <option value="">--pilih--</option>
                                        <?php
                                            for($i=date('Y'); $i>=date('Y')-30; $i-=1){ ?> 
                                            <?php if($kk->tahun_nop_pbb == $i){ ?>
                                                <option value='<?= $i ?>' selected> <?= $i ?> </option>
                                            <?php } else { ?>
                                                <option value='<?= $i ?>'> <?= $i ?> </option>
                                            <?php } ?>
                                        <?php } ?>
                                        
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

                        <div class="col-lg-6 mt-3">
                            <div class="form-group">
                                <label>Dokumen KK</label>
                                <?php if($kk->doc_kk == ''){ ?>
                                    <p class="text-center">No Data Result</p>
                                <?php } else { ?>
                                    <?php if($kk->doc_exc == '.pdf'){ ?>   
                                        <embed src="<?= base_url('assets/docs/') . $kk->doc_kk ?>" width="100%" height="300px"/>
                                    <?php } else { ?>
                                        <img src="<?= base_url('assets/docs/') . $kk->doc_kk ?>" width="100%">
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>


                        <hr class="mt-3">
                    </div>
                    <!-- end form kk -->

                    <!-- btn submit -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <a href="<?= base_url('dashboard'); ?>" class="btn btn-sm btn-dark"><i class="fa fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit Data</button>
                        </div>
                    </div>
                    <!-- end btn submit -->

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     $(document).ready(function() {
        $(".btn-add").click(function(){ 
            console.log('ok');
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });
        $("body").on("click",".btn-remove",function(){ 
            $(this).parents(".control-group").remove();
        });
    });


    var rt_real = $('.rt_hidden').data('rt');
    var rw = $('#rw').val();


    if(rw != ''){
        $.ajax({
            url: '<?= base_url('dashboard/getRTbyRW'); ?>',
            data: {rw: rw},
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                let rt = '<option value="">--pilih--</option>';
                let i;
                for(i=0; i < d.length; i++){
                    if(rt_real == d[i].id_rt){
                        rt += '<option value="'+ d[i].id_rt +'" selected>'+ d[i].no_rt +'</option>';
                    } else {
                        rt += '<option value="'+ d[i].id_rt +'">'+ d[i].no_rt +'</option>';
                    }
                }
                $('#rt').html(rt);
            }
        });
    }



    var bantuan = $('#bantuan').val();
        if(bantuan == 'Sudah'){
            $('.thn-bantuan').removeClass('d-none');
            $('.jenis-bantuan').removeClass('d-none');
        }

    var nop_pbb = $('#nop_pbb').val();
    if(nop_pbb == 'Sudah'){
        $('.tahun-nop').removeClass('d-none');
    }


    $('#bantuan').on('change', function(){
            const bantuan = $('#bantuan').val();
            // console.log(bantuan);
            if(bantuan == 'Sudah'){
                $('.thn-bantuan').removeClass('d-none');
                $('.jenis-bantuan').removeClass('d-none');

                $('#thnbantuan').attr('required', true);
                $('#jenis_bantuan').attr('required', true);

            //    console.log('sudah');
            } else if(bantuan == 'Belum'){
                $('.thn-bantuan').addClass('d-none');
                $('.jenis-bantuan').addClass('d-none');

                $('#thnbantuan').removeAttr('required');
                $('#jenis_bantuan').removeAttr('required');
                $('#thnbantuan').val('');
                $('#jenis_bantuan').val('');
            //    console.log('belum');
            } else if(bantuan == ''){
                $('.thn-bantuan').addClass('d-none');
                $('.jenis-bantuan').addClass('d-none');

                $('#thnbantuan').removeAttr('required');
                $('#jenis_bantuan').removeAttr('required');
                $('#thnbantuan').val('');
                $('#jenis_bantuan').val('');
            }
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

                $('#no_nop').attr('required', true);
                $('#tahun_nop').attr('required', true);
            //    console.log('sudah');
            } else if(nop == 'Belum'){
                $('.tahun-nop').addClass('d-none');

                $('#no_nop').removeAttr('required');
                $('#tahun_nop').removeAttr('required');
               
                $('#tahun_nop').val('');
            //    console.log('belum');
            } else if(nop == ''){
                $('.tahun-nop').addClass('d-none');

                $('#no_nop').removeAttr('required');
                $('#tahun_nop').removeAttr('required');
          
                $('#tahun_nop').val('');
            }
    });

</script>