<?php $this->load->view('templates/partials/header'); ?>
<?php echo partial('templates/partials/menu', array('active' => 2)); ?> 

    <h2>This is showing images</h2>

    <div class="well images-well">
      {all_images}
        <div class="image-holder">
          <a href="{image_path}/{image_url}"   title="" target="_blank">
            <img src="{image_path}/{thumb_url}" alt="" class="img-thubmnail" /> 
          </a>
          <a href="{delete_path}/{id}" data-id="{id}" class="btn btn-default remove-image-link" title=""> <span class="glyphicon glyphicon-remove"></span> </a>
        </div>
      {/all_images}
    </div>


    

  

<?php $this->load->view('templates/partials/footer'); ?>