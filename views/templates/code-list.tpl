<!DOCTYPE html>

<html>
  <head>
    <title>HXL codes</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>HXL codes</h1>

      <table>
        <caption>Select a code to see the datasets where it appears</caption>
        <thead>
          <tr>
            <th>HXL code</th>
            <th>Description</th>
            <th>Data type</th>
            <th>Number of datasets</th>
          </tr>
        </thead>
        <tbody>
          {foreach item=code from=$codes}
          <tr>
            <td><a href="{$code|code_link}">{$code->code|escape}</a></td>
            <td>{$code->name|escape}</td>
            <td>{$code->datatype_name|escape}</td>
            <td>{$code->col_count|number_format}</td>
          </tr>
        {/foreach}
        </tbody>
      </table>
    </main>
  </body>
</html>