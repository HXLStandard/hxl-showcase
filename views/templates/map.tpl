<!DOCTYPE html>

<html>
  <head>
    <title>#{$tag->tag|escape} in {$import->dataset_name|escape}</title>
    {include file="fragments/metadata.tpl"}
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
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
          <li><a href="{$baseurl}/map.csv{$filters|params:'tag':$params->tag}">CSV</a> (spreadsheet)</li>
          <li><a href="{$baseurl}/map.json{$filters|params:'tag':$params->tag}">JSON</a></li>
          <li><a href="{$baseurl}/map.xml{$filters|params:'tag':$params->tag}">XML</a></li>
          <li><a href="{$baseurl}/map.n3{$filters|params:'tag':$params->tag}">RDF (N3)</a></li>
        </ul>
      </section>
    </aside>

    <script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js'></script>
    <script type="text/javascript" src="/scripts/map.js"></script>
    <script type="text/javascript">
      initmap();
      var url = '{$baseurl}/map.json{$filters|params:'tag':$params->tag}';
{literal}
      $.getJSON(url, function (locations) {
        var bounds = null;
        $.each(locations, function(i, location) {
          var point = [location[0], location[1]];
          if (bounds == null) {
            bounds = L.latLngBounds(point, point);
          } else {
            bounds.extend(point);
          }
          var marker = L.marker(point).addTo(map);
        });
        map.fitBounds(bounds);
      });
{/literal}
    </script>
  </body>
</html>
