<!DOCTYPE html>

<html>
  <head>
    <title>#{$tag->tag|escape} in {$import->dataset_name|escape}</title>
    {include file="fragments/metadata.tpl"}
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery.csv-0.71.min.js"></script>
  </head>
  <body class="twocol">
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="http://hxlstandard.org">HXL home</a></li>
      <li><a href="/">Demo</a></li>
      <li><a href="/source">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {if $params->import}
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
      {$baseurl=$import|import_link}
      {else}
      {$baseurl=$import|dataset_link}
      {/if}
    </nav>

    <main>
      <h1>Mapping #<span class="tag">{$tag->tag|escape}</span> in {$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</h1>

{if $count > 400}
      <p class="warning">Mapping only first 400 of {$count|number_format} locations. Please filter using the options on the right to narrow your view.</p>
{/if}

      <section id="chart">
        <div id="chart_div"></div>
      </section>

    </main>


    <aside>

      <p class="browse-link">
        <a href="{$baseurl}/stats{$filters|params:'tag':$params->tag}">Analyze</a> |
        <a><strong>Map</strong></a> |
        <a href="{$baseurl}/data{$filters|params:'tag':$params->tag}">Browse</a>
      </p>

      <section>
        <h2>Filters</h2>
        {include file="fragments/filters.tpl" type="map"}
      </section>

      <section id="links">
        <h2>Downloads</h2>
        <p>These downloads include only the <b>filtered</b> data.</p>
        <ul class="links">
          <li><a href="{$baseurl}/map.csv{$filters|params}">CSV</a> (spreadsheet)</li>
          <li><a href="{$baseurl}/map.json{$filters|params}">JSON</a></li>
          <li><a href="{$baseurl}/map.xml{$filters|params}">XML</a></li>
          <li><a href="{$baseurl}/map.n3{$filters|params}">RDF (N3)</a></li>
        </ul>
      </section>
    </aside>

    <script type="text/javascript" src="/scripts/charts.js"></script>
    <script type="text/javascript">
      var chart_url = "{$baseurl}/map.csv{$filters|params:'tag':$tag->tag}";
      var chart_type = 'map';
      {literal}
      // Load the Google stuff
      google.load("visualization", "1", {packages:["corechart", "map"]});

      // Set the callback
      google.setOnLoadCallback(drawChart);
      {/literal}
    </script>
  </body>
</html>
