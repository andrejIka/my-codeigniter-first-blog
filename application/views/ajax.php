<?php $this->load->view('partials/header'); ?>
  
  <br />
  <ul class="nav nav-pills nav-justified">
    <li class="active"><a href='<?php echo site_url("/posts/"); ?>'   title="">Posts</a></li>
    <li><a href='<?php echo site_url("/upload/"); ?>'  title="">Uploads</a></li>
    <li><a href='<?php echo site_url("/search/"); ?>'  title="">Search posts</a></li>
    <li><a href='<?php echo site_url("/calendar/"); ?>'  title="">Calendar</a></li>
    <li><a href='<?php echo site_url("/ajax/"); ?>'  title="">Ajax</a></li>  
  </ul>
  <br />

  <h1>Here's the Ajax   </h1>
  
  <?php echo form_open('/ajax/'); ?> 
    <?php  

      // print_r($data);
      foreach ($data as $key) {
        ?> 
        <div id="<?php echo $key->id; ?>" class="well <?php if($key->completed=="1") echo "done"; ?>"> 
          <div  class="checkbox">
            <label><input type="checkbox" value="<?php echo $key->completed; ?>" <?php if($key->completed=="1") echo "checked"; ?> id="<?php echo $key->id; ?>" class="checkbox" /> <strong ><?php echo $key->title; ?></strong></label> 
          </div>
          <p><?php echo $key->body;  ?></p> 
        </div> 
        <?
      }

  echo form_close();   

  $this->load->view('partials/footer'); ?>