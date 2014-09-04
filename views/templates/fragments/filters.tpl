<ul class="filters">
          {foreach $filters as $tagname => $tagvalue}
          <li class="active">
            <a class="toggle" href="{$filters|params:tag:$tag->tag:$tagname:null}">-</a>
            <span class="tag">{$tagname|escape}</span> : <span class="value">{$tagvalue|escape}</span>
          </li>
          {/foreach}
          {foreach $filter_tags as $filter_tag}
          {$url = "stats/filter/`$filter_tag|escape:'url'``$filters|params:'tag':$tag->tag`"}
          <li>
            <a class="toggle" href="{$url|escape}" onclick="window.open('{$url|escape}', 'Filter', 'height=600, width=400').focus(); return false;">+</a>
            <span class="tag">{$filter_tag|escape}</span>
          </li>
          {/foreach}
        </ul>
