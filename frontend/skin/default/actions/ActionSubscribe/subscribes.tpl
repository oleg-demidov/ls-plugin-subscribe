{**
 * Предложения
 *}
{extends 'layouts/layout.base.tpl'}

{block 'layout_content'}
    
    <div class="d-flex flex-column">
        {foreach $aSubscribes as $oSubscribe}
            {component "subscribe:subscribe.item" 
                classes = "mt-3 p-2 border rounded"
                oSubscribe=$oSubscribe}
        {/foreach}
    </div>
    
    {if !$aSubscribes}
        {component 'blankslate' text=$aLang.plugin.subscribe.menu_profile.blankslate.text}
    {/if}    
    
    {component 'bs-pagination' 
        total   = $aPaging['iCountPage'] 
        padding = 2
        showPager=true
        classes = "mt-3"
        current= $aPaging['iCurrentPage']  
        url="{$aPaging['sBaseUrl']}/page__page__" }

{/block}
