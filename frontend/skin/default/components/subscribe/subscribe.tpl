
{extends "component@bs-button"}

{block 'button_options'}
    {component_define_params params=[ 'event', 'user']}
    
    {$icon = [icon => "thumbs-up", display => 'r', classes => 'mr-1']}
    
    {if $event}
        {$count = $event->getCountSubscribes()}
        {$state = $event->isSubscribe($user)}
        {$event_code = $event->getCode()}
        
    {/if}
    
    {if $user}
        {$user_id = $user->getId()}
    {/if}
        
    {$attributes['data-btn-ajax'] = true}
    {$attributes['data-subscribe'] = true}
    {$attributes['data-param-event'] = $event_code}
    {$attributes['data-param-user-id'] = $user_id}
    {$attributes['data-param-state'] = {$state|default:0}}    
    
    
    {if $state}
        {$classes = "active"}
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
