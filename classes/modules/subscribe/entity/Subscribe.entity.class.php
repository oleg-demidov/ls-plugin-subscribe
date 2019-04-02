<?php

class PluginSubscribe_ModuleSubscribe_EntitySubscribe extends EntityORM
{
    
    protected $aRelations = array(
        'event' => array( self::RELATION_TYPE_BELONGS_TO, 'PluginSubscribe_ModuleSubscribe_EntityEvent', 'event_id' )
    );
    
    protected $aValidateRules = [
    ];
    
   
}