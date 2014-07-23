<!DOCTYPE html>

<html>
  <head>
    <title>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
    {include file="fragments/header.tpl"}
    <nav class="breadcrumbs">
      <li><a href="/">Home</a></li>
      <li><a href="/data">Data providers</a></li>
      <li><a href="{$import|source_link}">{$import->source_name|escape}</a></li>
      <li><a href="{$import|dataset_link}">{$import->dataset_name|escape}</a></li>
      <li><a href="{$import|import_link}">{$import->stamp|escape}</a></li>
    </nav>

    <main>
      <h1>3W analysis of {$import->dataset_name|escape} ({$import->stamp|escape})</h1>
      
      {if $filters}
      <p><strong>Showing:</strong>
      {if $filters.country}
      Country &ldquo;{$filters.country|escape}&rdquo;
      {/if}
      {if $filters.adm1}
      Admin level 1 &ldquo;{$filters.adm1|escape}&rdquo;
      {/if}
      {if $filters.sector}
      Sector &ldquo;{$filters.sector|escape}&rdquo;
      {/if}
      {if $filters.org}
      Organisation &ldquo;{$filters.org|escape}&rdquo;
      {/if}
      </p>
      {/if}

      <nav class="options col2">
        <li><a href="?">Show all</a></li>
        <li><a href="analysis.csv{$filters|params}">Download CSV</a></li>
      </nav>
      
      <p>{$total|number_format} matching activit{$total|plural:'y':'ies'}.</p>

      {if $country_count > 0}
      <section id="countries">
        <h2>Top countries</h2>
        <p>Total countries: {$country_count|number_format}</p>
        <ol>
          {foreach item=country from=$countries}
          <li><a href="analysis{$filters|params:'country':$country->value}">{$country->value|escape}</a> ({$country->count|number_format} activit{$country->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $adm1_count > 0}
      <section id="adm1">
        <h2>Top admin level 1 subdivisions</h2>
        <p>Total admin level 1 subdivisions: {$adm1_count|number_format}</p>
        <ol>
          {foreach item=adm1 from=$adm1s}
          <li><a href="{$filters|params:'adm1':$adm1->value}">{$adm1->value|escape}</a> ({$adm1->count|number_format} activit{$adm1->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $sector_count > 0}
      <section id="sectors">
        <h2>Top sectors</h2>
        <p>Total sectors: {$sector_count|number_format}</p>
        <ol>
          {foreach item=sector from=$sectors}
          <li><a href="{$filters|params:'sector':$sector->value}">{$sector->value|escape}</a> ({$sector->count|number_format} activit{$sector->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      {if $org_count > 0}
      <section id="orgs">
        <h2>Top organisations</h2>
        <p>Total organisations: {$org_count|number_format}</p>
        <ol>
          {foreach item=org from=$orgs}
          <li><a href="{$filters|params:'org':$org->value}">{$org->value|escape}</a> ({$org->count|number_format} activit{$org->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

      <section id="data">
        <h2>Data</h2>
        <table> 
          <thead>
            <tr class="codes">
              {foreach item=col from=$cols}
              <th><a href="{$col|code_link}">{$col->code_name|escape}</a></th>
              {/foreach}
            </tr>
          </thead>
          <tbody>
            <tr>
              {foreach item=value from=$values}
              {if $last_row and ($last_row != $value->row)}
            </tr>
            <tr>
              {/if}
              {assign var=last_row value=$value->row}
              <td>{$value->value|escape}</td>
              {/foreach}
            </tr>
          </tbody>
        </table>
      </section>

    </main>

  </body>
</html>