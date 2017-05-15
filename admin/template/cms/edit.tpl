{extends file="layout.tpl"}
{block name='body:id'}module-pages{/block}
{block name="article:content"}
{include file="cms/section/nav.tpl"}
<div class="row">
    <span class="col-sm-10">
    <h1>{#editing_the_page#|ucfirst} : {$title_page}</h1>
    </span>
    <span class="col-sm-2">
        <a class="btn btn-primary btn-large post-preview" href="#">
            <span class="fa fa-search-plus"></span>
        </a>
    </span>
</div>
{if $access.edit eq 1}
    <ul class="nav nav-tabs clearfix">
        <li{if !$smarty.get.tab && !$smarty.get.plugin} class="active"{/if}>
            <a href="/admin/cms.php?getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}">{#text#|ucfirst}</a>
        </li>
        {if $plugin != null}
            {foreach $plugin as $key}
                <li{if $smarty.get.plugin eq $key.url} class="active"{/if}>
                    <a href="/admin/cms.php?getlang={$smarty.get.getlang}&amp;action=edit&amp;edit={$smarty.get.edit}&amp;plugin={$key.url}">{$key.name|ucfirst}</a>
                </li>
            {/foreach}
        {/if}
    </ul>
    {include file="cms/forms/edit.tpl"}
    <div class="mc-message clearfix"></div>
{else}
<div class="mc-message clearfix">
    <div class="alert alert-danger">
        <span class="fa fa-warning"></span> {#request_access_denied#}
    </div>
</div>
{/if}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="cms/section/js.tpl"}
{/block}