<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html>

<html>
  <head>
    <title>Upload history: {$dataset->dataset_name|escape}</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$dataset|source_link}">{$dataset->source_name|escape}</a></li>
      <li><a href="{$dataset|dataset_link}">{$dataset->dataset_name|escape}</a></li>
    </nav>

    <main>
      <h1>Upload history: {$dataset->dataset_name|escape}</h1>

      <table>
        <thead>
          <tr>
            <th>Date uploaded</th>
            <th>Uploaded by</th>
            <th>Data rows</th>
          </tr>
        </thead>
        <tbody>
          {foreach item=import from=$imports}
          <tr>
            <td><a href="{$import|import_link}">{$import->stamp|timeAgo}</a></td>
            <td><a href="{$import|user_link}">{$import->usr_name|escape}</a></td>
            <td>{$import->row_count|escape}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>

    </main>
  </body>
</html>