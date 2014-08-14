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
      {if $params->import}
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
      {$baseurl=$import|import_link}
      {else}
      {$baseurl=$import|dataset_link}
      {/if}
    </nav>

    <main>
      <h1>#{$tag->tag|escape} in {$import->dataset_name|escape}</h1>

      <p><i><a href="{$baseurl|escape}">View a different tag</a></i></p>

      {if $params->import}
      <p><b>Showing version imported on {$import->stamp|escape} by {$import->usr_name}.</b></p>
      {/if}

      <p>This is a summary of the different values that appear for <a
      href="{$tag|tag_link}">#{$tag->tag|escape}</a>
      ({$tag->tag_name|escape}) in the dataset <cite><a
      href="{$dataset|dataset_link}">{$import->dataset_name|escape}</a></cite>.</p>

      <section id="filters">
        {if $filters}
        <p><b>Active filters:</b></p>
        {include file="fragments/filter-list.tpl"}
        {/if}

        <p id="new-filters">
          <b>Add a new filter:</b>
          {foreach $filter_tags as $filter_tag}
          {$url = "stats/filter/`$filter_tag|escape:'url'``$filters|params:'tag':$tag->tag`"}
          <a href="{$url|escape}" onclick="window.open('{$url|escape}', 'Filter', 'height=600, width=400').focus(); return false;">#{$filter_tag|escape}</a>
          {/foreach}
        </p>
      </section>

      <section id="chart">
        <div id="chart_div"></div>
      </section>

      <section id="data">

        <nav class="options col3">
          <li><a href="{$baseurl}/data{$filters|params}">Full data</a></li>
          <li><a href="{$baseurl}/stats.csv{$filters|params:'tag':$tag->tag}">Summary CSV</a></li>
          <li><a href="{$baseurl}/stats.json{$filters|params:'tag':$tag->tag}">Summary JSON</a></li>
        </nav>

        <table>
          <thead>
            <th>Value</th>
            <th>Count</th>
          </thead>
          <tbody>
            {foreach $stats as $stat}
            <tr>
              <td>{$stat->content|none}</td>
              <td>{$stat->count|number_format}</td>
            </tr>
            {/foreach}
          </tbody>
        </table>
      </section>

    </main>
    <script type="text/javascript" src="/scripts/charts.js"></script>
    <script type="text/javascript">
      var chart_url = "{$baseurl}/stats.csv{$filters|params:'tag':$tag->tag}";
      {if $tag->datatype == 'Number'}
      var chart_type = 'column';
      {else}
      var chart_type = 'pie';
      {/if}
      {literal}
      // Load the Google stuff
      google.load("visualization", "1", {packages:["corechart"]});

      // Set the callback
      google.setOnLoadCallback(drawChart);
      {/literal}
    </script>
  </body>
</html>