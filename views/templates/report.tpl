<!DOCTYPE html>

<html>
  <head>
    <title>Report</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      {if $import}
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {if $params->stamp}
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
      {/if}
      {/if}
    </nav>
    <main>
      {if $import}
      <h1>{$import->dataset_name|escape}</h1>
      {/if}

      <table>
        <thead>
          <tr>
            {foreach item=col from=$cols}
            <th>{$col->tag_name|escape}</th>
            {/foreach}
          </tr>
          <tr>
            {foreach item=col from=$cols}
            <th class="tag"><a href="{$col|tag_link}">#{$col->tag|escape}</a></th>
            {/foreach}
          </tr>
        </thead>
        <tbody>
          {$last_row = -1}
          {foreach item=value from=$values}
          {if $last_row != -1 and $last_row != $value->row}
          {report_row cols=$cols cells=$cells}
          {$cells = []}
          {/if}
          {append var=cells value=$value}
          {$last_row = $value->row}
          {/foreach}
          {report_row cols=$cols cells=$cells}
        </tbody>
      </table>

    </main>
  </body>
</html>