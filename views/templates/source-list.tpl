<!DOCTYPE html>

<html>
  <head>
    <title>Data providers</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Data providers</h1>

      <table>
        <caption>Select a provider to see its datasets</caption>
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