<!DOCTYPE html>

<html>
  <head>
    <title>Data sources</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Data sources</h1>

      <table>
        <thead>
          <th>Data source</th>
          <th>Datasets available</th>
        </thead>
        <tbody>
          {foreach item=source from=$sources}
          <tr>
            <td><a href="/data/{$source->ident|escape:'url'}">{$source->name|escape}</a></td>
            <td>{$source->dataset_count|escape}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>
    </main>
  </body>
</html>