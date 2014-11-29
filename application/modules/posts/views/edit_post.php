<?php $this->load->view('templates/partials/header'); ?>

    <div class="container">

      <div class="text-left">
        <h1>Edit post</h1>  
        <div class="well ">

          <?php echo form_open_multipart('/posts/edit_post/'.$this->uri->segment(3)); ?>
          <label for="">Title</label> 
          <div class="form-group">
            <input type="text" name="title" value="<?php echo $post[0]['title']; ?>" class="form-control" />
            <?php echo form_error('title'); ?>
          </div>
          <label for="">Image</label>
          <div class="form-group">
            <img width="100" height="100" src="<?php echo base_url(); ?>/assets/uploads/<?php echo $post[0]['image_path'];  ?>" alt="..."> 
            <br />
            <br />
            <input type="file" name="userfile" class="form-control" size="20" /> 
            <?php echo $this->ci_alerts->display(); ?>
            <?php if(isset($file_errors) ) echo $file_errors; ?>
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
          <input type="hidden" name="id" value="<?php echo $post[0]['id']; ?>" />
          <input id="submit" type="submit" name="submit" value="Save" class="btn btn-primary" />
          <!-- <button name="submit" class="btn btn-primary" type="submit">Save</button> -->
          <?php echo form_close();   ?> 
        </div>

      </div>

    </div><!-- /.container -->

<?php $this->load->view('templates/partials/footer'); ?>