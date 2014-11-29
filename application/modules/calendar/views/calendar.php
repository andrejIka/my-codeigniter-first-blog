<?php $this->load->view('templates/partials/header'); ?>
  
  <?php echo partial('templates/partials/menu', array('active' => 4)); ?> 

  <h1>Here's the calendar <a class="btn btn-primary" href="<?php echo site_url('/calendar/'); ?> "> <span class="glyphicon glyphicon-home"></span> </a> </h1>
  
        <?php echo form_open('/calendar/'); ?> 
        <?php echo $this->ci_alerts->display(); ?>
          
          <div class="row">
            <div class="col-xs-3">
              <label for="">Title</label>
              <div class="form-group">
                <input type="text" name="title" class="form-control" size="20" /> 
                <?php echo form_error('title'); ?>
              </div> 
            </div>  
            <div class="col-xs-4">
              <label for="">Body</label>
              <div class="form-group">
                <input type="text" name="body" class="form-control" size="20" /> 
                <?php echo form_error('body'); ?>
              </div> 
            </div>  
            <div class="col-xs-3">
              <label for="">Date</label>
              <div class="form-group">
                <input type="text" name="date" class="form-control datepicker" size="20" /> 
                <?php echo form_error('date'); ?>
              </div> 
            </div>  
            <div class="col-xs-2">
              <label for="">&nbsp;</label>
              <input type="submit" id="submit" name="submit" value="Save" class="btn btn-primary btn-block" />
            </div>  
          </div>

        <?php echo form_close();   ?> 
    

<br />
  <?php 
    echo $calendar;
   ?>

<?php $this->load->view('templates/partials/footer'); ?>