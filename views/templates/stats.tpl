<!DOCTYPE html>

<html>
  <head>
    <title>#{$tag->tag|escape} in {$import->dataset_name|escape}</title>
{include file="fragments/metadata.tpl"}
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery.csv-0.71.min.js"></script>
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Datasets</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
    </nav>

    <main>
      <h1>#{$tag->tag|escape} in {$import->dataset_name|escape}</h1>

      <section id="chart">
        <div id="chart_div"></div>
      </section>

      <section id="data">

        <nav class="options col2">
          <li><a href="stats.csv?tag={$tag->tag|escape:'url'}">Download as CSV</a></li>
          <li><a href="stats.json?tag={$tag->tag|escape:'url'}">Download as JSON</a></li>
        </nav>

        <table>
          <thead>
            <th>Value</th>
            <th>Count</th>
          </thead>
          <tbody>
            {foreach $stats as $stat}
            <tr>
              <td>{$stat->value|none}</td>
              <td>{$stat->count|number_format}</td>
            </tr>
            {/foreach}
          </tbody>
        </table>
      </section>

    </main>
    <script type="text/javascript" src="/scripts/charts.js"></script>
    <script type="text/javascript">
      var chart_url = "{$import|dataset_link}/stats.csv{$filters|params:'tag':$tag->tag}";
      {literal}
      // Load the Google stuff
      google.load("visualization", "1", {packages:["corechart"]});

      // Set the callback
      google.setOnLoadCallback(drawChart);
      {/literal}
    </script>
  </body>
</html>