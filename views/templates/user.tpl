<!DOCTYPE html>

<html>
  <head>
    <title>{$user->name|escape} ({$user->ident|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/user">Uploaders</a></li>
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
              <th>Dataset</th>
              <th>Data source</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=import from=$imports}
            <tr>
              <td><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></td>
              <td><a href="{$import|source_link}">{$import->source_name|escape}</a></td>
              <td><a href="{$import|import_link}">{$import->stamp|timeAgo}</a></td>
            </tr>
            {/foreach}
          </tbody>
        </table>

      </section>
    </main>
  </body>
</html>