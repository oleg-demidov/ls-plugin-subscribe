<?php

class PluginSubscribe_ModuleSubscribe_EntityEvent extends EntityORM
{
    protected $aRelations = array(
        'subscribes' => array( self::RELATION_TYPE_HAS_MANY, 'PluginSubscribe_ModuleSubscribe_EntitySubscribe', 'event_id' )
    );
    
    public function getCountSubscribes() {
        if(parent::getCountSubscribes() === null){
            parent::setCountSubscribes($this->PluginSubscribe_Subscribe_GetCountFromSubscribeByFilter([]));
        }
        
        return parent::getCountSubscribes();
    }
    
    public function isSubscribe($oUser) {
        if($oSubscribe = $this->getSubcribe($oUser)){
            return 1;
        }
        return 0;
    }
    
    public function getSubcribe($oUser) {
        return $this->PluginSubscribe_Subscribe_GetSubscribeByFilter([
            'event_id' => $this->getId(),
            'user_id' => $oUser->getId()
        ]);
    }
        
    protected $aValidateRules = [
        ['code', 'event_exists']
    ];
    
    public function ValidateEventExists($sValue) {
        if($this->PluginSubscribe_Subscribe_GetEventByCode()){
            return "Event {$sValue} exists";
        }
        return true;
    }
}