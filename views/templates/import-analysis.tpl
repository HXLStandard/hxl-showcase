<!DOCTYPE html>

<html>
  <head>
    <title>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
    </nav>

    <main>
      <h1>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</h1>

      {if $data}
      <section id="chart"></section>

      <section id="data">

        <table>
          <thead>
            <tr>
              {foreach item=header from=$headers}
              <th>{$header|escape}</th>
              {/foreach}
            </tr>
          </thead>

          <tbody>
            {foreach item=row from=$data}
            <tr>
              {foreach item=cell from=$row}
              <td>{$cell|escape}</td>
              {/foreach}
            </tr>
            {/foreach}
          </tbody>
          
        </table>
      </section>

      {else}
      <p>(No matching data)</p>
      {/if}

    </main>

  </body>
</html>