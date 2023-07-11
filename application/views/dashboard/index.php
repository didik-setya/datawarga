<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow mt-3 mb-5">
        <div class="card-body">
          <h5>Data Masyarakat</h5>
          <?= $this->uri->segment(2) ?>
          <hr>
          <a href="<?= base_url('dashboard/add'); ?>" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah Data</a>
          <a href="<?= base_url('dashboard/export_excel'); ?>" class="btn btn-success export-excel"><i class="far fa-file-excel"></i> Export Excel</a>
          <a href="<?= base_url('dashboard/grafic') ?>" class="btn btn-primary">Charts</a>

          <a href="<?= base_url('dashboard'); ?>" class="btn btn-dark"><i class="fa fa-redo"></i> Refresh Data</a>

          <div class="table-responsive-xxl">
            <br>

            <?php if ($this->session->flashdata('err_msg')) { ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $this->session->flashdata('err_msg') ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php } else if ($this->session->flashdata('scs_msg')) { ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $this->session->flashdata('scs_msg') ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php } ?>
            <div class="row mb-3">
                
            <!-- FILTER BY DATE -->
              <div class="col-lg-2">
                <div class="form-group">
                  <label><b>Bulan</b></label>
                  <?php if(isset($_GET['filter_date'])){?>
                    <input type="month" id="filter_date" name="filter_date" class="form-control filter" value="<?= $_GET['filter_date'] ?>">
                  <?php }else{ ?>
                    <input type="month" id="filter_date" name="filter_date" class="form-control filter">
                  <?php } ?>
                </div>
              </div>


              <div class="col-lg-2">
                <div class="form-group">
                  <label><b> No. RW</b></label>
                  <select name="filter_rw" id="filter_rw" class="form-control filter">
                    <option value="">--All--</option>
                    <?php foreach ($rw as $rw) { ?>
                      <?php if ($_GET['filter_rw'] == $rw->id_rw) { ?>
                        <option value="<?= $rw->id_rw ?>" selected><?= $rw->no_rw ?></option>
                      <?php } else { ?>
                        <option value="<?= $rw->id_rw ?>"><?= $rw->no_rw ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-lg-2">
                <div class="form-group">
                  <label><b>No. Rt</b></label>
                  <select name="filter_rt" id="filter_rt" class="form-control filter">
                    <option value="">--All--</option>

                    <?php if (isset($_GET['filter_rw'])) {
                      $rt = $this->db->get_where('tbl_rt', ['id_rw' => $_GET['filter_rw']])->result();
                      foreach ($rt as $rt) {
                    ?>

                        <?php if ($_GET['filter_rt'] == $rt->id_rt) { ?>
                          <option value="<?= $rt->id_rt ?>" selected><?= $rt->no_rt ?></option>
                        <?php } else { ?>
                          <option value="<?= $rt->id_rt ?>"><?= $rt->no_rt ?></option>
                        <?php } ?>

                      <?php } ?>
                    <?php } ?>

                  </select>
                </div>
              </div>

              <!-- FILTER BY STATUS WARGA -->
              <div class="col-lg-2">
                <div class="form-group">
                  <label><b>Status Warga</b></label>
                  <select name="filter_status" id="filter_status" class="form-control filter_status">
                    <option value="">--All--</option>
                    <?php foreach ($status_warga as $sw) { ?>
                      <?php if ($_GET['filter_status'] == $sw->id_status) { ?>
                        <option value="<?= $sw->id_status ?>" selected><?= $sw->status_warga ?></option>
                      <?php } else { ?>
                        <option value="<?= $sw->id_status ?>"><?= $sw->status_warga ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- FILTER BY BANTUAN -->
              <div class="col-lg-2">
                <div class="form-group">
                  <label><b>Bantuan</b></label>
                  <select name="filter_bantuan" id="filter_bantuan" class="form-control filter_bantuan">
                    <option value="">--All--</option>
                    <?php if($_GET['filter_bantuan'] == 'Belum'){ ?>
                      <option value="Belum" selected>Belum</option>
                    <?php } else { ?>
                      <option value="Belum">Belum</option>
                    <?php } ?>
                    <?php foreach($bantuan as $b){ ?>
                      <?php if($_GET['filter_bantuan'] == $b->id_jenis){ ?>
                        <option value="<?= $b->id_jenis ?>" selected><?= $b->jenis_bantuan ?></option>
                      <?php } else { ?>
                        <option value="<?= $b->id_jenis ?>"><?= $b->jenis_bantuan ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

            </div>

            <!-- PENAMBAHAN FITUR -->
            <div class="col-md-4">
              <label></label>
              <div class="input-group">
                <input type="text" class="form-control" id="cari" placeholder="Cari..." aria-label="Text input with dropdown button">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Opsi Pencarian</button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item opsi-pencarian" data-tipe="nama" href="#">Nama</a></li>
                  <li><a class="dropdown-item opsi-pencarian" data-tipe="nik" href="#">No. NIK</a></li>
                  <li><a class="dropdown-item opsi-pencarian" data-tipe="kk" href="#">No. KK</a></li>
                </ul>
              </div>
            </div>

              <small class="mr-2">Jumlah KK: <span class="text-danger"><?= $jml_kk ?></span></small>
            <small>Jumlah Warga: <span class="text-danger"><?= $jml_warga ?></span></small>
            <hr>
            <small class="mr-2">Jumlah Warga Berdasarkan Usia</small>
            <br>
            <small class="mr-2">Balita Laki-Laki: <span class="text-danger"><?= $balita_laki ?></span></small>
            -
            <small class="mr-2">Balita Perempuan: <span class="text-danger"><?= $balita_perempuan ?></span></small>
            <br>
            <small>Anak Laki-Laki: <span class="text-danger"><?= $anak_laki ?></span></small>
            -
            <small>Anak Perempuan: <span class="text-danger"><?= $anak_perempuan ?></span></small>
            <br>
            <small>Dewasa Laki-Laki: <span class="text-danger"><?= $dewasa_laki ?></span></small>
            -
            <small>Dewasa Perempuan: <span class="text-danger"><?= $dewasa_perempuan ?></span></small>
            <br>
            <small>Lansia Laki-Laki: <span class="text-danger"><?= $lansia_laki ?></span></small>
            -
            <small>Lansia Perempuan: <span class="text-danger"><?= $lansia_perempuan ?></span></small>
            <!-- END PENAMBAHAN FITUR -->

            <table class="table table-bordered mt-3" id="idTable">
              <thead>

                <tr>
                  <th rowspan="2">No. KK</th>
                  <th rowspan="2">Nama</th>
                  <th rowspan="2">NIK</th>
                  <th rowspan="2">Tanggal lahir</th>
                  <th colspan="2" class="bg-secondary text-light">Balita 0 - 5 th</th>
                  <th colspan="2" class="bg-danger text-light">Anak 6 - 17 th</th>
                  <th colspan="2" class="bg-info text-light">Dewasa 17 - 59 th</th>
                  <th colspan="2" class="bg-warning text-light">Lansia > 60 th</th>
                  <th rowspan="2">Status Warga</th>
                  <th rowspan="2">Alamat KTP</th>
                  <th rowspan="2">Alamat Domisili</th>
                  <th rowspan="2">Status Rumah</th>
                  <th rowspan="2">Ket. Bantuan</th>
                  <th rowspan="2">Ket. Rumah</th>
                  <th rowspan="2">NOP PBB</th>
                  <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                  <th>L</th>
                  <th>P</th>
                  <th>L</th>
                  <th>P</th>
                  <th>L</th>
                  <th>P</th>
                  <th>L</th>
                  <th>P</th>
                </tr>
              </thead>


              <tbody id="d_warga">
                <?php foreach ($kk as $k) { ?>
                  <?php $jml_anggota = $this->db->get_where('tbl_anggota_kk', ['id_kk' => $k->id_kk])->num_rows();

                  if(isset($status)){
                   $jml_anggota = $this->db->get_where('tbl_anggota_kk', ['id_kk' => $k->id_kk, 'status_warga' => $status])->num_rows();
                  }

                  if(isset($nik)){
                   $jml_anggota = $this->db->select('*')->from('tbl_anggota_kk')->where('id_kk', $k->id_kk)->like('nik', $nik)->get()->num_rows();
                  }

                  if(isset($nama)){
                    $jml_anggota = $this->db->select('*')->from('tbl_anggota_kk')->where('id_kk', $k->id_kk)->like('nama_lengkap', $nama)->get()->num_rows();
                  }

                  $rowspan = $jml_anggota + 2;

                  ?>
                  <tr>
                    <td rowspan="<?= $rowspan ?>"><?= $k->no_kk ?></td>
                  </tr>
                  <tr>
                    <td><strong>No.RT: <?= $k->no_rt ?> <br> No.RW: <?= $k->no_rw ?></strong></td>

                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>
                    <td class="bg-secondary"></td>

                    <td rowspan="<?= $rowspan ?>"><?= $k->alamat_ktp ?></td>
                    <td rowspan="<?= $rowspan ?>"><?= $k->alamat_domisili ?></td>
                    <td rowspan="<?= $rowspan ?>"><?= $k->nama_status ?></td>
                    <td rowspan="<?= $rowspan ?>"><?= $k->ket_bantuan ?>

                      <?php if ($k->ket_bantuan == 'Sudah') {
                        $bantuan = $this->db->get_where('tbl_jenis_bantuan', ['id_jenis' => $k->jenis_bantuan])->row();

                        echo '<br> (' . $bantuan->jenis_bantuan . ' Tahun ' . $k->tahun_bantuan . ')';
                      } ?>

                    </td>
                    <td rowspan="<?= $rowspan ?>"><?= $k->ket_rumah ?></td>
                    <td rowspan="<?= $rowspan ?>">
                      <?= $k->nop_pbb; ?>
                      <?php if ($k->nop_pbb == 'Sudah') {
                        echo '<br>(' . $k->tahun_nop_pbb . ')';
                      } ?>
                      (<?= $k->no_nop_pbb ?>)
                    </td>

                    <td rowspan="<?= $rowspan ?>">

                      <a href="<?= base_url('dashboard/delete/') . $k->id_kk; ?>" onclick="return confirm('Apakah anda yakin menghapus data ini?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                      <div class="dropdown">
                        <a class="btn btn-success btn-sm mt-2" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-edit"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <li><a class="dropdown-item" href="<?= base_url('dashboard/edit/') . $k->id_kk; ?>">Edit data KK</a></li>
                          <li><a class="dropdown-item" href="<?= base_url('dashboard/edit_anggota/') . $k->id_kk; ?>">Edit anggota KK</a></li>
                          <li><a class="dropdown-item" href="<?= base_url('dashboard/add_anggota/') . $k->id_kk; ?>">Tambah anggota KK</a></li>
                        </ul>
                      </div>

                      <button class="btn btn-sm btn-secondary mt-2 view-doc" data-doc="<?= $k->doc_kk ?>" data-exc="<?= $k->doc_exc ?>"><i class="fa fa-search"></i></button>

                    </td>
                  </tr>
                  <?php
                  $anggota = $this->model->getAnggotaKK($k->id_kk, null);

                  if(isset($status)){
                    $anggota = $this->model->getAnggotaKK($k->id_kk, $status);
                  }

                  if(isset($nik)){
                    $anggota = $this->model->getAnggotaKK($k->id_kk, null, $nik);
                  }

                  if(isset($nama)){
                    $anggota = $this->model->getAnggotaKK($k->id_kk, null, null, $nama);
                  }

                  foreach ($anggota as $a) {

                  ?>
                    <tr>
                      <td><?= $a->nama_lengkap ?></td>
                      <td><?= $a->nik ?></td>

                      <!-- <td><?= $a->tahun_lahir ?></td> -->
                      <td><?php $date = date_create($a->tahun_lahir);
                          echo date_format($date, 'd F Y'); ?></td>


                      <!-- Balita -->
                      <?php if ($a->umur == 'Balita') { ?>
                        <?php if ($a->jk == 'L') { ?>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                          <td></td>
                        <?php } else { ?>
                          <td></td>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                        <?php } ?>
                      <?php } else {  ?>
                        <td></td>
                        <td></td>
                      <?php } ?>

                      <!-- Anak -->
                      <?php if ($a->umur == 'Anak') { ?>
                        <?php if ($a->jk == 'L') { ?>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                          <td></td>
                        <?php } else { ?>
                          <td></td>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                        <?php } ?>
                      <?php } else {  ?>
                        <td></td>
                        <td></td>
                      <?php } ?>

                      <!-- Dewasa -->
                      <?php if ($a->umur == 'Dewasa') { ?>
                        <?php if ($a->jk == 'L') { ?>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                          <td></td>
                        <?php } else { ?>
                          <td></td>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                        <?php } ?>
                      <?php } else {  ?>
                        <td></td>
                        <td></td>
                      <?php } ?>

                      <!-- Lansia -->
                      <?php if ($a->umur == 'Lansia') { ?>
                        <?php if ($a->jk == 'L') { ?>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                          <td></td>
                        <?php } else { ?>
                          <td></td>
                          <td><i class="fa fa-check" aria-hidden="true"></i></td>
                        <?php } ?>
                      <?php } else {  ?>
                        <td></td>
                        <td></td>
                      <?php } ?>


                      <td><?= $a->status_warga ?></td>
                    </tr>
                  <?php } ?>
                <?php } ?>
              </tbody>

            </table>
            <!-- pagination -->
            <?= $this->pagination->create_links() ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="excel_rw" data-rw="<?php if(isset($_GET['filter_rw'])){ echo $_GET['filter_rw']; } ?>"></div>
<div class="excel_rt" data-rt="<?php if(isset($_GET['filter_rt'])){ echo $_GET['filter_rt']; } ?>"></div>
<div class="excel_bantuan" data-bantuan="<?php if(isset($_GET['filter_bantuan'])){ echo $_GET['filter_bantuan']; } ?>"></div>
<div class="excel_status" data-status="<?php if(isset($_GET['filter_status'])){ echo $_GET['filter_status']; } ?>"></div>
<div class="excel_nik" data-nik="<?php if(isset($_GET['filter_nik'])){ echo $_GET['filter_nik']; } ?>"></div>
<div class="excel_nama" data-nama="<?php if(isset($_GET['filter_nama'])){ echo $_GET['filter_nama']; } ?>"></div>
<div class="excel_kk" data-kk="<?php if(isset($_GET['filter_kk'])){ echo $_GET['filter_kk']; } ?>"></div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Dokumen KK</h5>
      </div>
      <div class="modal-body showDoc">
        
      </div>
      <div class="modal-footer">
        <a href="" class="btn btn-success download"><i class="fa fa-download"></i> Download</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).on('click','.view-doc', function(){
    $('#exampleModal').modal('show');
    let doc = $(this).data('doc');
    let exc = $(this).data('exc');

    if(doc == ''){
      $('.showDoc').html('<p class="text-center">No Data Result</p>');
      $('.download').addClass('d-none');
    } else {
      $('.download').removeClass('d-none');
      if(exc == '.pdf'){
        const src = '<?= base_url('assets/docs/') ?>' + doc;

        $('.download').attr('href', '<?= base_url('dashboard/download/'); ?>' + doc);
        $('.showDoc').html('<embed src='+src+' width="100%" height="100%"/>');
      } else {
        const src = '<?= base_url('assets/docs/') ?>' + doc;

        $('.download').attr('href', '<?= base_url('dashboard/download/'); ?>' + doc);
        $('.showDoc').html('<img src='+src+' width="100%">');
      }
    }

  });

  let export_rw = $('.excel_rw').data('rw');
  if(export_rw == ''){
    
    let export_bantuan = $('.excel_bantuan').data('bantuan');
    if(export_bantuan != ''){
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?bantuan='); ?>' + export_bantuan);
    } 

  } else {
    $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?rw='); ?>' + export_rw);

    let export_rt = $('.excel_rt').data('rt');
    if(export_rt == ''){
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?rw='); ?>' + export_rw);
    } else {
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?rt='); ?>' + export_rt);
    }

  }


     let export_nik = $('.excel_nik').data('nik');
      if(export_nik != ''){
        $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?nik='); ?>' + export_nik);
      }

    let export_nama = $('.excel_nama').data('nama');
    if(export_nama != ''){
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?nama='); ?>' + export_nama);
    }

    let export_kk = $('.excel_kk').data('kk');
    if(export_kk != ''){
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?kk='); ?>' + export_kk);
    }
  
    let export_status = $('.excel_status').data('status');
    if(export_status != ''){
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel?status='); ?>' + export_status);
    }
  

  

  
                  


  $('.opsi-pencarian').on('click', function() {
    var tipe = $(this).data('tipe');
    var cari = $('#cari').val();
    let rw = $('#filter_rw').val();
    let rt = $('#filter_rt').val();
    let date = $('#filter_date').val();
    let bantuan = $('#filter_bantuan').val();
    let status = $('#filter_status').val();

    if (cari == '') {
      alert('harap masukkan isi pencarian');
      $('.export-excel').attr('href', '<?= base_url('dashboard/export_excel/'); ?>');
    } else {

      if (tipe == 'nik') {
        window.location.href = '<?= base_url('dashboard/index/0?filter_rw=') ?>' + rw + '&filter_rt=' + rt + '&filter_date=' + date + '&filter_bantuan=' + bantuan + '&filter_status=' + status + '&filter_nik=' + cari ; 
      } else if (tipe == 'nama') {
        window.location.href = '<?= base_url('dashboard/index/0?filter_rw=') ?>' + rw + '&filter_rt=' + rt + '&filter_date=' + date + '&filter_bantuan=' + bantuan + '&filter_status=' + status + '&filter_nama=' + cari ;
      }  else if (tipe == 'kk') {
        window.location.href = '<?= base_url('dashboard/index/0?filter_rw=') ?>' + rw + '&filter_rt=' + rt + '&filter_date=' + date + '&filter_bantuan=' + bantuan + '&filter_status=' + status + '&filter_kk=' + cari ; 
      }
      
    }

  });

  $('.filter_status').on('change', function() {
    var tipe = $('.opsi-pencarian').data('tipe');
    let rw = $('#filter_rw').val();
    let rt = $('#filter_rt').val();
    let date = $('#filter_date').val();
    let bantuan = '';
    let status = $('#filter_status').val();
    
    window.location.href = '<?= base_url('dashboard/index/0?filter_rw=') ?>' + rw + '&filter_rt=' + rt + '&filter_date=' + date + '&filter_bantuan=' + bantuan + '&filter_status=' + status ; 
    
  });

  $('.filter_bantuan').on('change', function() {
    var tipe = $('.opsi-pencarian').data('tipe');
    let rw = $('#filter_rw').val();
    let rt = $('#filter_rt').val();
    let date = $('#filter_date').val();
    let bantuan =  $('#filter_bantuan').val();
    let status = '';
    
    window.location.href = '<?= base_url('dashboard/index/0?filter_rw=') ?>' + rw + '&filter_rt=' + rt + '&filter_date=' + date + '&filter_bantuan=' + bantuan + '&filter_status=' + status ; 
    
  });

  $('.filter').on('change', function() {
    var tipe = $('.opsi-pencarian').data('tipe');
    let rw = $('#filter_rw').val();
    let rt = $('#filter_rt').val();
    let date = $('#filter_date').val();
    let bantuan = $('#filter_bantuan').val();
    let status = $('#filter_status').val();
    
    window.location.href = '<?= base_url('dashboard/index/0?filter_rw=') ?>' + rw + '&filter_rt=' + rt + '&filter_date=' + date + '&filter_bantuan=' + bantuan + '&filter_status=' + status ; 
    
  });
  
  // $('#filter_date').on('change', function() {
  //   let filter = $(this).val();
  //   console.log('cek')
  //   if (filter != '') {
  //     window.location.href = '<?= base_url('dashboard/index?filter_date=') ?>' + filter ;
  //   } 
    
  // });

  // $('#filter_rt').change(function() {
  //   let rw = $('#filter_rw').val();
  //   let rt = $(this).val();

  //   if (rt == '') {
  //     window.location.href = '<?= base_url('dashboard/index?filter_rw=') ?>' + rw;
  //   } else {
  //     window.location.href = '<?= base_url('dashboard/index?filter_rw=') ?>' + rw + '&filter_rt=' + rt;
  //   }
  // });

  // $('#filter_bantuan').on('change', function() {
  //   let filter_bantuan = $(this).val();
  //   if (filter_bantuan != '') {
  //     window.location.href = '<?= base_url('dashboard/index?filter_bantuan=') ?>' + filter_bantuan;
  //   } 
    
  // });

  // $('#filter_status').on('change', function() {
  //   let filter_status = $(this).val();
  //   if (filter_status != '') {
  //     window.location.href = '<?= base_url('dashboard/index?filter_status=') ?>' + filter_status;
  //   }
  // });

  let url_get = window.location.search;
  let url = window.location.href;
  // const urlParams = new URLSearchParams(url);
  
  // let filter_rw = urlParams.get('filter_rw');
  // let filter_rt = urlParams.get('filter_rt');
  // let filter_date = urlParams.get('filter_date');
  // let filter_bantuan = urlParams.get('filter_bantuan');
  // let filter_status = urlParams.get('filter_status');
  // let filter_nama = urlParams.get('filter_nama');
  // let filter_nik = urlParams.get('filter_nik');
  // let filter_kk = urlParams.get('filter_kk');

  
  $('.page-link').click(function(e){
    e.preventDefault();
    let page_btn = $(this).attr('href');
    let new_url = page_btn + url_get;
    window.location.href = new_url;
  })


  

</script>