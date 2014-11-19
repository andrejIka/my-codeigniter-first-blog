
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
    <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="http://getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet"> -->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="text-left">
        <h1>Add</h1>  
        <div class="well ">

          <?php 
            echo form_open('/add_post/'); 
          ?>
          <?php //echo validation_errors(); ?>
          <label for="">Title</label> 
          <div class="form-group">
            <input type="text" name="title" value="<?php echo $post[0]['title']; ?>" class="form-control" />
            <?php echo form_error('title'); ?>
          </div>
          <label for="">Author</label> 
          <div class="form-group">
            <input type="text" value="<?php echo $post[0]['author']; ?>" class="form-control" name="author" />
            <?php echo form_error('author'); ?>
          </div>
          <label for="">Content</label>
          <div class="form-group">
            <textarea name="content" id="" cols="30" rows="10" class="form-control" ><?php echo $post[0]['content']; ?></textarea>
            <?php echo form_error('content'); ?>
          </div>
          <input type="submit" name="submit" value="Save" class="btn btn-primary" />
          <!-- <button name="submit" class="btn btn-primary" type="submit">Save</button> -->
          <?php echo form_close();   ?> 
        </div>

      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
  </body>
</html>

