<!DOCTYPE html>

<html>
  <head>
    <title>#HXL showcase</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <main>
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
