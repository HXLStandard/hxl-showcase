<!DOCTYPE html>

<html>
  <head>
    <title>Uploaders</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="http://hxlstandard.org">HXL home</a></li>
      <li><a href="/">Demo</a></li>
    </nav>

    <main>
      <h1>Uploaders</h1>

      <p>This page shows a list of the individual users who have
      uploaded datasets to the HXL showcase. You may select a user for
      more information about her/his activity.</p>

      <table>
        <thead>
          <th>User</th>
          <th>Full name</th>
          <th>Uploads</th>
        </thead>
        <tbody>
          {foreach item=user from=$users}
          <tr>
            <td><a href="{$user|user_link}">{$user->usr|escape}</a></td>
            <td>{$user->usr_name|escape}</td>
            <td>{$user->import_count|escape}</td>
          </tr>
          {/foreach}      
        </tbody>
      </table>
    </main>
  </body>
</html>