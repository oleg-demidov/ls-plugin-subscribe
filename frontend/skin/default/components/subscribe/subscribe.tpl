
{extends "component@bs-button"}

{block 'button_options'}
    {component_define_params params=[ 'event', 'user', 'target_id', 'remove']}
    
    {$icon = [icon => "bell", display => 'r', classes => 'mr-1']}
    
    {$bmods = "outline-primary"}
        
    {if $event}
        {$count = $event->getCountSubscribes()}
        {$event_code = $event->getCode()}
    {/if}
    
    {if $user}
        {$state = $event->isSubscribe($user)}
    {/if}

    
    {if $user}
        {$user_id = $user->getId()}
        {$attributes['data-param-user-id'] = $user->getId()}
    {/if}
        
    {$attributes['data-btn-ajax'] = true}
    {$attributes["data-{if $remove}un{/if}subscribe"] = true}
    {$attributes['data-param-event'] = $event_code}
    {$attributes['data-param-state'] = {$state|default:0}}    
    {$attributes['data-param-target-id'] = $target_id} 
    
    {if $state}
        {$classes = "active"}
        {$text = $text|default:$aLang.plugin.subscribe.subscribe.text.unsubscribe}
    {else}
        {$text = $text|default:$aLang.plugin.subscribe.subscribe.text.subscribe}
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
