<!DOCTYPE html>

<html>
  <head>
    <title>Search</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
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
          <span>HXL code</span>
          <select name="code">
            <option value="">(all)</option>
            {foreach item=code from=$codes}
            <option value="{$code->code|escape}"{if $code->code == $code_code} selected="selected"{/if}>{$code->code|escape} &mdash; {$code->name|escape}</option>
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
        <h2>Search results</h2>

        {if $result_count > 0}
        <p>{$result_count|escape} matching values:</p>

        <table>
          <thead>
            <tr>
              <th>Dataset</th>
              <th>Source</th>
              <th>HXL code</th>
              <th>Value</th>
              <th>Matching rows</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=value from=$values}
            <tr>
              <td><a href="/data/{$value->source_ident|escape:'url'}/{$value->dataset_ident|escape:'url'}">{$value->dataset_name|escape}</a></td>
              <td><a href="/data/{$value->source_ident|escape:'url'}">{$value->source_name|escape}</a></td>
              <td><a href="/code/{$value->code_code|escape:'url'}">{$value->code_name|escape}</a></td>
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