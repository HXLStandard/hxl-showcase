<!DOCTYPE html>

<html>
  <head>
    <title>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery.csv-0.71.min.js"></script>
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
    </nav>

    <main>
      <h1>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</h1>
      
      {if $filters}
      <p><strong>Showing:</strong><br />
      {foreach key=tag item=value from=$filters}
      #{$tag|escape} = &ldquo;{$value|none}&rdquo;<br />
      {/foreach}
      (<a href="?">Clear all</a>)
      </p>
      {/if}

      <nav class="options col2">
        <li><a href="?">Show all</a></li>
        <li><a href="analysis.csv{$filters|params}">Download CSV</a></li>
      </nav>
      
      <p>{$total|number_format} matching activit{$total|plural:'y':'ies'}.</p>

      {if $country_count > 0}
      <section id="countries">
        <h2>Top countries</h2>
        <p>Total countries: {$country_count|number_format}</p>
        <ol>
          {foreach item=country from=$countries}
          <li><a href="analysis{$filters|params:'country':$country->value}">{$country->value|none}</a> ({$country->count|number_format} activit{$country->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $adm1_count > 0}
      <section id="adm1">
        <h2>Top admin level 1 subdivisions</h2>
        <p>Total admin level 1 subdivisions: {$adm1_count|number_format}</p>
        <ol>
          {foreach item=adm1 from=$adm1s}
          <li><a href="{$filters|params:'adm1':$adm1->value}">{$adm1->value|none}</a> ({$adm1->count|number_format} activit{$adm1->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $adm2_count > 0}
      <section id="adm2">
        <h2>Top admin level 2 subdivisions</h2>
        <p>Total admin level 2 subdivisions: {$adm2_count|number_format}</p>
        <ol>
          {foreach item=adm2 from=$adm2s}
          <li><a href="{$filters|params:'adm2':$adm2->value}">{$adm2->value|none}</a> ({$adm2->count|number_format} activit{$adm2->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $adm3_count > 0}
      <section id="adm3">
        <h2>Top admin level 3 subdivisions</h2>
        <p>Total admin level 3 subdivisions: {$adm3_count|number_format}</p>
        <aside id="chart"></aside>
        <ol>
          {foreach item=adm3 from=$adm3s}
          <li><a href="{$filters|params:'adm3':$adm3->value}">{$adm3->value|none}</a> ({$adm3->count|number_format} activit{$adm3->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $adm4_count > 0}
      <section id="adm4">
        <h2>Top admin level 4 subdivisions</h2>
        <p>Total admin level 4 subdivisions: {$adm4_count|number_format}</p>
        <ol>
          {foreach item=adm4 from=$adm4s}
          <li><a href="{$filters|params:'adm4':$adm4->value}">{$adm4->value|none}</a> ({$adm4->count|number_format} activit{$adm4->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $adm5_count > 0}
      <section id="adm5">
        <h2>Top admin level 5 subdivisions</h2>
        <p>Total admin level 5 subdivisions: {$adm5_count|number_format}</p>
        <ol>
          {foreach item=adm5 from=$adm5s}
          <li><a href="{$filters|params:'adm5':$adm5->value}">{$adm5->value|none}</a> ({$adm5->count|number_format} activit{$adm5->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $sector_count > 0}
      <section id="sectors">
        <h2>Top sectors</h2>
        <p>Total sectors: {$sector_count|number_format}</p>
        <ol>
          {foreach item=sector from=$sectors}
          <li><a href="{$filters|params:'sector':$sector->value}">{$sector->value|none}</a> ({$sector->count|number_format} activit{$sector->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $org_count > 0}
      <section id="orgs">
        <h2>Top organisations</h2>
        <p>Total organisations: {$org_count|number_format}</p>
        <ol>
          {foreach item=org from=$orgs}
          <li><a href="{$filters|params:'org':$org->value}">{$org->value|none}</a> ({$org->count|number_format} activit{$org->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

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

    <script type="text/javascript">
      {literal}
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
   // grab the CSV
   $.get("?tag=adm3", function(csvString) {
      // transform the CSV string into a 2-dimensional array
      var arrayData = $.csv.toArrays(csvString, {onParseValue: $.csv.hooks.castToScalar});

      // this new DataTable object holds all the data
      var data = new google.visualization.arrayToDataTable(arrayData);

      // this view can select a subset of the data at a time
      var view = new google.visualization.DataView(data);
      view.setColumns([0,1]);

     // set chart options
     var options = {
        title: "#adm3",
        hAxis: {title: data.getColumnLabel(0), minValue: data.getColumnRange(0).min, maxValue: data.getColumnRange(0).max},
        vAxis: {title: data.getColumnLabel(1), minValue: data.getColumnRange(1).min, maxValue: data.getColumnRange(1).max},
        height: 600,
        width: 600
     };

     // create the chart object and draw it
     var chart = new google.visualization.PieChart(document.getElementById('chart'));
     chart.draw(view, options);
  });
}
      {/literal}
    </script>

  </body>
</html>