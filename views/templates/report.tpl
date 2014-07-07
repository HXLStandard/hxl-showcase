<!DOCTYPE html>

<html>
  <head>
    <title>Report</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Report</h1>

      <table>
        <thead>
          <tr>
            {foreach item=code from=$codes}
            <th>{$code->code|escape}</th>
            {/foreach}
          </tr>
          <tr>
            {foreach item=code from=$codes}
            <th>{$code->name|escape}</th>
            {/foreach}
          </tr>
        </thead>
        <tbody>
          {assign var=last_row value=-1}
          <tr>
          {foreach item=value from=$values}
          {if ($last_row > 0) and ($last_row != $value->row)}
          </tr>
          <tr>
          {/if}
          <td>{$value->row|escape} {$value->value|escape}</td>
          {assign var=last_row value=$value->row}
          {/foreach}
          </tr>
        </tbody>
      </table>

    </main>
  </body>
</html>