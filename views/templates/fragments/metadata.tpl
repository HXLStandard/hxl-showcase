    <link rel="stylesheet" href="/style/default.css" />
    <meta name="viewport" content="width=device-width" />
{if $APP->config->ga_tracking_id}
    <script type="text/javascript">
      ga_tracking_id = {$APP->config->ga_tracking_id|json_encode};
    </script>
    <script type="text/javascript" src="/scripts/ga.js" async="async"></script>
{/if}
