{include file="../../templates/views/partials/header.tpl"}

    <div class="starter-template">
      <h1>Bootstrap starter template</h1>
      <ul class="text-left"> 
      {foreach from=$blog_entries item=article }
      <li>
        <h3>{$article.title}</h3>
        <p>{$article.body}</p>
      </li>
      {/foreach}
      </ul> 
    </div>

{include file="../../templates/views/partials/footer.tpl"}