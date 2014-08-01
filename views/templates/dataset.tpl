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
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
    </nav>

    <main>
      <h1>{$import->dataset_name|escape}</h1>

      <p>This page shows the latest version of the dataset
      <cite>{$import->dataset_name|escape}</cite> dataset from the
      source <a
      href="{$import|source_link}">{$import->source_name}</a>. In
      addition to browsing the data, you can select one of the options
      from the navigation bar below:</p>

      <dl>
        <dt>Analyse</dt>
        <dd>Generate an analysis of the dataset, including charts, and
        filter or drill down by varioius facets (including geography
        and sector).</dd>
        <dt>History</dt>
        <dd>Browse, analyse, or download previous versions of this
        dataset, if available.</dd>
        <dt>Download HXL</dt>
        <dd>Download a HXL version of this dataset.</dd>
      </dl>

      <nav class="options col3">
        <li><a href="{$import|dataset_link}/analysis">Analyse</a></li>
        <li><a href="{$import|dataset_link}/history">History</a></li>
        <li><a href="{$import|dataset_link}.csv">Download HXL</a></li>
      </nav>
      
      <table>
        <caption>Uploaded by <a href="{$import|user_link}">{$import->usr_name|escape}</a> on {$import->stamp|escape}</caption>
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


    </main>
  </body>
</html>