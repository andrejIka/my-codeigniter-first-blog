<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content=""> 

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet"> 
    <link href="assets/css/highslide.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
<?php 

  // $this->output->enable_profiler(TRUE); 

?>
        <div class="container">
          <h1 class="text-center">Login form</h1>
          <div class="well "> 
            <?php echo form_open('/auth/'); ?> 
            <label for="">Login</label> 
            <div class="form-group">
              <input type="text" name="login" value="<?php echo $login; ?>" class="form-control" />
              <?php echo form_error('login'); ?>
            </div>
            <label for="">Password</label> 
            <div class="form-group">
              <input type="text" name="password" value="<?php echo $password; ?>" class="form-control" />
              <?php echo form_error('password'); ?>
            </div>
            <input id="submit" type="submit" name="submit" value="Save" class="btn btn-primary" />
            <!-- <button name="submit" class="btn btn-primary" type="submit">Save</button> -->
            <?php echo form_close();   ?> 
          </div>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>  

  </body>
</html>

