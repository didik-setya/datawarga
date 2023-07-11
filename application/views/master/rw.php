<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Management Data RW</h5>

                    <button class="btn btn-sm btn-primary mb-3 add"><i class="fa fa-plus"></i> Tambah</button>

                    <table class="table table-bordered" id="tableRW">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>No RW</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($data as $d){ ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $d->no_rw ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger delete" data-id="<?= $d->id_rw ?>"><i class="fa fa-trash"></i></button>
                                    <button class="btn btn-sm btn-success edit" data-id="<?= $d->id_rw ?>" data-rw="<?= $d->no_rw ?>"><i class="fa fa-edit"></i></button>
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
      <form action="" id="formRW" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_rw" id="id_rw">
        <div class="form-group">
            <label>No RW</label>
            <input type="number" name="rw" id="rw" required class="form-control">
            <small class="text-danger" id="err_rw"></small>
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

    $('#tableRW').dataTable();

    $('.add').click(function(){
        $('#exampleModal').modal('show');
        $('.modal-title').html('Tambah Data RW Baru');
        $('#formRW').attr('action','<?= base_url('master/add_rw') ?>');
        $('#rw').val('');
    });

    $('#formRW').submit(function(e){
        e.preventDefault();
        $('.toSave').attr('disabled', true);

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d){
                if(d.success == true){
                    toastr["success"](d.msg, "Success");
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    $('.toSave').removeAttr('disabled');
                    if(d.type == 'validation'){
                        if(d.err_rw == ''){
                            $('#err_rw').html('');
                        } else {    
                            $('#err_rw').html(d.err_rw);
                        }
                    } else if(d.type == 'result') {
                        toastr["error"](d.msg, "Error");
                    }
                }
            }
        });
    });


    $(document).on('click','.edit', function(){
        let id = $(this).data('id');
        let rw = $(this).data('rw');
        $('#id_rw').val(id);
        $('#rw').val(rw);
        $('#exampleModal').modal('show');
        $('.modal-title').html('Edit Data RW');
        $('#formRW').attr('action','<?= base_url('master/edit_rw') ?>');
    });

    $(document).on('click','.delete', function(){
        let id = $(this).data('id');
        let tipe = 'rw';
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