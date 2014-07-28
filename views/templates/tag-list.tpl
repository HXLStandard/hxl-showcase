<!DOCTYPE html>

<html>
  <head>
    <title>HXL tags</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>HXL tags</h1>

      <table>
        <caption>Select a tag to see the datasets where it appears</caption>
        <thead>
          <tr>
            <th>HXL tag</th>
            <th>Description</th>
            <th>Data type</th>
            <th>Number of datasets</th>
          </tr>
        </thead>
        <tbody>
          {foreach item=tag from=$tags}
          <tr>
            <td><a href="{$tag|tag_link}">{$tag->tag|escape}</a></td>
            <td>{$tag->name|escape}</td>
            <td>{$tag->datatype_name|escape}</td>
            <td>{$tag->col_count|number_format}</td>
          </tr>
        {/foreach}
        </tbody>
      </table>
    </main>
  </body>
</html>