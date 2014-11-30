	 
      <br />
      <ul class="nav nav-pills nav-justified">
        <li{if isset($active_item) && $active_item == '1'  } class="active" {/if}><a href='{$baseurl}posts/'   title="">Posts</a></li>
        <li{if isset($active_item) && $active_item == '2'  } class="active" {/if}><a href='{$baseurl}upload/'  title="">Uploads</a></li>
        <li{if isset($active_item) && $active_item == '3'  } class="active" {/if}><a href='{$baseurl}calendar/'  title="">Calendar</a></li>
        <li{if isset($active_item) && $active_item == '4'  } class="active" {/if}><a href='{$baseurl}calendar/calendar_tasks/'  title="">Calendar tasks</a></li>  
      </ul>
      <br />