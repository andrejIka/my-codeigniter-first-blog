<?php $this->load->view('templates/partials/header'); ?>

    <div class="container">
      
      <?php echo partial('templates/partials/menu', array('active' => 1)); ?> 


      <div class="text-left">
        <h1>Search posts</h1>  
        <div class="well "> 
          <?php echo form_open('/posts/search/'); ?>
          <label for="">Enter a search info</label> 
          <div class="form-group">
            <input type="text" name="search_info" value="" class="form-control" />
            <?php echo form_error('search_info'); ?>
          </div> 
          <input id="submit" type="submit" name="submit" value="Search" class="btn btn-primary" /> 
          <?php echo form_close();   ?> 
        </div>
        <?php 
          if(isset($search_results))  { 
            echo '<div class="alert alert-success">'.$result.'</div>';
            foreach ($search_results as $result) {
              echo '<div class="well"> <a href="" title="">'.$result->title.'</a> <br> <p>'.word_limiter($result->content, 10).'...</p> </div>';
            }
          }
        ?> 
      </div>

    </div><!-- /.container -->

<?php $this->load->view('templates/partials/footer'); ?>