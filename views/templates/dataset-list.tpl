<!DOCTYPE html>

<html>
  <head>
    <title>Datasets</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Datasets</h1>

      <p>This page shows the datasets available in the showcase, with
      the most-recently-updated first. Select a dataset to see more
      information, including options for analysis and
      visualisation.</p>

      <table>
        <thead>
          <th>Dataset</th>
          <th>Source</th>
          <th>Uploader</th>
          <th>Last update</th>
        </thead>
        <tbody>
          {foreach $imports as $import}
          <tr>
            <td><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></td>
            <td><a href="{$import|source_link}">{$import->source_name|escape}</a></td>
            <td><a href="{$import|user_link}">{$import->usr_name|escape}</a></td>
            <td>{$import->stamp|timeAgo}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>
    </main>
  </body>
</html>