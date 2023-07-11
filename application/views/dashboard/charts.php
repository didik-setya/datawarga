<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    
                    <div class="row justify-content-center">
                        <!-- <div class="col-lg-12">
                            <p>Total Jumlah Semua Warga: <?= $warga ?> Warga</p>
                        </div> -->
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label><b>Bulan dan Tahun</b></label>
                                        <?php if(isset($bulan)){?>
                                            <input type="month" id="bulan" name="bulan" class="form-control form" value="<?= $bulan ?>">
                                        <?php }else{ ?>
                                            <input type="month" id="bulan" name="bulan" class="form-control form">
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="form-group">
                                        <label><b>RW</b></label>
                                        <select name="rw" id="rw" class="form-control form">
                                            <option value="">--Semua--</option>
                                            <?php foreach($rw as $rw){ ?>
                                                <?php if($_GET['rw'] == $rw->id_rw){ ?>
                                                    <option value="<?= $rw->id_rw ?>" selected><?= $rw->no_rw ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $rw->id_rw ?>"><?= $rw->no_rw ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label ><b>Pilih Grafik</b></label>
                                                <select name="jenis_grafik" id="jenis_grafik" class="form-control form">
                                                    <option value="" <?= (isset($jenis_grafik)) ? false : 'selected' ?>>-- Pilih Grafik --</option>
                                                    <option value="jumlah_penduduk" <?php if(isset($jenis_grafik)){echo ( $jenis_grafik == 'jumlah_penduduk' ? 'selected' : false);}?>>Jenis Kelamin</option>
                                                    <option value="bantuan" <?php if(isset($jenis_grafik)){echo ( $jenis_grafik == 'bantuan' ? 'selected' : false);}?>>Bantuan</option>
                                                    <option value="status" <?php if(isset($jenis_grafik)){echo ( $jenis_grafik == 'status' ? 'selected' : false);}?>>Status Warga</option>
                                                <!-- PENAMBAHAN FITUR -->
                                                    <option value="umur" <?php if (isset($jenis_grafik)) {
                                                                                echo ($jenis_grafik == 'umur' ? 'selected' : false);
                                                                            } ?>>Usia</option>
                                                    <!-- END PENAMBAHAN FITUR -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>



        
                            </div>
                            
                        </div>
                        <div class="col-lg-6">
                            <canvas id="charts" width="100%" height="50"></canvas>
                        </div>
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</div>


<?php if(isset($jumlah_penduduk)){ ?>
    <div class="data-warga" data-warga="<?= $warga ?>" data-l="<?= $L ?>" data-p="<?= $P ?>"></div>
<?php } ?>


<script>
    
    $( ".form" ).change(function() {
        let bulan = $('#bulan').val();
        let rw = $('#rw').val();
        let jenis_grafik = $('#jenis_grafik').val();

        if(jenis_grafik !== ''){
            if(rw == ''){
                if(bulan == ''){
                    window.location.href = '<?= base_url('dashboard/grafic?rw=') ?>'+'&jenis_grafik=' + jenis_grafik + '&bulan=';
                }else{
                    window.location.href = '<?= base_url('dashboard/grafic?rw=') ?>'+'&jenis_grafik=' + jenis_grafik + '&bulan=' + bulan;
                }
            } else {
                if(bulan == ''){
                    window.location.href = '<?= base_url('dashboard/grafic?rw=') ?>' + rw +'&jenis_grafik=' + jenis_grafik + '&bulan=';
                } else {
                    window.location.href = '<?= base_url('dashboard/grafic?rw=') ?>' + rw +'&jenis_grafik=' + jenis_grafik +'&bulan='+bulan;
                }
            }
        }
    });
</script>


<?php if(isset($jumlah_penduduk)){ ?>
    <script>
        const warga_all = $('.data-warga').data('warga');
        const ctx = document.getElementById('charts');

        const jml = $('.data-rw').data('jml');
        const no_rw = $('.data-rw').data('rw');
        const l = $('.data-warga').data('l');
        const p = $('.data-warga').data('p');

        const data = {
                labels: [
                    'Semua Warga',
                    'Laki - Laki',
                    'Perempuan',
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [warga_all, l, p],
                    backgroundColor: [
                        '#0FFF00',
                        '#FF0000',
                        '#0057F5'
                    ],
                    borderColor: [
                        '#0FFF00',
                        '#FF0000',
                        '#0057F5'
                    ],
                    
                    borderWidth: 2,
                    minBarLength: 10
                }]
            };
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                scales: {
                    y: {
                        beginAtZero: true
                        }
                    }
                },
            });


    </script>
<?php } ?>

<?php if(isset($bantuan)){ ?>
    <script>
        const ctx = document.getElementById('charts');
        const data = {
                labels: <?= json_encode($nama_bantuan) ?>,
                datasets: [{
                    label: "Grafik Bantuan",
                    data: <?= json_encode($jumlah_bantuan) ?>,
                    backgroundColor: <?= json_encode($color) ?>,
                    borderColor: <?= json_encode($color) ?>,
                    
                    borderWidth: 2,
                    minBarLength: 10
                }]
            };
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                scales: {
                    y: {
                        beginAtZero: true
                        }
                    }
                },
            });
    </script>
<?php } ?>

<?php if(isset($status)){ ?>
    <script>
        const ctx = document.getElementById('charts');
        const data = {
                labels: <?= json_encode($nama_status) ?>,
                datasets: [{
                    label: "Grafik Status Warga",
                    data: <?= json_encode($jumlah_status) ?>,
                    backgroundColor: <?= json_encode($color) ?>,
                    borderColor: <?= json_encode($color) ?>,
                    
                    borderWidth: 2,
                    minBarLength: 10
                }]
            };
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                scales: {
                    y: {
                        beginAtZero: true
                        }
                    }
                },
            });
    </script>
<?php } ?>

<!-- PENAMBAHAN FITUR -->
<?php if (isset($umur)) { ?>
    <script>
        const ctx = document.getElementById('charts');
        const data = {
            labels: <?= json_encode($nama_umur) ?>,
            datasets: [{
                label: "Laki - laki",
                data: <?= json_encode($jumlah_umur_laki) ?>,
                backgroundColor: <?= json_encode($color_laki) ?>,
                borderColor: <?= json_encode($color_laki) ?>,

                borderWidth: 2,
                minBarLength: 10
            },{
                label: "Perempuan",
                data: <?= json_encode($jumlah_umur_perempuan) ?>,
                backgroundColor: <?= json_encode($color_perempuan) ?>,
                borderColor: <?= json_encode($color_perempuan) ?>,

                borderWidth: 2,
                minBarLength: 10
            }]
        };
        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    </script>
<?php } ?>
<!-- END PENAMBAHAN FITUR -->

