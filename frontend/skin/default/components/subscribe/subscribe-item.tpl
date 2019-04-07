

{component_define_params params=[ 'oSubscribe', 'classes']}
    
<div class="{$classes} d-flex justify-content-between">
    <div class="p-1">
        {$oSubscribe->getTargetTitle()}
    </div>
    {insert name='block' block='subscribe' params=[ 
        remove  => true,
        plugin  => 'subscribe',
        event   => $oSubscribe->getEvent()->getCode(),
        target_id => $oSubscribe->getTargetId()
    ]}
</div>
