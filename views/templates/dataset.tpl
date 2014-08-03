<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html>

<html>
  <head>
    <title>{$import->dataset_name|escape}</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Datasets</a></li>
    </nav>

    <main>
      <h1>{$import->dataset_name|escape}</h1>

      <dl>
        <dt>Source</dt>
        <dd><a href="{$import->source_name}">{$import->source_name|escape}</a></dd>
        <dt>Latest upload</dt>
        <dd>{$import->stamp|timeAgo} by <a href="{$import|user_link}">{$import->usr_name|escape}</a> (<a href="{$import|dataset_link}/history">history</a>)</dd>
        <dt>Rows</dt>
        <dd>{$row_count|number_format} (<a href="{$import|dataset_link}/data">view data</a>)</dd>
      </dl>

      <section id="analyse">
        <h2>Analyse</h2>

        <p>Begin your analysis by selecting one of the HXL tags that appears in the dataset:</p>

        <ul>
          {foreach $cols as $col}
          <li><a href="{$import|dataset_link}/stats?tag={$col->tag|escape:'url'}">#{$col->tag|escape}</a> ({$col->tag_name|escape})</li>
          {/foreach}
        </ul>

      </section>

    </main>
  </body>
</html>