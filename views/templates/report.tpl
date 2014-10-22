<!DOCTYPE html>

<html>
  <head>
    <title>Report</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body class="twocol">
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="http://hxlstandard.org">HXL home</a></li>
      <li><a href="/">Demo</a></li>
      <li><a href="/source">Data providers</a></li>
      {if $import}
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {if $params->import}
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
      {$baseurl=$import|import_link}
      {else}
      {$baseurl=$import|dataset_link}
      {/if}
      {/if}
    </nav>

    <main>
      {if $import}
      <h1>{$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</h1>
      {/if}

      <table>
        {if $filters}
        <caption>Showing {$filtered_count|number_format} of {$total_count|number_format} row{$total_count|plural:'':'s'} (filtered)</caption>
        {else}
        <caption>Showing all {$total_count|number_format} row{$total_count|plural:'':'s'} (no filters)</caption>
        {/if}

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
{if $params->tag}
      <p class="browse-link">
        <a href="{$baseurl}/stats{$filters|params:'tag':$params->tag}">Analyze</a> |
{if $cols|is_geocoded}
        <a href="{$baseurl}/map{$filters|params:'tag':$params->tag}">Map</a> |
{/if}
        <a><strong>Browse</strong></a>
      </p>
{/if}
      <section>
        <h2>Filters</h2>
        <p>Use HXL hashtags to filter the data.</p>
        {include file="fragments/filters.tpl" type="data"}
      </section>
      <section id="links">
        <h2>Downloads</h2>
        {if $filters}
        <p>These downloads include only the <b>filtered</b> data.</p>
        {/if}
        <ul class="links">
          <li><a href="{$baseurl}/data.csv{$filters|params}">CSV</a> (spreadsheet)</li>
          <li><a href="{$baseurl}/data.json{$filters|params}">JSON</a></li>
          <li><a href="{$baseurl}/data.xml{$filters|params}">XML</a></li>
          <li><a href="{$baseurl}/data.n3{$filters|params}">RDF (N3)</a></li>
        </ul>
      </section>
    </aside>
  </body>
</html>