<?php


class PluginSubscribe_HookEvent extends Hook{
    public function RegisterHook()
    {
        $aEvents = $this->PluginSubscribe_Subscribe_GetEventItemsByFilter([
           'enable' => true 
        ]);
        
        foreach ($aEvents as $oEvent) {
            $this->AddHook($oEvent->getCode(), 'RunSubscribeEvent');
        }
                
    }
    
    public function RunSubscribeEvent($aParams, $sName) {
        $oEvent = $this->PluginSubscribe_Subscribe_GetEventByCode($sName);
        
        $aSubscribes = $this->PluginSubscribe_Subscribe_GetSubscribeItemsByFilter([
            '#index-from' => 'user_id',
            'event_id' => $oEvent->getId()
        ]);
        
        if(!$aSubscribes){
            return false;
        }
        
        return call_user_func_array([$this, $oEvent->getCallback()], [array_keys($aSubscribes), $aParams]);
    }

}
