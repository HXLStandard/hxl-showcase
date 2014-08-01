<!DOCTYPE html>

<html>
  <head>
    <title>Analysis: {$import->dataset_name|escape} ({if $stamp}{$stamp|escape}{else}latest{/if})</title>
    <link rel="stylesheet" href="/style/default.css" />
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery.csv-0.71.min.js"></script>
    <script type="text/javascript">
      var chart_tags = [];
      var filters = {$filters|json_encode};
    </script>
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {if $stamp}
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
      {/if}
    </nav>

    <main>
      <h1>Analysis: {$import->dataset_name|escape} ({if $stamp}{$stamp|escape}{else}latest{/if})</h1>

      <p>This page demonstrates how HXL tags enable advanced analysis
      and filtering of humanitarian data. Select items below to filter
      the views (by geography, sector, organisation, etc.): the totals
      and visualisations will update automatically to match your
      filters. You can also download a filtered version of your HXL
      data.</p>
      
      <section id="filters">
        <h2>Current filters</h2>

        <p>({$total|number_format} matching entr{$total|plural:'y':'ies'}.)</p>

        {foreach key=tag item=value from=$filters}
        <p>#{$tag|escape} = &ldquo;{$value|none}&rdquo;</p>
        {foreachelse}
        <p>(No active filters: showing the full dataset.)</p>
        {/foreach}

      </section>

      <nav class="options col2">
        <li><a href="?">Clear filters</a></li>
        <li><a href="analysis.csv{$filters|params}">Download HXL</a></li>
      </nav>
      
      {foreach key=tag item=total from=$tag_totals}
      {if $total > 0}
      <section id="tag_{$tag|escape}">
        <h2>#{$tag|escape} ({$total|number_format})</h2>
        <aside id="{$tag|escape}_chart"></aside>
        <p class="filters">
          <b>Filter by</b>
          {foreach item=value from=$tag_values[$tag]}
          <span><a href="analysis{$filters|params:$tag:$value->value}">{$value->value|none}</a> ({$value->count|number_format})</span>
          {/foreach}
        </p>
        <script type="text/javascript">
          chart_tags.push({$tag|json_encode});
        </script>
      </section>
      {/if}
      {/foreach}

      <section id="data">
        <h2>Matching data</h2>
        <table> 
          <thead>
            <tr class="tags">
              {foreach item=col from=$cols}
              <th><a href="{$col|tag_link}">{$col->tag_name|escape}</a></th>
              {/foreach}
            </tr>
          </thead>
          <tbody>
            <tr>
              {foreach item=value from=$values}
              {if $last_row and ($last_row != $value->row)}
            </tr>
            <tr>
              {/if}
              {assign var=last_row value=$value->row}
              <td>{$value->value|escape}</td>
              {/foreach}
            </tr>
          </tbody>
        </table>
      </section>

    </main>

    <script type="text/javascript" src="/scripts/import-analysis-charts.js"></script>

  </body>
</html>