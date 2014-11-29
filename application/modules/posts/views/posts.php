<?php $this->load->view('templates/partials/header'); ?>

    <div class="container">
      <?php echo partial('templates/partials/menu', array('active' => 1)); ?> 
      <h2 class="clearfix">
        Blog posts 
          <a href="<?php echo site_url("/posts/add_post/"); ?>" title="" class="btn btn-default">Add post</a>
          <a href="<?php echo site_url("/posts/search/"); ?>" title="" class="btn btn-default">Search post info</a>
        <?php  if(!empty($posts)){  ?>
          <span class="pull-right">
            <a href="<?php echo site_url("/posts/export_posts"); ?>" class="btn btn-default">  Export posts <span class="glyphicon glyphicon-download-alt"> </span></a> 
          </span>
        <?php } ?>
      </h2>  
      <?php echo $this->ci_alerts->display(); ?>
      <?php foreach ($posts as $post): ?>
      <div class="well media">
        <a href="<?php echo site_url("/posts/delete_post/".$post->id); ?>" title="" class="btn btn-danger pull-right" onclick="if(!confirm('Want to delete?')) return false;" ><span class="glyphicon glyphicon-remove"></span></a>
        <span class="media-left">
          <img width="100" height="100" src="<?php echo base_url(); ?>/assets/uploads/<?php echo $post->image_path;  ?>" alt="...">
        </span>
        <div class="media-body">

          <h4 class="media-heading text-left clearfix">
            <a href="<?php echo site_url("/posts/edit_post/".$post->id); ?>" title="" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
            <?php echo $post->title; ?>  
          </h4>
          <p class="text-left"><?php echo $post->content; ?></p>
          <p class="text-left"><small>Author: <strong><?php echo $post->author; ?></strong></small></p> 
        </div>
      </div>
      <?php endforeach ?>

     <p><?php echo $links; ?></p>       

    </div><!-- /.container -->

<?php $this->load->view('templates/partials/footer'); ?>