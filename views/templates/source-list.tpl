<!DOCTYPE html>

<html>
  <head>
    <title>Data providers</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Data providers</h1>

      <p>Data from the following providers is available in the HXL
      showcase. Please select a provider or a dataset to see more
      information.</p>

      <table>
        <thead>
          <th>Provider</th>
          <th>Datasets available</th>
          <th>Total uploads</th>
          <th>Latest upload</th>
        </thead>
        <tbody>
          {foreach item=import from=$imports}
          <tr>
            <td><a href="{$import|source_link}">{$import->source_name|escape}</a></td>
            <td>{$import->dataset_count|escape}</td>
            <td>{$import->import_count|escape}</td>
            <td>{$import->stamp|timeAgo}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>
    </main>
  </body>
</html>