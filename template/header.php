<?php ob_start(); require_once(__DIR__ . '/../library/autoload.php'); ?>
<?php
if(is_login()) {
  $broken_count = $YuuClass->get_count('tb_broken', @$_user['email']);
  $broken_badge = ($broken_count >= 1) ? 'badge-danger' : 'badge-secondary';
}
$redirectURL = base64_encode(CURRENT_URL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset=utf-8>
    <meta content="IE=edge" http-equiv=X-UA-Compatible>
    <meta content="width=device-width,initial-scale=1" name=viewport>
<?php if(BASE_PAGE == 'file.php' || BASE_PAGE == 'list-file.php'): ?>
    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="noindex,nofollow">
<?php endif;?>
    <meta property="description" content="<?= $app['description'];?>"/>
    <meta property="og:description" content="<?= $app['description'];?>"/>
    <meta property="og:image" content="<?= base_url('assets/img/drivelogo.png'); ?>"/>
    <meta property="og:type" content="website"/>
    <title><?=  _NAME; ?> - <?= $app['description'];?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon.ico'); ?>"/>
    <!-- CSS -->
    <link href="https://fonts.googleapis.com/css?family=Istok+Web" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.1.0/litera/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>" type="text/css" />
    <!-- Bootstrap DataTable -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.1/bootstrap-table.min.css" />
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.3.4/sweetalert2.all.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="<?= base_url('assets/js/countUp.js'); ?>"></script>
    <!-- Bootstrap DataTable -->
    <script src="<?= base_url('assets/js/bootstrap-table.min.js'); ?>"></script>
	 <style>
	 .btn-square{border-radius:0!important}
	 </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url('assets/img/logo.png'); ?>"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarColor03">
    <?php if (is_login()): ?>
      <ul class="navbar-nav mr-auto">
      <?php if(!check_public()) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url(); ?>">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url('manage/files'); ?>">File Manager</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('upload/links'); ?>">Upload Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('upload/drive'); ?>">Upload Drive</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('file-report'); ?>">Reported Files <sup><span class="badge-pill <?=$broken_badge;?>"><?= $broken_count; ?></span></sup></a>
        </li>
        <?php if(is_admin()): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin'); ?>">Admin</a>
        </li>
        <?php endif; ?>
      <?php endif; ?>
      </ul>
    <?php endif;?>
    <?php if (is_login()): ?>
    <div class="form-inline my-2 my-lg-0">
      <span class="navbar-text"><a href="<?= base_url('account'); ?>"><img src="<?= $_user['picture'];?>" class="rounded-circle" height="30px"></a> <?= $_user['email']; ?></span>&nbsp;&nbsp;<a class="btn btn-danger btn-sm my-2 my-sm-0 btn-square" href="<?= base_url("logout?r=$redirectURL"); ?>">Log-out</a>
    </div>
    <?php else: ?>
    <ul class="navbar-nav ml-auto">
      <li><a class="btn btn-sm btn-primary btn-square" href="<?= base_url("login?r=$redirectURL"); ?>">Log-in</a></li>
    </ul>
    <?php endif;?>
  </div>
</nav>