<?php $this->load->view('partials/header'); ?>
  
  <?php echo partial('partials/menu', array('active' => 5)); ?> 

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