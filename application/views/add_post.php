<?php $this->load->view('partials/header'); ?>

    <div class="container">

      <div class="text-left">
        <h1>Add</h1>  
        <div class="well ">

          <?php echo form_open_multipart('/add_post/'); ?>
          <?php //echo validation_errors(); ?>
          <label for="">Title</label> 
          <div class="form-group">
            <input type="text" name="title" value="<?php echo $post[0]['title']; ?>" class="form-control" />
            <?php echo form_error('title'); ?>
          </div>
          <label for="">File upload</label>
          <div class="form-group">
            <input type="file" name="userfile" class="form-control" size="20" /> 
            <?php echo $this->session->flashdata('message');  ?>
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
          <input type="submit" id="submit" name="submit" value="Save" class="btn btn-primary" />
          <!-- <button name="submit" class="btn btn-primary" type="submit">Save</button> -->
          <?php echo form_close();   ?> 
        </div>

      </div>

    </div><!-- /.container -->

<?php $this->load->view('partials/footer'); ?>