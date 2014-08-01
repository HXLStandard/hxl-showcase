<!DOCTYPE html>

<html>
  <head>
    <title>#HXL showcase</title>
    <link rel="stylesheet" href="/style/default.css" />
  </head>
  <body>
{include file="fragments/header.tpl"}
    <main>

      <section id="intro">
        <h2>Introduction</h2>

        <p>Welcome to the technology showcase and test bed for the the
        <a href="http://docs.hdx.rwlabs.org/hxl">Humanitarian Exchange
        Language</a> (HXL) standard.</p>

        <p>HXL is a simple standard designed to improve data exchange
        and analysis during a humanitarian crisis, by defining a
        standard set of <a href="/tag">hashtags</a> that data creators
        can add to the columns of their spreadsheets: for example, the
        HXL tag <a href="/tag/sector"><code>#sector</code></a> at the
        top of a spreadsheet column (immediately under the header)
        means that the column refers to a humanitarian sector or
        cluster, such as <i>Education</i>.</p>

        <p>The datasets featured in this showcase are all samples of
        real humanitarian data from the field. The only changes made
        to the original datasets was the addition of a row of HXL tags
        before import. The showcase demonstrates how those simple tags
        alone make it possible to search, filter, and analyse the data
        in a much-more advanced way, and to produce visualisations
        like charts, without having any special advanced knowledge of
        the datasets.</p>

      </section>

      <section id="uploads">
        <h2>Latest uploads</h2>
        <table>
          <thead>
            <tr>
              <th>Dataset</th>
              <th>Source</th>
              <th>Imported by</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            {foreach item=upload from=$uploads}
            <tr>
              <td><a href="{$upload|dataset_link}">{$upload->dataset_name|escape}</a></td>
              <td><a href="{$upload|source_link}">{$upload->source_name|escape}</a></td>
              <td><a href="{$upload|user_link}">{$upload->usr_name|escape}</a></td>
              <td><a href="{$upload|import_link}">{$upload->stamp|timeAgo}</a></td>
            </tr>
            {/foreach}
          </tbody>
        </table>
      </section>

    </main>
  </body>
</html>
