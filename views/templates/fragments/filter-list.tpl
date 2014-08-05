        <ul id="filter-list">
          {foreach $filters as $tagname=>$tagvalue}
          <li>#{$tagname|escape}: {$tagvalue|escape} [<a href="{$filters|params:tag:$tag->tag:$tagname:null}">x</a>]</li>
          {/foreach}
        </ul>
