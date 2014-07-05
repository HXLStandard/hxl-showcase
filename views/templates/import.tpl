<!DOCTYPE html>

<html>
  <head>
    <title>{$import->dataset_name|escape} ({$import->stamp|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data sources</a></li>
      <li><a href="/data/{$import->source_ident|escape:'url'}">{$import->source_name|escape}</a></li>
      <li><a href="/data/{$import->source_ident|escape:'url'}/{$import->dataset_ident|escape:'url'}">{$import->dataset_name|escape}</a></li>
    </nav>

    <main>
      <h1>{$import->dataset_name|escape} ({$import->stamp|escape})</h1>

      <p>Imported by <a href="/user/{$import->usr_ident|escape:'url'}">{$import->usr_name|escape}</a> on {$import->stamp|escape}.</p>

      <section id="data">
        <h2>Data</h2>

        <table>
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