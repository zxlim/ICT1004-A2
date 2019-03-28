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
        <li><a href="<?php echo site_url(); ?>manage-user">Manage User</a></li>
        <li><a href="<?php echo site_url(); ?>add-user">Add User</a></li>
      </ul>
  </div>
</nav>

<div class="container">

 <div class="row">
  <div class="col-xs-12 col-md-10 well">
   id  :  <?php echo $user[0]->id ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   name  :  <?php echo $user[0]->name ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   loginid  :  <?php echo $user[0]->loginid ?>
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-md-10 well">
   gender  :  <?php echo $user[0]->gender ?>
  </div>
</div>

</div>

</body>
</html>
