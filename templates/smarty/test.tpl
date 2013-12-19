{extends file="parent.tpl"}

{block name="title"}{$engine} | {$smarty.block.parent}{/block}

{block name="content"}
    {$content}
    {$xssContent}

    <hr />

    <script type="text/javascript">
        var userId = '{$userId|escape:'javascript'}';
    </script>
    <p style="color: {$color};" title="{$attrib}">
        <a href="" onclick="return !confirm('{$message|escape:'javascript'}');">{$desc}</a>
    </p>
    <!-- Executed in: {$time} s -->
    
    <hr />
    <h2>Using plugins</h2>
    
    {$pluginText|changeText}
    
{/block}