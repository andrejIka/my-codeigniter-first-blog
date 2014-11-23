<?php $this->load->view('partials/header'); ?>
  
  <br />
 
  <h1>Edit calendar event information </h1>
   <?php //$this->output->enable_profiler(TRUE); ?>
        <?php echo form_open('/calendar/edit/'.$this->uri->segment(3)); ?> 
        <?php echo $this->session->flashdata('message');  ?>
          
          <div class="row">
            <div class="col-xs-3">
              <label for="">Title</label>
              <div class="form-group">
                <input type="text" name="title" value="<?php echo $title; ?>" class="form-control" size="20" /> 
                <input type="hidden" name="id" value="<?php echo $id; ?>"  /> 
                <?php echo form_error('title'); ?>
              </div> 
            </div>  
            <div class="col-xs-4">
              <label for="">Body</label>
              <div class="form-group">
                <input type="text" name="body" value="<?php echo $body; ?>" class="form-control" size="20" /> 
                <?php echo form_error('body'); ?>
              </div> 
            </div>  
            <div class="col-xs-3">
              <label for="">Due</label>
              <div class="form-group">
                <input type="text" name="due" value="<?php echo $due; ?>" class="form-control datepicker" size="20" /> 
                <?php echo form_error('due'); ?>
              </div> 
            </div>  
            <div class="col-xs-2">
              <label for="">&nbsp;</label>
              <input type="submit" id="submit" name="submit" value="Save" class="btn btn-primary btn-block" />
            </div>  
          </div>

        <?php echo form_close();   ?> 
    

<br /> 

<?php $this->load->view('partials/footer'); ?>