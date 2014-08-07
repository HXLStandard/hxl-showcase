<html>
  <head>
    <title>Filter by tag</title>
    {if $params->import}
    {$baseurl = $import|import_link}
    {else}
    {$baseurl = $import|dataset_link}
    {/if}
  </head>
  <body>
    <p>Choose a filter value for #{$filter_tag->tag|escape} ({$filter_tag->tag_name|escape}):</p>
    <ul>
    {foreach $options as $option}
    {$url = "`$baseurl`/stats`$filters|params:'tag':$params->tag:$params->filter_tag:$option->value`"}
    <li><a href="{$url|escape}" onclick="return do_link('{$url|escape}')">{$option->value|none}</a> ({$option->count|number_format})</li>
    {/foreach}
    </ul>
    <script type="text/javascript">
      function do_link(url) {
        window.opener.location.href=url;
        window.opener.focus();
        window.close();
        return false;
      }
    </script>
  </body>
</html>