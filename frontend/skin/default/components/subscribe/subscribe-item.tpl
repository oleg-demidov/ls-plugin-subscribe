

{component_define_params params=[ 'oSubscribe', 'classes']}
    
<div class="{$classes} d-flex justify-content-between">
    <div>
        {$oSubscribe->getTargetTitle()}
    </div>
    {component "bs-button" icon="trash-alt" bmods="sm danger"}
</div>
