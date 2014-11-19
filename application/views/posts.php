
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



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


    <div class="container">

      <h2>Blog posts <a href="<?php echo site_url("/add_post/"); ?>" title="" class="btn btn-default">Add post</a></h2>  
      <?php echo $this->session->flashdata('message');  ?>
      <?php foreach ($posts as $post): ?>
      <div class="well media">
        <a href="<?php echo site_url("/delete_post/".$post->id); ?>" title="" class="btn btn-danger pull-right" onclick="if(!confirm('Want to delete?')) return false;" ><span class="glyphicon glyphicon-remove"></span></a>
        <span class="media-left">
          <!-- <img src="<?php echo base_url(); ?>/assets/uploads/<?php echo $post->image_path;  ?>" alt="..."> -->
        </span>
        <div class="media-body">
          <h4 class="media-heading text-left clearfix">
            <a href="<?php echo site_url("/edit_post/".$post->id); ?>" title="" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
            <?php echo $post->title; ?>  
          </h4>
          <p class="text-left"><?php echo $post->content; ?></p>
          <p class="text-left"><small>Author: <strong><?php echo $post->author; ?></strong></small></p> 
        </div>
      </div>
      <?php endforeach ?>

     <p><?php echo $links; ?></p>       

    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" language="javascript"> 
    $(document).ready(function(){  
           
  
      window.setTimeout(function() { $(".alert-info, .alert-success").fadeOut('fast'); }, 3000);        
    
    });
    </script> 
  </body>
</html>

