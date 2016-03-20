<html xmlns="http://WWW.W3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><!--{webname}--></title>
</head>
    <body>
    {include file="test.php"}
    {#}我是注释{#}
    {$content}
    {$name}
    {if $a}
    2333333
    {else}
    244444
    {/if}
    <br/>
    {foreach $array($var,$value)}
        {@var}..{@value}<br/>
    {/foreach}
    </body>
</html>
