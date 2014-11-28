
<?php $this->load->view('partials/header'); ?>


<div class="row">
  <div class="col-xs-3"></div>
  <div class="col-xs-6">

<h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php 
  if($message){
    ?>
    <div class="alert alert-info">
      <?php echo $message; ?>
    </div>
    <?php
  }
?>
</div>

<div class="well">
  
<?php echo form_open("auth/login");?>
  
  <div class="form-group">
    <?php echo lang('login_identity_label', 'identity');?>
    <?php 
      $identity['class']="form-control focused";
      $identity['value']="admin@admin.com";
      echo form_input($identity);
    ?>
  </div><!-- /.form-group -->  
    
  <div class="form-group"> 
    <?php echo lang('login_password_label', 'password');?>
    <?php 
      $password['class']="form-control";
      $password['value']="123456789";
      echo form_input($password);?> 
  </div><!-- /.form-group -->  

    <?php echo lang('login_remember_label', 'remember');?>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
  </p>


  <div class="form-group"> 
    <div class="row">
      <div class="col-xs-6"><button class="btn btn-primary btn-block" name="submit" type="submit"> <?php echo lang('login_submit_btn'); ?> </button></div>
      <div class="col-xs-6">
<!--  
        <a href="<?php echo site_url('/auth/create_user'); ?> " title="" class="btn btn-primary btn-block">Register here</a>
-->
      </div>
    </div>
    
  </div><!-- /.form-group -->  

<?php echo form_close();?>
 
<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

     
</div>

<?php $this->load->view('partials/footer'); ?>