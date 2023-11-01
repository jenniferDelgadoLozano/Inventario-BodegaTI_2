<?php
  $page_title = 'Lista de imagenes';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php $media_files = find_all('actas');?>
<?php
  if(isset($_POST['submit'])) {
    $photo = new Actas();
    $photo  ->upload($_FILES['file_upload']);
    if($photo->process_media()){
        $session->msg('s','Imagen subida al servidor.');
        redirect('actas.php');
    } else{
      $session->msg('d',join($photo->errors));
      redirect('actas.php');
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-camera"></span>
        <span>Lista de Actas</span>
        <div class="pull-right">
          <form class="form-inline" action="actas.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-btn">
                  <input type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file"/>
                </span>
                <button type="submit" name="submit" class="btn btn-default">Subir</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="panel-body">
        <table class="table">
          <thead>
            <tr>
              <th class="text-center">Item</th>
              <th class="text-center">Titulo</th>
              <th class="text-center">Archivo</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($media_files as $media_file): ?>
              <tr class="list-inline">
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"><?php echo $media_file['titulo'];?></td>
                <td class="text-center"><a href="uploads/actas/<?php echo $media_file['nombrearchivo'];?>" style="color:#42A5F5;"><?php echo $media_file['nombrearchivo'];?></a></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
