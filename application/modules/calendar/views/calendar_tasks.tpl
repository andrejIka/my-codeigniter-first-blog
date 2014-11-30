{include file="../../templates/views/partials/header.tpl"}

  {include file="../../templates/views/partials/menu.tpl" active_item="4"} 

  <h1>Here's the Calendar checklist</h1>

    {form_open('/calendar/calendar_tasks/')}
      {foreach from=$data item=event }
      <div class="well{if $event->completed=="1"  } done{/if}" id="{$event->id}">
        <div class="checkbox">
          <label>
            <input type="checkbox" {if $event->completed=="1"  } checked="true"{/if} class="checkbox" id="{$event->id}" value="{$event->completed}" />
            <strong>{$event->title}</strong>
          </label>
        </div>
        <p>{$event->body}</p>
      </div>
      {/foreach}
    {form_close()}   


{include file="../../templates/views/partials/footer.tpl"}