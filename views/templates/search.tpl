<!DOCTYPE html>

<html>
  <head>
    <title>Search</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
    </nav>
    <main>
      <h1>Search</h1>

      <form method="GET" action="/search">
        <label>
          <span>Search for</span>
          <input name="q" placeholder="Search text" value="{$q|escape}" />
        </label>
        <label>
          <span>HXL tag</span>
          <select name="tag">
            <option value="">(all)</option>
            {foreach item=tag from=$tags}
            <option value="{$tag->tag|escape}"{if $tag->tag == $tag_tag} selected="selected"{/if}>#{$tag->tag|escape} &mdash; {$tag->name|escape}</option>
            {/foreach}
          </select>
        </label>
        <label>
          <span>Data source</span>
          <select name="source">
            <option value="">(all)</option>
            {foreach item=source from=$sources}
            <option value="{$source->ident|escape}"{if $source->ident == $source_ident} selected="selected"{/if}>{$source->ident|escape} &mdash; {$source->name|escape}</option>
            {/foreach}
          </select>
        </label>
        <label>
          <span>Uploader</span>
          <select name="user">
            <option value="">(all)</option>
            {foreach item=user from=$users}
            <option value="{$user->ident|escape}"{if $user->ident == $user_ident} selected="selected"{/if}>{$user->ident|escape} &mdash; {$user->name|escape}</option>
            {/foreach}
          </select>
        </label>
        <input type="submit" />
      </form>

      {if $q}
      <section id="results">
        {if $result_count > 0}

        <table>
          <caption>{$result_count|escape} match(es) found</caption>
          <thead>
            <tr>
              <th>Dataset</th>
              <th>Provider</th>
              <th>HXL tag</th>
              <th>Value</th>
              <th>Matching rows</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=value from=$values}
            <tr>
              <td><a href="{$value|dataset_link}/analysis?{$value->tag_tag|escape:'url'}={$value->value|escape:'url'}">{$value->dataset_name|escape}</a></td>
              <td><a href="{$value|source_link}">{$value->source_name|escape}</a></td>
              <td><a href="{$value|tag_link}"><code>#{$value->tag_tag|escape}</code></a> &mdash; {$value->tag_name|escape}</td>
              <td>{$value->value|escape}</td>
              <td>{$value->row_count|number_format}</td>
            </tr>
            {/foreach}
          </tbody>
        </table>
        {else}
        <p>No matching data.</p>
        {/if}
      </section>
      {else}
      <p>(Enter some search text to continue.)</p>
      {/if}
    </main>
  </body>
</html>