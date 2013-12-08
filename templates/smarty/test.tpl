{extends file="parent.tpl"}

{block name="title"}{$engine} | {$smarty.block.parent}{/block}

{block name="content"}
    {$content}
    {$xssContent}

    <hr />

    <script type="text/javascript">
        var userId = {$userId};
    </script>
    <p style="color: {$color};" title="{$attrib}">
        <a href="" onclick="return !confirm({$message});">{$desc}</a>
    </p>
    <!-- Executed in: {$time} s -->
{/block}