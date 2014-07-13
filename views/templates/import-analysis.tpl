<!DOCTYPE html>

<html>
  <head>
    <title>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
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

      {if $data}
      <nav class="options">
        <li><a href="{$import|import_link}/analysis.csv?{$queryString|escape}">Download CSV</a></li>
      </nav>
      {/if}

      <form method="get" action="">
        <strong>Include:</strong>
        {foreach item=field from=$allowed_fields}
        <label class="checklist">
          <span>{$field|escape}</span>
          <input type="radio" name="groupBy[]" value="{$field|escape}"{if $field|in_array:$group_by} checked="checked"{/if} />
        </label>
        {/foreach}
        <input type="submit" />
      </form>

      {if $data}
      <section id="chart"></section>

      <section id="data">

        <table>
          <thead>
            <tr>
              {foreach item=header from=$group_by}
              <th>{$header|escape}</th>
              {/foreach}
              <th>Count</th>
            </tr>
          </thead>

          <tbody>
            {foreach item=row from=$data}
            <tr>
              {foreach item=cell from=$row}
              <td>{$cell|escape}</td>
              {/foreach}
            </tr>
            {/foreach}
          </tbody>
          
        </table>
      </section>

      {else}
      <p>(No matching data)</p>
      {/if}

      <script src="/scripts/d3.min.js"></script>
      <script>
var url = '{$import|import_link}/analysis.csv?{$queryString|escape}';
var code = '{$group_by[0]}';
          {literal}
var width = 300,
    height = 300,
    radius = Math.min(width, height) / 2;

var color = d3.scale.ordinal()
    .range(["red", "orange", "yellow", "green", "blue", "magenta"]);

var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.count; });

var svg = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

d3.csv(url, function(error, data) {

  data.forEach(function(d) {
    d.count = +d.count;
  });

  var g = svg.selectAll(".arc")
      .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data[code]); });

  g.append("text")
      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.data[code]; });

});
          {/literal}
      </script>
    </main>
  </body>
</html>