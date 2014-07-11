<!DOCTYPE html>

<html>
  <head>
    <title>Uploaders</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Uploaders</h1>

      <table>
        <thead>
          <th>User</th>
          <th>Full name</th>
          <th>Uploads</th>
        </thead>
        <tbody>
          {foreach item=user from=$users}
          <tr>
            <td><a href="{$user|user_link}">{$user->ident|escape}</a></td>
            <td>{$user->name|escape}</td>
            <td>{$user->import_count|escape}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>
    </main>
  </body>
</html>