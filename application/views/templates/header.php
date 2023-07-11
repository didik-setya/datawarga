<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/fa/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/toastr/build/toastr.min.css') ?>">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    
 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/toastr/build/toastr.min.js') ?>"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    


    <title><?= $title; ?></title>
  </head>
  <body>


  <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-danger text-light">
        <h5 class="modal-title" id="exampleModalLabel">Delete?</h5>
      </div>
      <form action="<?= base_url('master/delete') ?>" id="formDelete" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_delete" id="id_delete">
        <input type="hidden" name="id_type" id="id_type">
        <p>Apakah anda yakin untuk menghapus data ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="toDelete btn btn-primary">YES</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('dashboard'); ?>">Program</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a class="nav-link"><i class="fa fa-user"></i> <?= $admin->nama_admin; ?></a>
        <a class="nav-link" href="<?=  base_url('admin'); ?>"><i class="fa fa-cog"></i> Settings</a>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="far fa-star"></i> Management
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="<?= base_url('master/rw') ?>">Management RW</a></li>
            <li><a class="dropdown-item" href="<?= base_url('master/rt') ?>">Management RT</a></li>
            <li><a class="dropdown-item" href="<?= base_url('master/status_rumah') ?>">Management Status Rumah</a></li>
            <li><a class="dropdown-item" href="<?= base_url('master/jenis_bantuan') ?>">Management Jenis Bantuan</a></li>
            <li><a class="dropdown-item" href="<?= base_url('master/status_warga') ?>">Management Status Warga</a></li>
          </ul>
        </li>
        <a class="nav-link" href="<?= base_url('welcome/logout'); ?>"><i class="fa fa-sign-out-alt"></i> Logout</a>
      </div>
    </div>
  </div>
</nav>