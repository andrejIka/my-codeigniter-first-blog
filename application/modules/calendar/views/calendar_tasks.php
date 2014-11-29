<?php $this->load->view('templates/partials/header'); ?>
  
  <?php echo partial('templates/partials/menu', array('active' => 5)); ?> 

  <h1>Here's the Ajax   </h1>
  
  <?php echo form_open('/calendar/calendar_tasks/'); ?> 
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

  $this->load->view('templates/partials/footer'); ?>