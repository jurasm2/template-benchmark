<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>{block name="title"}{$title}{/block}</title>
    </head>
    <body>
        <h1>{$engine|upper}</h1>
        {block name="content"}
           Default content
        {/block}
    </body>
</html>