<!DOCTYPE html>

<html>
  <head>
    <title>Data sources</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Data sources</h1>

      <ul>
        {foreach item=source from=$sources}
        <li><a href="/data/{$source->ident|escape:'url'}">{$source->name|escape}</a></li>
        {/foreach}      
      </ul>
    </main>
  </body>
</html>