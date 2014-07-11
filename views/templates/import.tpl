<!DOCTYPE html>

<html>
  <head>
    <title>{$import->dataset_name|escape} ({$import->stamp|escape})</title>
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
      <h1>{$import->dataset_name|escape} ({$import->stamp|escape})</h1>

      <p class="download-link"><a href="{$import|import_link}.csv">Download CSV</a></p>

      <section id="data">

        <table>
          <caption>Imported by <a href="{$import|user_link}">{$import->usr_name|escape}</a> on {$import->stamp|escape}</caption>
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