<!DOCTYPE html>

<html>
  <head>
    <title>{$user->name|escape} ({$user->ident|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data sources</a></li>
    </nav>

    <main>
      <h1>{$user->name|escape} ({$user->ident|escape})</h1>

      <form method="GET" action="/search">
        <input type="hidden" name="user" value="{$user->ident|escape}" />
        <label>
          <span>Search uploads by {$user->name|escape}</span>
          <input name="q" placeholder="Search text" />
        </label>
        <input type="submit" />
      </form>

      <section id="imports">
        <h2>Uploads by {$user->name|escape}</h2>

        <table>
          <thead>
            <tr>
              <th>Version</th>
              <th>Dataset</th>
              <th>Data source</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=import from=$imports}
            <tr>
              <td><a href="/data/{$import->source_ident|escape:'url'}/{$import->dataset_ident|escape:'url'}/{$import->stamp|escape:'url'}">{$import->stamp|escape}</a></td>
              <td><a href="/data/{$import->source_ident|escape:'url'}/{$import->dataset_ident|escape:'url'}">{$import->dataset_name|escape}</a></td>
              <td><a href="/data/{$import->source_ident|escape:'url'}">{$import->source_name|escape}</a></td>
            </tr>
            {/foreach}
          </tbody>
        </table>

        <ul>
          {foreach item=import from=$imports}
          <li><a href="/data/{$dataset->source_ident|escape:'url'}/{$dataset->ident|escape:'url'}/{$import->stamp|escape:'url'}">{$import->stamp|escape}</a></li>
          {/foreach}      
        </ul>

      </section>
    </main>
  </body>
</html>