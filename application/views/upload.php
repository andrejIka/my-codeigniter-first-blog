<?php $this->load->view('partials/header'); ?>


        <div class="container">
          <br />
          <ul class="nav nav-pills nav-justified">
            <li><a href='<?php echo site_url("/posts/"); ?>'   title="">Posts</a></li>
            <li  class="active"><a href='<?php echo site_url("/upload/"); ?>'  title="">Uploads</a></li>
            <li><a href='<?php echo site_url("/calendar/"); ?>'  title="">Calendar</a></li> 
          </ul>
          <br />
          <?php  if(!empty($all_images)){  ?>
          <div class="well">
            <?php foreach ($all_images as $image): ?>
              <div style="display: inline-block; position: relative; margin-bottom: 20px; border: 2px solid #ccc; border-radius: 6px; margin-right: 10px;">
                <a href="<?php echo site_url("/")."assets/uploads/".$image->image_url; ?>"   title="" target="_blank">
                  <img src="<?php echo site_url("/")."assets/uploads/".$image->thumb_url; ?>" alt="" class="img-thubmnail" /> 
                </a>
                <a href="<?php echo site_url("/upload/delete_image/".$image->
                  id); ?>" style="position: absolute; top:0; right: 0;  " onclick="if(!confirm('Want to delete?')) return false;" class="btn btn-default" title="">
                  <span class="glyphicon glyphicon-remove"></span>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
          <?php } ?>
          <h1 class="clearfix">Add image to the gallery
            <div class="pull-right text-right">
              <a href="<?php echo site_url("/upload/export_images"); ?>" class="btn btn-default">  Export images  ZIP  <span class="glyphicon glyphicon-download-alt"> </span></a>
              <a href="<?php echo site_url("/upload/export_images_list"); ?>" class="btn btn-default">  Export  images list <span class="glyphicon glyphicon-list-alt"> </span></a> 
            </div> 
          </h1>  
          <div class="well "> 
            <?php echo form_open_multipart('/upload/'); ?> 
            <label for="">File upload</label>
            <div class="form-group row">
              <div class="col-xs-8">
                <input autofocus type="file" name="userfile" class="form-control" size="20" /> 
                <?php echo $this->session->flashdata('message');  ?>
                <?php if(isset($file_errors) ) echo $file_errors; ?>
              </div> 
            </div> 
            <p> <a href="<?php echo site_url("/upload/remove_all_images/"); ?>" title="" class="btn btn-danger"> <span class="glyphicon glyphicon-remove"></span> Remove all images from gallery </a> </p>
            <input id="submit" type="submit" name="submit" value="Save" class="btn btn-primary" />
            <!-- <button name="submit" class="btn btn-primary" type="submit">Save</button> -->
            <?php echo form_close();   ?> 
          </div>
        </div>


<?php $this->load->view('partials/footer'); ?>