<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codeigniter Crud By Crud Generator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://crudegenerator.in">Codeigniter Crud By Crud Generator</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active" ><a href="<?php echo site_url(); ?>manage-user">Manage User</a></li>
        <li><a href="<?php echo site_url(); ?>add-user">Add User</a></li>
      </ul>
  </div>
</nav>
<div class="container">
  <h2>Manage User</h2>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($users)) {?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>SL No</th>
        <th>id</th>
       <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($users as $user) { ?>
      <tr>
        <td> <?php echo $i; ?> </td>
        <td> <a href="<?php echo site_url()?>view-user/<?php echo $user->id?>" > <?php echo $user->id ?> </a> </td>

        <td>
        <a href="<?php echo site_url()?>change-status-user/<?php echo $user->id ?>" > <?php if($user->status==0){ echo "Activate"; } else { echo "Deactivate"; } ?></a>
        <a href="<?php echo site_url()?>edit-user/<?php echo $user->id?>" >Edit</a>
        <a href="<?php echo site_url()?>delete-user/<?php echo $user->id?>" onclick="return confirm('are you sure to delete')">Delete</a>
        </td>

      </tr>
    <?php $i++; } ?>
    </tbody>
  </table>
  <?php } else {?>
  <div class="alert alert-info" role="alert">
                    <strong>No Users Found!</strong>
                </div>
  <?php } ?>
</div>

</body>
</html>
