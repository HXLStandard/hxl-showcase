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
      <h1>Exploring <span class="tag">{$tag->tag|escape}</span> in {$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</h1>

      <section id="chart">
        <div id="chart_div"></div>
      </section>

      <section id="summary">
        <h2>Summary</h2>
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

      {if $tag->datatype=='Number'}
      <section id="analysis">
        <h2>Analysis</h2>

        <p>Because the <a
        href="{$tag|tag_link}">#{$tag->tag|escape}</a> refers to
        numeric data, this section shows some different
        <i>aggregate</i> functions applied to the numbers matching any
        <a href="#filters">filters</a> you've set above. Not all of
        these aggregates will make sense for every hashtag, but they
        can help you analyse your data (e.g. how consistent is the
        data? what are the highest and lowest numbers?).</p>

        <table>
          <tbody>
            <tr>
              <th>Sample size</th>
              <td>{$aggregates->count|number_format}</td>
              <td>
                {if $aggregates->count < 10}
                (This is a pretty small sample, so be careful about drawing too many conclusions from the data below.)
                {elseif $aggregates->count < 100}
                (This is a reasonable-sized sample, but you should still use it with care.)
                {else}
                (This is a fairly-large sample. Depending on how well it's been collected, the values can be meaningful.)
                {/if}
              </td>
            </tr>
            <tr>
              <th>Sum of values</th>
              <td>{$aggregates->sum|number_format}</td>
              <td>(All matching numbers added up.)</td>
            </tr>
            <tr>
              <th>Minimum value</th>
              <td>{$aggregates->min|number_format}</td>
              <td></td>
            </tr>
            <tr>
              <th>Maximum value</th>
              <td>{$aggregates->max|number_format}</td>
              <td> </td>
            </tr>
            <tr>
              <th>Average (mean)</th>
              <td>{$aggregates->avg|number_format}</td>
              <td> </td>
            </tr>
            <tr>
              <th>Standard deviation (population)</th>
              <td>{$aggregates->stddev_pop|number_format:2}</td>
              <td> </td>
            </tr>
            <tr>
              <th>Coefficient of variation</th>
              <td>{$aggregates->coeff_var|number_format:2}</td>
              <td>
                {if $aggregates->coeff_var < 0.25}
                (The values are mostly close to the mean.)
                {elseif $aggregates->coeff_var < 0.50}
                (The values vary, but still tend to the mean.)
                {elseif $aggregates->coeff_var < 0.75}
                (The values vary considerably across a wide range.)
                {else}
                (There is little or no consistency.)
                {/if}
              </td>
            </tr>
          </tbody>
        </table>
      </section>
      {/if}

    </main>


    <aside>

      <p><a href="{$baseurl}/data{$filters|params}">Browse data</a></p>

      <section>
        <h2>Filters</h2>
        {include file="fragments/filters.tpl" type="stats"}
      </section>

      <section id="links">
        <h2>Downloads</h2>
        <p>These downloads include only the <b>filtered</b> data.</p>
        <ul class="links">
          <li><a href="{$baseurl}/data.csv{$filters|params}">CSV</a></li>
          <li><a href="{$baseurl}/data.json{$filters|params}">JSON</a></li>
          <li><a href="{$baseurl}/data.xml{$filters|params}">XML</a></li>
          <li><a href="{$baseurl}/data.n3{$filters|params}">RDF (N3)</a></li>
        </ul>
      </section>
    </aside>

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
