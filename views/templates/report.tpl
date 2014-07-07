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
            {foreach item=col from=$cols}
            <th>{$col->code|escape}</th>
            {/foreach}
          </tr>
          <tr>
            {foreach item=col from=$cols}
            <th>{$col->name|escape}</th>
            {/foreach}
          </tr>
        </thead>
        <tbody>
          {$last_row = -1}
          {foreach item=value from=$values}
          {if $last_row != -1 and $last_row != $value->row}
          {report_row cols=$cols cells=$cells}
          {$cells = []}
          {/if}
          {append var=cells value=$value}
          {$last_row = $value->row}
          {/foreach}
          {report_row cols=$cols cells=$cells}
        </tbody>
      </table>

    </main>
  </body>
</html>