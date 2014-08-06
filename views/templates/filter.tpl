<html>
  <head>
    <title>Filter by tag</title>
  </head>
  <body>
    {if $params->import}
    {$baseurl = $import|import_link}
    {else}
    {$baseurl = $import|dataset_link}
    {/if}
    <ul>
    {foreach $options as $option}
    <li><a href="{$baseurl}/stats{$filters|params:'tag':$params->tag:$params->filter_tag:$option->value}">{$option->value|none}</a> ({$option->count|number_format})</li>
    {/foreach}
    </ul>
  </body>
</html>