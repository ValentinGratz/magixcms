{if isset($data.id)}
    {$data = [$data]}
{/if}
{if !$effect}
    {if is_array($data) && !empty($data)}
        <p class="lead">{#last_products#}</p>
        {foreach $data as $item}
            <a class="thumbnail text-center col-xs-12 col-sm-12" href="{$item.url}" title="{$item.name|ucfirst}">
                {if $item.imgSrc.small}
                    <img class="img-responsive" src="{$item.imgSrc.small}" alt="{$item.name|ucfirst}"/>
                {else}
                    <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                {/if}
                <span class="panel-title">{$item.name|ucfirst}</span>
                {if $item.price}
                <span class="price label label-primary">{$item.price}</span>
                {/if}
            </a>
        {/foreach}
    {/if}
    {else}
    {if !$classCol}
        {$classCol = 'col-xs-12 col-sm-6 col-md-4 col-lg-4'}
    {/if}
    {if is_array($data) && !empty($data)}
        <p class="lead">{#last_products#}</p>
        {foreach $data as $item}
            <div{if $classCol} class="{$classCol}{/if}">
                <figure class="{$effect} thumbnail">
                    {if $item.imgSrc.medium}
                        <img class="img-responsive" src="{$item.imgSrc.medium}" alt="{$item.name|ucfirst}"/>
                    {else}
                        <img class="img-responsive" src="{$item.imgSrc.default}" alt="{$item.name|ucfirst}"/>
                    {/if}
                    <figcaption>
                        <h3>{$item.name|ucfirst}</h3>
                        <div class="desc">
                            {if $item.content}
                                <p>
                                    {$item.content|strip_tags|truncate:100:'...'}
                                </p>
                            {/if}
                        </div>
                        <a href="{$item.url}" title="{$item.name|ucfirst}">{$item.name|ucfirst}</a>
                    </figcaption>
                </figure>
            </div>
        {/foreach}
    {/if}
{/if}