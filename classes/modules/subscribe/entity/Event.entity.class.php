<?php

class PluginSubscribe_ModuleSubscribe_EntityEvent extends EntityORM
{
    protected $aRelations = array(
        'subscribes' => array( self::RELATION_TYPE_HAS_MANY, 'PluginSubscribe_ModuleSubscribe_EntitySubscribe', 'event_id' )
    );
        
}