<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html>

<html>
  <head>
    <title>{$import->dataset_name|escape}</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="/data/{$import->source_ident|escape:'url'}">{$import->source_name|escape}</a></li>
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
            <td><a href="/data/{$import->source_ident|escape:'url'}/{$import->dataset_ident|escape:'url'}/{$import->stamp|escape:'url'}">{$import->stamp|escape}</a></td>
            <td><a href="/user/{$import->usr_ident|escape:'url'}">{$import->usr_name|escape}</a></td>
            <td>{$import->row_count|escape}</td>
            </tr>
            {/foreach}      
          </tbody>
        </table>

      </section>

      <section id="data">
        <h2>Latest version</h2>

        <table>
          <caption>Uploaded by <a href="/user/{$import->usr_ident|escape:'url'}">{$import->usr_name|escape}</a> on {$import->stamp|escape}</caption>
          <thead>
            <tr class="codes">
              {foreach item=col from=$cols}
              <th><a href="/code/{$col->code_code|escape:'url'}">{$col->code_name|escape}</a></th>
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