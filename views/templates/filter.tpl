<html>
  <head>
    <title>Filter by {$filter_tag->tag_name|escape}</title>
    <link rel="stylesheet" href="/style/popup.css" />
    <meta name="viewport" content="width=device-width" />
    <script type="text/javascript" src="/scripts/ga.js"></script>
    {if $params->import}
    {$baseurl = $import|import_link}
    {else}
    {$baseurl = $import|dataset_link}
    {/if}
  </head>
  <body>
    <h1>Filter by &ldquo;{$filter_tag->tag_name|escape}&rdquo;</h1>
    <p>Show only data rows where #{$filter_tag->tag|escape} has the following value:</p>
    <ul>
    {foreach $options as $option}
    {$url = "`$baseurl`/`$params->type``$filters|params:'tag':$params->tag:$params->filter_tag:$option->content`"}
    <li><a href="{$url|escape}" onclick="return do_link('{$url|escape}')">{$option->content|none}</a> <span class="count">{$option->count|number_format}</span></li>
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