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

      {if $filters}
      <section id="filters">
{include file="fragments/filter-list.tpl"}
      </section>
      {/if}

      {if $params->import}
      <p><b>Showing version imported on {$import->stamp|escape} by {$import->usr_name}.</b></p>
      {/if}

      <nav class="options col4">
        <li><a href="data.csv{$filters|params:'tag':$tag->tag}">CSV</a></li>
        <li><a href="data.json{$filters|params:'tag':$tag->tag}">JSON</a></li>
        <li><a href="data.xml{$filters|params:'tag':$tag->tag}">XML</a></li>
        <li><a href="data.n3{$filters|params:'tag':$tag->tag}">RDF (N3)</a></li>
      </nav>

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
            <td>{$value->content|escape}</td>
            {/foreach}
          </tr>
          {/foreach}
        </tbody>
      </table>
    </main>

    <aside>
      {include file="fragments/filters.tpl"}
    </aside>
  </body>
</html>