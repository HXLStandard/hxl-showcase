<!DOCTYPE html>

<html>
  <head>
    <title>#{$tag->tag|escape} in {$import->dataset_name|escape}</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
    </nav>

    <main>
      <h1>#{$tag->tag|escape} in {$import->dataset_name|escape}</h1>

      <nav class="options col2">
        <li><a href="stats.csv?tag={$tag->tag|escape:'url'}">Download as CSV</a></li>
        <li><a href="stats.json?tag={$tag->tag|escape:'url'}">Download as JSON</a></li>
      </nav>

      <section id="data">
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
  </body>
</html>