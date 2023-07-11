<table border="1" cellpadding="7">
                            <thead>
                            
                                <tr>
                                    <th rowspan="2">No. KK</th>
                                    
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">NIK</th>
                                    
                                    <th rowspan="2">Tanggal Lahir</th>

                                    <th colspan="2">Balita</th>
                                    <th colspan="2">Anak</th>
                                    <th colspan="2">Dewasa</th>
                                    <th colspan="2">Lansia</th>
                                    <th rowspan="2">Status Warga</th>

                                    <th rowspan="2">Alamat KTP</th>
                                    <th rowspan="2">Alamat Domisili</th>
                                    <th rowspan="2">Status Rumah</th>
                                    <th rowspan="2">Ket. Bantuan</th>
                                    <th rowspan="2">Ket. Rumah</th>
                                    <th rowspan="2">NOP PBB</th>
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
                            <tbody>
                            <?php foreach($kk as $k){ ?>
                              <?php $jml_anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->num_rows();

                                if(isset($status)){
                                  $jml_anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk, 'status_warga' => $status])->num_rows();
                                }

                                if(isset($nik)){
                                  $jml_anggota = $this->db->select('*')->from('tbl_anggota_kk')->where('id_kk', $k->id_kk)->like('nik', $nik)->get()->num_rows();
                                 }

                                if(isset($nama)){
                                  $jml_anggota = $this->db->select('*')->from('tbl_anggota_kk')->where('id_kk', $k->id_kk)->like('nama_lengkap', $nama)->get()->num_rows();
                                 }

                              $rowspan = $jml_anggota + 2;
                              $rowspan2 = $jml_anggota + 1;
                              
                            ?>
                                <tr>
                                    <td rowspan="<?= $rowspan ?>">&nbsp;<?= $k->no_kk; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Rw. <?= $k->no_rw ?> <br> Rt: <?= $k->no_rt ?></strong></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->alamat_ktp ?></td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->alamat_domisili ?></td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->nama_status ?></td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->ket_bantuan ?>

                                    <?php if($k->ket_bantuan == 'Sudah'){
                                      $bantuan = $this->db->get_where('tbl_jenis_bantuan',['id_jenis' => $k->jenis_bantuan])->row();

                                      echo '(' .$bantuan->jenis_bantuan . ' Tahun '. $k->tahun_bantuan .')'; } ?>

                                    </td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->ket_rumah ?></td>
                                    <td rowspan="<?= $rowspan2 ?>"><?= $k->nop_pbb; ?> <?php if($k->nop_pbb == 'Sudah') { echo "<br> (Tahun ".$k->tahun_nop_pbb.")"; } ?></td>
                                </tr>
                                <?php
                                $anggota = $this->model->getAnggotaKK($k->id_kk);

                                if(isset($status)){
                                  $anggota = $this->model->getAnggotaKK($k->id_kk, $status);
                                }

                                if(isset($nik)){
                                  $anggota = $this->model->getAnggotaKK($k->id_kk, null, $nik);
                                }
                                
                                if(isset($nama)){
                                  $anggota = $this->model->getAnggotaKK($k->id_kk, null, null, $nama);
                                }

                                foreach($anggota as $a){
                                
                                ?>
                                <tr>
                                    <td><?= $a->nama_lengkap ?></td>
                                    <td>&nbsp;<?= $a->nik ?></td>
                                    <td><?php $da = date_create($a->tahun_lahir); echo date_format($da, 'd F Y'); ?></td>


                                    <!-- Anak -->
                 <?php if($a->umur == 'Balita'){ ?>
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

                  <td><?= $a->status_warga ?></td>


                                </tr>
                                <?php } ?>
                                <?php } ?>
                            </tbody>
<?php if(empty($jml_anak_laki) & empty($jml_anak_perempuan) & empty($jml_dewasa_laki) & empty($jml_dewasa_perempuan) & empty($jml_lansia_laki) & empty($jml_lansia_perempuan) & empty($jml_anak) & empty($jml_dewasa) & empty($jml_lansia)){ ?>
<?php } else { ?>
<tr>
  <td colspan="19"></td>
</tr>

<tr>
  <th colspan="19">Jumlah Warga</th>
</tr>

<tr>
  <th colspan="4" rowspan="2"></th>
  <th colspan="2">Balita</th>
  <th colspan="2">Anak</th>
  <th colspan="2">Dewasa</th>
  <th colspan="2">Lansia</th>
  <th colspan="7" rowspan="2"></th>
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

<tr>
  <th colspan="4">Jumlah</th>
  <td><?= $jml_balita_laki ?></td>
  <td><?= $jml_balita_perempuan ?></td>
  <td><?= $jml_anak_laki ?></td>
  <td><?= $jml_anak_perempuan ?></td>
  <td><?= $jml_dewasa_laki ?></td>
  <td><?= $jml_dewasa_perempuan ?></td>
  <td><?= $jml_lansia_laki ?></td>
  <td><?= $jml_lansia_perempuan ?></td>
  <th colspan="7"></th>
</tr>

<tr>
  <th colspan="4">Total</th>
  <td colspan="2"><?= $jml_balita ?></td>
  <td colspan="2"><?= $jml_anak ?></td>
  <td colspan="2"><?= $jml_dewasa ?></td>
  <td colspan="2"><?= $jml_lansia ?></td>
  <th colspan="7"></th>
</tr>

<?php } ?>
                        </table>

<br><br>
                        <table border="1">
                          <tr>
                            <th colspan="2">Keterangan</th>
                          </tr>
                          <tr>
                            <td>Balita</td>
                            <td> < 5 Th</td>
                          </tr>
                          <tr>
                            <td>Anak</td>
                            <td>6 -17 Th</td>
                          </tr>
                          <tr>
                            <td>Dewasa</td>
                            <td>17 - 59 Th</td>
                          </tr>
                          <tr>
                            <td>Lansia</td>
                            <td>> 60 Th</td>
                          </tr>
                        </table>



                        