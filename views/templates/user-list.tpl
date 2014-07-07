<!DOCTYPE html>

<html>
  <head>
    <title>Users</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>

    <main>
      <h1>Users</h1>

      <table>
        <thead>
          <th>User</th>
          <th>Full name</th>
          <th>Uploads</th>
        </thead>
        <tbody>
          {foreach item=user from=$users}
          <tr>
            <td><a href="/user/{$user->ident|escape:'url'}">{$user->ident|escape}</a></td>
            <td>{$user->name|escape}</td>
            <td>{$user->import_count|escape}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>
    </main>
  </body>
</html>