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
      (<a href="?">show all</a>)
      </p>
      {/if}

      <p>Total activit{$total|plural:'y':'ies'}: {$total|number_format}</p>

      {if $country_count > 0}
      <section id="countries">
        <h2>Top countries</h2>
        <p>Total countries: {$country_count|number_format}</p>
        <ol>
          {foreach item=country from=$countries}
          <li><a href="{$filters|params:'country':$country->country}">{$country->country|escape}</a> ({$country->count|number_format} activit{$country->count|plural:'y':'ies'})</li>
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
          <li><a href="{$filters|params:'adm1':$adm1->adm1}">{$adm1->adm1|escape}</a> ({$adm1->count|number_format} activit{$adm1->count|plural:'y':'ies'})</li>
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
          <li><a href="{$filters|params:'sector':$sector->sector}">{$sector->sector|escape}</a> ({$sector->count|number_format} activit{$sector->count|plural:'y':'ies'})</li>
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
          <li><a href="{$filters|params:'org':$org->org}">{$org->org|escape}</a> ({$org->count|number_format} activit{$org->count|plural:'y':'ies'})</li>
          {/foreach}
        </ol>
      </section>
      {/if}

    </main>

  </body>
</html>