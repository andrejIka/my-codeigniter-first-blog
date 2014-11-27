<?php $this->load->view('partials/header'); ?>

    <div class="container">
      
      <br />
      <ul class="nav nav-pills nav-justified">
        <li><a href='<?php echo site_url("/posts/"); ?>'   title="">Posts</a></li>
        <li><a href='<?php echo site_url("/upload/"); ?>'  title="">Uploads</a></li>
        <li class="active"><a href='<?php echo site_url("/search/"); ?>'  title="">Search posts</a></li>
        <li><a href='<?php echo site_url("/calendar/"); ?>'  title="">Calendar</a></li>
        <li><a href='<?php echo site_url("/ajax/"); ?>'  title="">Ajax</a></li>  
      </ul>
      <br />


      <div class="text-left">
        <h1>Search posts</h1>  
        <div class="well "> 
          <?php echo form_open('/search/'); ?>
          <label for="">Enter a search info</label> 
          <div class="form-group">
            <input type="text" name="search_info" value="" class="form-control" />
            <?php echo form_error('search_info'); ?>
          </div> 
          <input id="submit" type="submit" name="submit" value="Search" class="btn btn-primary" /> 
          <?php echo form_close();   ?> 
        </div>
        <?php 
          if(isset($search_results)) {   
            $this->load->helper('text');
            echo '<div class="alert alert-success">'.$result.'</div>';
            foreach ($search_results as $result) {
              echo '<div class="well"> <a href="" title="">'.$result->title.'</a> <br> <p>'.word_limiter($result->content, 10).'...</p> </div>';
            }
          }
        ?> 
      </div>

    </div><!-- /.container -->

<?php $this->load->view('partials/footer'); ?>