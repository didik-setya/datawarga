<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Management Status Rumah</h5>
                    <button class="btn btn-sm btn-primary add mb-2"><i class="fa fa-plus"></i> Tambah</button>

                    <table class="table table-bordered" id="tableRumah">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>Nama Status</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($data as $d){ ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $d->nama_status ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success edit" data-id="<?= $d->id_status ?>" data-status="<?= $d->nama_status ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger delete" data-id="<?= $d->id_status ?>"><i class="fa fa-trash"></i></button>
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
      <form action="" id="formStatus" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_status" id="id_status">
        <div class="form-group">
            <label>Nama Status</label>
            <input type="text" name="status" id="status" required class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary toSave">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    $('#tableRumah').dataTable();

    $('.add').click(function(){
        $('#exampleModal').modal('show');
        $('.modal-title').html('Tambah Data Status Baru');
        $('#status').val('');
        $('#formStatus').attr('action','<?= base_url('master/add_status_rumah') ?>');
    });

    $(document).on('click','.edit', function(){
        let id = $(this).data('id');
        let status = $(this).data('status');

        $('#exampleModal').modal('show');
        $('.modal-title').html('Edit Data Status');
        $('#status').val(status);
        $('#id_status').val(id);
        $('#formStatus').attr('action','<?= base_url('master/edit_status_rumah') ?>');
    });

    $(document).on('click','.delete', function(){
        let id = $(this).data('id');
        let tipe = 'status_rumah';
        $('#modalDelete').modal('show');
        $('#id_delete').val(id);
        $('#id_type').val(tipe);
    });

    $('#formStatus').submit(function(e){
        $('.toSave').attr('disabled', true);
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
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