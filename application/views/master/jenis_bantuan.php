<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Management Jenis Bantuan</h5>
                    <button class="btn btn-sm btn-primary mb-3 add"><i class="fa fa-plus"></i> Tambah</button>


                    <table class="table table-bordered" id="tableJenis">
                      <thead>
                        <tr class="bg-dark text-light">
                          <th>#</th>
                          <th>Jenis Bantuan</th>
                          <th><i class="fa fa-cogs"></i></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; foreach($data as $d){ ?>
                        <tr>
                          <td><?= $i++ ?></td>
                          <td><?= $d->jenis_bantuan ?></td>
                          <td>
                            <button class="btn btn-sm btn-danger delete" data-id="<?= $d->id_jenis ?>"><i class="fa fa-trash"></i></button>
                            <button class="btn btn-sm btn-success edit" data-id="<?= $d->id_jenis ?>" data-jenis="<?= $d->jenis_bantuan ?>"><i class="fa fa-edit"></i></button>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
      </div>
      <form action="" id="formJenis" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_jenis" id="id_jenis">
        <div class="form-group">
            <label>Jenis Bantuan</label>
            <input type="text" name="jenis" id="jenis" required class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="toSave btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
    $('#tableJenis').dataTable();

    $('.add').click(function(){
        $('#exampleModal').modal('show');
        $('.modal-title').html('Tambah Jenis Bantuan Baru');
        $('#formJenis').attr('action','<?= base_url('master/add_jenis_bantuan') ?>');
        $('#jenis').val('');
    });

    $(document).on('click','.edit', function(){
      let id = $(this).data('id');
      let jenis = $(this).data('jenis');
      $('#id_jenis').val(id);
      $('#jenis').val(jenis);

      $('#exampleModal').modal('show');
      $('.modal-title').html('Edit Jenis Bantuan');
      $('#formJenis').attr('action','<?= base_url('master/edit_jenis_bantuan') ?>');
    });

    $('#formJenis').submit(function(e){
        e.preventDefault();
        $('.toSave').attr('disabled', true);
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType:'JSON',
            success: function(d){
                if(d.success == true){
                  toastr["success"](d.msg, "Success");
                  $('#exampleModal').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                  toastr["error"](d.msg, "Error");
                  $('.toSave').removeAttr('disabled');
                }
            }
        });
    });

    $(document).on('click','.delete', function(){
        let id = $(this).data('id');
        let tipe = 'bantuan';
        $('#modalDelete').modal('show');
        $('#id_delete').val(id);
        $('#id_type').val(tipe);
    });

    $('#formDelete').submit(function(e){
        e.preventDefault();
        $('.toDelete').attr('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.success == true){
                    toastr["success"](d.msg, "Success");
                    $('#modalDelete').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    toastr["error"](d.msg, "Error");
                    $('.toDelete').removeAttr('disabled');
                }
            }
        });

    });

</script>