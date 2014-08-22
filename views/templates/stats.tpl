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
        <h2>Data filters</h2>
        
        <p>In this section, you can set filters to analyse just <i>part</i> of the dataset, instead of the whole thing.</p>

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

      {if $tag->datatype=='Number'}
      {$chartname='Histogram'}
      <section id="aggregates">
        <h2>Aggregates</h2>

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

(If this number is small, you should be careful about trusting some of the other aggregates below.)</td>
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
              <th>Coefficient of variance</th>
              <td>{$aggregates->coeff_var|number_format:2}</td>
              <td>
                {if $aggregates->coeff_var < 0.25}
                (The values are fairly consistent close to the mean.)
                {elseif $aggregates->coeff_var < 0.50}
                (The values vary somewhat, but there is still a cluster closer to the mean.)
                {elseif $aggregates->coeff_var < 0.75}
                (The values vary considerably across a wide range.)
                {else}
                (The values vary extremely, and have little or no consistency.)
                {/if}
              </td>
            </tr>
          </tbody>
        </table>
      </section>
      {else}
      {$chartname='Chart'}
      {/if}

      <section id="chart">
        <h2>{$chartname|escape}</h2>

        {if $chartname == 'Histogram'}
        <p>This is a chart of the distribution of values in different
        ranges for <a href="{$tag|tag_link}">#{$tag->tag|escape}</a> in this dataset, based on any <a href="#filters">filters</a> you've set above.</p>
        {/if}

        <div id="chart_div"></div>

        <section id="data">
          <h3>{$chartname|escape} data</h3>

          <p>This is the data used to generate the {$chartname|escape}.  You can download it for your own analysis, or look at the complete (unaggregated) data matching the <a href="#filters">filters</a> you've set above.</p>

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