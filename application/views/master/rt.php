<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Management Data RT</h5>

                    <button class="btn btn-sm btn-primary add"><i class="fa fa-plus"></i> Tambah</button>

                    <div class="row mb-3 mt-2">
                        <div class="col-12 col-md-6 col-lg-8"></div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Filter by No. RW</label>
                                <select name="filter" id="filter" class="form-control">
                                    <option value="">--All--</option>
                                    <?php foreach($rw as $r){ ?>
                                        <?php if($_GET['filter'] == $r->id_rw){ ?>
                                            <option value="<?= $r->id_rw ?>" selected><?= $r->no_rw ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $r->id_rw ?>"><?= $r->no_rw ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered" id="tableRT">
                        <thead>
                            <tr class="bg-dark text-light">
                                <th>#</th>
                                <th>No RW</th>
                                <th>No RT</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($data as $d){ ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $d->no_rw ?></td>
                                <td><?= $d->no_rt ?></td>
                                <td>
                                    <button class="btn btn-sm btn-success edit" data-id="<?= $d->id_rt ?>" data-rt="<?= $d->no_rt ?>" data-rw="<?= $d->id_rw ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger delete" data-id="<?= $d->id_rt ?>"><i class="fa fa-trash"></i></button>
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
      <form action="" id="formRT" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_rt" id="id_rt">
        <div class="form-group">
            <label>No. RW</label>
            <select name="rw" id="rw" class="form-control" required>
                <option value="">--pilih--</option>
                <?php foreach($rw as $rw){ ?>
                    <option value="<?= $rw->id_rw ?>"><?= $rw->no_rw ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>No. RT</label>
            <input type="number" name="rt" id="rt" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="toSave btn btn-primary">Save </button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    $('#tableRT').dataTable();

    $('.add').click(function(){
        $('#exampleModal').modal('show');
        $('.modal-title').html('Tambah Data RT');
        $('#formRT').attr('action','<?= base_url('master/add_rt') ?>');
        $('#rw').val('');
        $('#rt').val('');
    });

    $(document).on('click','.edit', function(){
        let rt = $(this).data('rt');
        let rw = $(this).data('rw');
        let id_rt = $(this).data('id');

        $('#exampleModal').modal('show');
        $('.modal-title').html('Edit Data RT');
        $('#formRT').attr('action','<?= base_url('master/edit_rt') ?>');
        $('#rw').val(rw);
        $('#rt').val(rt);
        $('#id_rt').val(id_rt);
    });

    $(document).on('click','.delete', function(){
        let id = $(this).data('id');
        let tipe = 'rt';
        $('#modalDelete').modal('show');
        $('#id_delete').val(id);
        $('#id_type').val(tipe);
    });

    $('#formRT').submit(function(e){
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
                    $('#exampleModal').modal('hide');
                    setTimeout(() => {
                        location.reload()
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

    $('#filter').change(function(){
        let filter = $(this).val();

        if(filter == ''){
            window.location.href = '<?= base_url('master/rt'); ?>';
        } else {
            window.location.href = '<?= base_url('master/rt?filter='); ?>' + filter;
        }
    });

</script>
