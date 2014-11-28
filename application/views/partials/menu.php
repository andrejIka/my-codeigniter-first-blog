
      <br />
      <ul class="nav nav-pills nav-justified">
        <li<?php if($active==1) echo ' class="active"'; ?>><a href='<?php echo site_url("/posts/"); ?>'   title="">Posts</a></li>
        <li<?php if($active==2) echo ' class="active"'; ?>><a href='<?php echo site_url("/upload/"); ?>'  title="">Uploads</a></li>
        <li<?php if($active==3) echo ' class="active"'; ?>><a href='<?php echo site_url("/search/"); ?>'  title="">Search posts</a></li>
        <li<?php if($active==4) echo ' class="active"'; ?>><a href='<?php echo site_url("/calendar/"); ?>'  title="">Calendar</a></li>
        <li<?php if($active==5) echo ' class="active"'; ?>><a href='<?php echo site_url("/ajax/"); ?>'  title="">Ajax</a></li>  
      </ul>
      <br />