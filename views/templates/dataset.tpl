<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html>

<html>
  <head>
    <title>{$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Datasets</a></li>
      {if $params->import}
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {/if}
    </nav>

    <main>
      <h1>{$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</h1>

      {if $params->import}
      <p><b>Showing version imported on {$import->stamp|escape} by {$import->usr_name}.</b></p>
      {$baseurl=$import|import_link}
      {else}
      {$baseurl=$import|dataset_link}
      {/if}

      <dl>
        <dt>Source</dt>
        <dd><a href="{$import|source_link}">{$import->source_name|escape}</a></dd>
        <dt>Latest upload</dt>
        <dd>{$import->stamp|timeAgo} by <a href="{$import|user_link}">{$import->usr_name|escape}</a> (<a href="{$import|dataset_link}/history">history</a>)</dd>
        <dt>Rows</dt>
        <dd>{$row_count|number_format} (<a href="{$baseurl}/data">view data</a>)</dd>
      </dl>

      <section id="analyse">
        <h2>Analyse</h2>

        <p>Begin your analysis by selecting one of the HXL tags that appears in the dataset:</p>

        <ul>
          {foreach $cols as $col}
          <li><a href="{$baseurl}/stats?tag={$col->tag|escape:'url'}">#{$col->tag|escape}</a> ({$col->tag_name|escape})</li>
          {/foreach}
        </ul>

      </section>

    </main>
  </body>
</html>