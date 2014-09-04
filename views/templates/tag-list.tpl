<!DOCTYPE html>

<html>
  <head>
    <title>HXL tags</title>
{include file="fragments/metadata.tpl"}
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="http://hxlstandard.org">HXL home</a></li>
      <li><a href="/">Demo</a></li>
    </nav>

    <main>
      <h1>HXL tags</h1>

      <p>This page lists all of the HXL tags currently available in
      the showcase, along with the number of datasets that currently
      use each tag. Note that this is not (currently) the official
      definition of the HXL tags. Please see the <cite><a
      href="https://docs.google.com/spreadsheets/d/1aq2ojDnceIcTNdLWVKP856AuFPItJP1TWwMaPrKPXXw/edit?usp=sharing">HXL
      tag dictionary</a></cite> for the latest list, including
      more-detailed documentation.</p>

      <table>
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
            <td><a href="{$tag|tag_link}"><code>#{$tag->tag|escape}</code></a></td>
            <td>{$tag->tag_name|escape}</td>
            <td>{$tag->datatype_name|escape}</td>
            <td>{$tag->col_count|number_format}</td>
          </tr>
        {/foreach}
        </tbody>
      </table>
    </main>
  </body>
</html>