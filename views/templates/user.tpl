<!DOCTYPE html>

<html>
  <head>
    <title>{$user->usr_name|escape} ({$user->usr|escape})</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="http://hxlstandard.org">HXL home</a></li>
      <li><a href="/">Demo</a></li>
      <li><a href="/user">Uploaders</a></li>
    </nav>

    <main>
      <h1>{$user->usr_name|escape} ({$user->usr|escape})</h1>

      <p>This page shows the upload activity for the user <a
      href="{$user|user_link}">{$user->usr_name|escape}</a>
      ({$user->usr|escape}). You can also search just within data that
      this user has uploaded.</p>

      <form method="GET" action="/search">
        <input type="hidden" name="user" value="{$user->usr|escape}" />
        <label>
          <span>Search uploads by {$user->usr_name|escape}</span>
          <input name="q" placeholder="Search text" />
        </label>
        <input type="submit" />
      </form>

      <section id="imports">
        <h2>Uploads by {$user->usr_name|escape}</h2>

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