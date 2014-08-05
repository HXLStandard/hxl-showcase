<!DOCTYPE html>

<html>
  <head>
    <title>Report</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      {if $import}
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {if $params->import}
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
            {foreach $cols as $col}
            <th>{$col->header|escape}</th>
            {/foreach}
          </tr>
          <tr>
            {foreach $cols as $col}
            <th class="tag"><a href="{$col|tag_link}">#{$col->tag|escape}</a></th>
            {/foreach}
          </tr>
        </thead>
        <tbody>
          {foreach $rows as $row}
          <tr>
            {foreach $row as $value}
            <td>{$value->value|escape}</td>
            {/foreach}
          </tr>
          {/foreach}
        </tbody>
      </table>

    </main>
  </body>
</html>