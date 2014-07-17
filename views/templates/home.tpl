<!DOCTYPE html>

<html>
  <head>
    <title>Blue Monster demo</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <main>
      <nav class="options">
        <li><a href="/data">Data</a></li>
        <li><a href="/code">HXL codes</a></li>
        <li><a href="/code">Uploaders</a></li>
      </nav>

      <h1>Blue Monster demo</h1>

      <section id="uploads">
        <h2>Latest uploads</h2>
        <table>
          <thead>
            <tr>
              <th>Time</th>
              <th>Source</th>
              <th>Dataset</th>
              <th>Uploader</th>
              <th># rows</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=upload from=$uploads}
            <tr>
              <td><a href="{$upload|import_link}">{$upload->stamp|timeAgo}</a></td>
              <td><a href="{$upload|source_link}">{$upload->source_name|escape}</a></td>
              <td><a href="{$upload|dataset_link}">{$upload->dataset_name|escape}</a></td>
              <td><a href="{$upload|user_link}">{$upload->usr_name|escape}</a></td>
              <td>{$upload->row_count|number_format}</td>
            </tr>
            {/foreach}
          </tbody>
        </table>
      </section>

    </main>
  </body>
</html>
