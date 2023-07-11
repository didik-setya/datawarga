<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/Welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>


<table class="table table-bordered mt-3" id="theTable">
             <tr>
             <th rowspan="2">Aksi</th>
               <th rowspan="2">No. Rw / No. Rumah</th>
               <th rowspan="2">No. KK / No. Rt</th>
               <th rowspan="2">Alamat</th>
               <th rowspan="2">Ket. Bantuan</th>
               <th rowspan="2">Ket. Rumah</th>
               <th rowspan="2">Nama/NIK</th>
               <th rowspan="2">Tahun Lahir</th>
               <th colspan="2">Anak < 17 th</th>
               <th colspan="2">Dewasa 17-59 th</th>
               <th colspan="2">Lansia > 60 th</th>
               
             </tr>
             <tr>
                 <th>Lk</th>
                 <th>Pr</th>
                 <th>Lk</th>
                 <th>Pr</th>
                 <th>Lk</th>
                 <th>Pr</th>
               </tr>
               
               <?php foreach($kk as $k){ ?>
                <?php $jml_anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->num_rows();
                
                $rowspan = $jml_anggota + 1;
                
                ?>
               <tr>
                  <td rowspan="<?= $rowspan ?>">
                    <a href="<?= base_url('dashboard/delete/') . $k->id_kk; ?>" onclick="return confirm('Apakah anda yakin menghapus data ini?')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                  
                      <div class="dropdown">
                        <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fa fa-edit"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <li><a class="dropdown-item" href="<?= base_url('dashboard/edit/') . $k->id_kk; ?>">Edit data KK</a></li>
                          <li><a class="dropdown-item" href="<?= base_url('dashboard/edit_anggota/') . $k->id_kk; ?>">Edit anggota KK</a></li>
                          <li><a class="dropdown-item" href="<?= base_url('dashboard/add_anggota/') . $k->id_kk; ?>">Tambah anggota KK</a></li>
                        </ul>
                      </div>
                  </td>
                 <td rowspan="<?= $rowspan ?>"><?= $k->rw ?> / <?= $k->no_rumah ?></td>
                 <td rowspan="<?= $rowspan ?>"><?= $k->no_kk ?> / <?= $k->rt ?></td>
                 <td rowspan="<?= $rowspan ?>"><?= $k->alamat ?></td>
                 <td rowspan="<?= $rowspan ?>"><?= $k->ket_bantuan ?></td>
                 <td rowspan="<?= $rowspan ?>"><?= $k->ket_rumah ?></td>
               </tr>

                <?php $anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->result();
                foreach($anggota as $a){
                
                ?>
               <tr>
                 <td><?= $a->nama_lengkap ?> / <?= $a->nik ?></td>
                 <td><?= $a->tahun_lahir ?></td>


                 <!-- Anak -->
                 <?php if($a->umur == 'Anak'){ ?>
                  <?php if($a->jk == 'L'){ ?>
                    <td>1</td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td>1</td>
                  <?php } ?>
                <?php }else{  ?>
                  <td></td>
                  <td></td>
                <?php } ?>

                <!-- Dewasa -->
                <?php if($a->umur == 'Dewasa'){ ?>
                  <?php if($a->jk == 'L'){ ?>
                    <td>1</td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td>1</td>
                  <?php } ?>
                <?php }else{  ?>
                  <td></td>
                  <td></td>
                <?php } ?>
                 
                <!-- Lansia -->
                <?php if($a->umur == 'Lansia'){ ?>
                  <?php if($a->jk == 'L'){ ?>
                    <td>1</td>
                    <td></td>
                  <?php } else { ?>
                    <td></td>
                    <td>1</td>
                  <?php } ?>
                <?php }else{  ?>
                  <td></td>
                  <td></td>
                <?php } ?>

                 
               </tr>
               <?php } ?>
               <?php } ?>

              </table>