
{extends "component@bs-button"}

{block 'button_options'}
    {component_define_params params=[ 'event', 'user', 'target_id', 'remove', 'name', 'link']}
    
    {$icon = [icon => "bell", display => 'r', classes => 'mr-1']}
    
    {$bmods = "outline-primary"}
        
    {if $event}
        {$count = $event->getCountSubscribes($target_id)}
        {$event_code = $event->getCode()}
    {/if}
    
    {if $user}
        {$state = $event->isSubscribe($user)}
    {/if}

    
    {if $user}
        {$user_id = $user->getId()}
        {$attributes['data-param-user-id'] = $user->getId()}
    {else}
        {$text = "<span data-toggle='modal-tab' data-target='#nav-tab-authlogin'>{$aLang.plugin.subscribe.subscribe.text.subscribe}</span>"}
        {$attributes[ "data-toggle"] = "modal"}
        {$attributes["data-target"] = "#modalAuth"}
    {/if}
        
    {$attributes["data-{if $remove}un{/if}subscribe"] = true}
    {$attributes['data-param-event'] = $event_code}
    {$attributes['data-param-target-id'] = $target_id}
    {$attributes['data-param-name'] = $name}
    {$attributes['data-param-url'] = $link}
    
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
