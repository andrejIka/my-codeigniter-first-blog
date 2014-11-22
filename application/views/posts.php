<?php $this->load->view('partials/header'); ?>

    <div class="container">
      <br />
      <ul class="nav nav-pills nav-justified">
        <li class="active"><a href='<?php echo site_url("/posts/"); ?>'   title="">Posts</a></li>
        <li><a href='<?php echo site_url("/upload/"); ?>'  title="">Uploads</a></li>
      </ul>
      <br />
      <h2>Blog posts <a href="<?php echo site_url("/add_post/"); ?>" title="" class="btn btn-default">Add post</a></h2>  
      <?php echo $this->session->flashdata('message');  ?>
      <?php foreach ($posts as $post): ?>
      <div class="well media">
        <a href="<?php echo site_url("/delete_post/".$post->id); ?>" title="" class="btn btn-danger pull-right" onclick="if(!confirm('Want to delete?')) return false;" ><span class="glyphicon glyphicon-remove"></span></a>
        <span class="media-left">
          <img width="100" height="100" src="<?php echo base_url(); ?>/assets/uploads/<?php echo $post->image_path;  ?>" alt="...">
        </span>
        <div class="media-body">

          <h4 class="media-heading text-left clearfix">
            <a href="<?php echo site_url("/edit_post/".$post->id); ?>" title="" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
            <?php echo $post->title; ?>  
          </h4>
          <p class="text-left"><?php echo $post->content; ?></p>
          <p class="text-left"><small>Author: <strong><?php echo $post->author; ?></strong></small></p> 
        </div>
      </div>
      <?php endforeach ?>

     <p><?php echo $links; ?></p>       

    </div><!-- /.container -->

<?php $this->load->view('partials/footer'); ?>