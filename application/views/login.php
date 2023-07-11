<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login Page</title>
  </head>
  <body class="h">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-9 col-sm-10">
                <div class="card shadow border-success" style="margin: 100px 0 0 0;">
                    <div class="card-body">
                        <center>
                            <img src="<?= base_url('assets/pemkab.png') ?>" width="30%">
                        </center>

                        <br>
                        
                        <h4 class="text-center">Sistem Informasi Kependudukan</h4>
                        <h4 class="text-center">Kelurahan Tegal Gede</h4>
                        <h4 class="text-center">Kabupaten Jember</h4>
                        <!--<h4 class="text-center">Login Page</h4>-->
                        <form action="<?= base_url(); ?>" method="post">
                        <hr>
                        <?php if($this->session->flashdata('err_msg')){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?= $this->session->flashdata('err_msg'); ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <?= form_error('username','<small class="text-danger">','</small>'); ?>
                            <input type="text" value="<?= set_value('username'); ?>" name="username" id="username" placeholder="Username" class="form-control">
                        </div>
                        <div class="form-group mt-3">
                        <?= form_error('password','<small class="text-danger">','</small>'); ?>
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control">
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning" type="submit">Login</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>