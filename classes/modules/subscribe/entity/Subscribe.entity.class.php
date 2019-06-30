<?php

class PluginSubscribe_ModuleSubscribe_EntitySubscribe extends EntityORM
{
    
    protected $aRelations = array(
        'event' => array( self::RELATION_TYPE_BELONGS_TO, 'PluginSubscribe_ModuleSubscribe_EntityEvent', 'event_id' )
    );
    
    protected $aValidateRules = [
        ['name', 'string', 'on' => ['create']],
        ['target_id', 'number', 'on' => ['create']],
        ['event_id', 'event_exists', 'on' => ['create']],
        ['user_id', 'number', 'on' => ['create']],
        ['user_id event_id target_id', 'subscribe_exists'],
    ];
    
    public function ValidateEventExists($mValue) {
        if(!$oEvent = $this->PluginSubscribe_Subscribe_GetEventById( $mValue )){
            return $this->Lang_Get(
                'plugin.subscribe.event.notices.error_validate_exists'
            );
        }
        return true;
    }
    
    public function ValidateSubscribeExists($mValue) {
        $oSubscribe = $this->PluginSubscribe_Subscribe_GetSubscribeByFilter( [
            'user_id' => $this->getUserId(),
            'event_id'  => $this->getEventId(),
            'target_id' => $this->getTargetId()
        ]);
        
        if($oSubscribe){
            if($oEvent = $this->PluginSubscribe_Subscribe_GetEventById( $this->getEventId() )){
                return $this->Lang_Get(
                    'plugin.subscribe.subscribe.notices.error_validate_exists',
                    [ 'event_name' => $oEvent->getTitle()]
                );
            }
            return $this->Lang_Get('plugin.subscribe.subscribe.notices.error_validate_exists');
        }
        return true;
    }
}