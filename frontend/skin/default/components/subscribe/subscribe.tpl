
{extends "component@bs-button"}

{block 'button_options'}
    {component_define_params params=[ 'event', 'user', 'target_title']}
    
    {$icon = [icon => "bell", display => 'r', classes => 'mr-1']}
    
    {$bmods = "outline-primary"}
        
    {if $event}
        {$count = $event->getCountSubscribes()}
        {$state = $event->isSubscribe($user)}
        {$event_code = $event->getCode()}
        
    {/if}
    
    {if $user}
        {$user_id = $user->getId()}
        {$attributes['data-param-user-id'] = $user->getId()}
    {/if}
        
    {$attributes['data-btn-ajax'] = true}
    {$attributes['data-subscribe'] = true}
    {$attributes['data-param-event'] = $event_code}
    {$attributes['data-param-state'] = {$state|default:0}}    
    {$attributes['data-param-target-title'] = $target_title} 
    
    {if $state}
        {$classes = "active"}
        {$text = $aLang.plugin.subscribe.subscribe.text.unsubscribe}
    {else}
        {$text = $aLang.plugin.subscribe.subscribe.text.subscribe}
    {/if}
    
    {if !$count}
        {$badgeClasses = "d-none"}
    {/if}

    {$badge = [
        text => {$count|default:1},
        classes => $badgeClasses,
        bmods => $bmods
    ]}
    
{/block}
