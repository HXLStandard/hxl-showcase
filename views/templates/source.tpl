<!DOCTYPE html>

<html>
  <head>
    <title>{$source->source_name|escape}</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
    </nav>

    <main>
      <h1>{$source->source_name|escape}</h1>

      <form method="GET" action="/search">
        <input type="hidden" name="source" value="{$source->ident|escape}" />
        <label>
          <span>Search within {$source->name|escape}</span>
          <input name="q" placeholder="Search text" />
        </label>
        <input type="submit" />
      </form>

      <section id="datasets">
        <h2>Datasets from {$source->source_name|escape}</h2>

        <p>The HXL showcase contains the following dataset(s) from
        {$source->source_name|escape}. Please select a dataset to
        continue.</p>

        <table>
          <thead>
            <tr>
              <th>Dataset</th>
              <th>Uploader</th>
              <th>Latest update</th>
            </tr>
          </thead>
          <tbody>
          {foreach item=upload from=$uploads}
          <tr>
            <td><a href="{$upload|dataset_link}">{$upload->dataset_name|escape}</a></td>
            <td><a href="{$upload|user_link}">{$upload->usr_name|escape}</a></td>
            <td><a href="{$upload|import_link}">{$upload->stamp|timeAgo}</a></td>
          </tr>
          {/foreach}      
          </tbody>
        </table>

      </section>
    </main>
  </body>
</html>