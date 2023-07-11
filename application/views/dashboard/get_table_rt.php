                  
                            <?php foreach($kk as $k){ ?>
                              <?php $jml_anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->num_rows();
                              
                              $rowspan = $jml_anggota + 2;
                              
                            ?>
                                <tr>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->rw ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No.Rt: <?= $k->rt ?> <br> No.KK: <?= $k->no_kk ?></strong></td>

                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>
                                    <td class="bg-secondary"></td>

                                    <td rowspan="<?= $rowspan ?>"><?= $k->alamat ?></td>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->status_rumah ?></td>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->ket_bantuan ?>

                                    <?php if($k->ket_bantuan == 'Sudah'){ echo'('. $k->tahun_bantuan .')'; } ?>

                                    </td>
                                    <td rowspan="<?= $rowspan ?>"><?= $k->ket_rumah ?></td>
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

                                    </td>
                                </tr>
                                <?php
                                $anggota = $this->db->get_where('tbl_anggota_kk',['id_kk' => $k->id_kk])->result();
                                foreach($anggota as $a){
                                
                                ?>
                                <tr>
                                    <td><?= $a->nama_lengkap ?>/<?= $a->nik ?></td>
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
                            