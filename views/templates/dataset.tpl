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
            <td><a href="{$import|import_link}">{$import->stamp|escape}</a></td>
            <td><a href="{$import|user_link}">{$import->usr_name|escape}</a></td>
            <td>{$import->row_count|escape}</td>
            </tr>
            {/foreach}      
          </tbody>
        </table>

      </section>

      <section id="data">
        <h2>Latest version</h2>

        <nav class="options">
          <li><a href="{$import|dataset_link}.csv">Download CSV</a></li>
          <li><a href="{$import|import_link}/analysis">Analyse</a></li>
        </nav>
      
        <table>
          <caption>Uploaded by <a href="{$import|user_link}">{$import->usr_name|escape}</a> on {$import->stamp|escape}</caption>
          <thead>
            <tr class="codes">
              {foreach item=col from=$cols}
              <th><a href="{$col|code_link}">{$col->code_name|escape}</a></th>
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
  </body>
</html>