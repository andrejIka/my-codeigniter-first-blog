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
          <?php  if(!empty($all_images)){  ?>
          <div class="well">
            <?php

              foreach ($all_images as $image): 
            ?>
          <?php //echo site_url("/")."assets/uploads/".$image->thumb_url; ?>
              <div style="display: inline-block; position: relative;">
                <a href="<?php echo site_url("/")."assets/uploads/".$image->image_url; ?>"   title="" target="_blank">
                  <img src="<?php echo site_url("/")."assets/uploads/".$image->thumb_url; ?>" alt="" class="img-thubmnail" /> 
                </a>
                <a href="<?php echo site_url("/upload/delete_image/".$image->
                  id); ?>" style="position: absolute; top:0; right: 0;  " onclick="if(!confirm('Want to delete?')) return false;" class="btn btn-default" title="">
                  <span class="glyphicon glyphicon-remove"></span>
                </a>
              </div>
            <?php  
                endforeach; 
            ?>          
          </div>
          <?php } ?>
          <h1>Add image to the gallery</h1>  
          <div class="well "> 
            <?php echo form_open_multipart('/upload/'); ?> 
            <label for="">File upload</label>
            <div class="form-group">
              <input type="file" name="userfile" class="form-control" size="20" /> 
              <?php echo $this->session->flashdata('message');  ?>
              <?php if(isset($file_errors) ) echo $file_errors; ?>
            </div> 
            <p> <label> <input type="checkbox" name="empty_folder" value="yes" /></label> Empty images folder: </p>
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
    <script> 
    $(document).ready(function(){  
           
      $('input[type=file]').change(function() { 
        // select the form and submit
        // alert('this');
        $('#submit').click(); 

    });        


      });
      </script> 
  </body>
</html>

