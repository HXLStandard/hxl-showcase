<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html>

<html>
  {if $params->import}
  {$baseurl=$import|import_link}
  {else}
  {$baseurl=$import|dataset_link}
  {/if}
  <head>
    <title>{$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</title>
    {include file="fragments/metadata.tpl"}
  </head>
  <body class="twocol">
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="http://hxlstandard.org">HXL home</a></li>
      <li><a href="/">Demo</a></li>
      <li><a href="/source">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      {if $params->import}
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      {/if}
    </nav>

    <main>

      <h1>{$import->dataset_name|escape}{if $params->import} ({$import->stamp|escape}){/if}</h1>

      {if $filters}
      <section id="filters">
        {include file="fragments/filter-list.tpl"}
      </section>
      {/if}

      <dl>
        <dt>Source</dt>
        <dd><a href="{$import|source_link}">{$import->source_name|escape}</a></dd>
        <dt>Latest upload</dt>
        <dd>{$import->stamp|timeAgo} by <a href="{$import|user_link}">{$import->usr_name|escape}</a></dd>
        <dt>Rows</dt>
        {if $filters}
        <dd>{$filtered_row_count|number_format} of {$row_count|number_format} (<a href="{$baseurl}/data{$filters|params}">view data</a>)</dd>
        {else}
        <dd>{$row_count|number_format} (<a href="{$baseurl}/data">view data</a>)</dd>
        {/if}
      </dl>

      <section id="history">
        <h2>Upload history</h2>
        <table>
          <thead>
            <tr>
              <th>Date uploaded</th>
              <th>Uploaded by</th>
              <th>Data rows</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=import from=$imports}
            <tr>
              <td><a href="{$import|import_link}">{$import->stamp|timeAgo}</a></td>
              <td><a href="{$import|user_link}">{$import->usr_name|escape}</a></td>
              <td>{$import->row_count|number_format}</td>
            </tr>
            {/foreach}      
          </tbody>
        </table>
      </section>

    </main>


    <aside>

      <p><a href="{$baseurl}/data{$filters|params}">Browse data</a></p>

      <section>
        <h2>Explore</h2>      
        <p>Select one of these HXL hashtags to start visualising and analysing the dataset.</p>
        <dl>
          {foreach $cols as $col}
          <dt><a href="{$baseurl}/stats{$filters|params:'tag':$col->tag}">#{$col->tag|escape}</a></dt>
          <dd>{$col->tag_name|escape}</dd>
          {/foreach}
        </dl>
      </section>

      <section id="links">
        <h2>Downloads</h2>
        <p>These downloads include the full dataset.</p>
        <ul class="links">
          <li><a href="{$baseurl}/data.csv{$filters|params}">CSV</a></li>
          <li><a href="{$baseurl}/data.json{$filters|params}">JSON</a></li>
          <li><a href="{$baseurl}/data.xml{$filters|params}">XML</a></li>
          <li><a href="{$baseurl}/data.n3{$filters|params}">RDF (N3)</a></li>
        </ul>
      </section>

    </aside>

  </body>
</html>