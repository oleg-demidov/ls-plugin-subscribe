<?php

/**
 * Description of ActionProfile_EventSettings
 *
 * @author oleg
 */
class PluginSubscribe_ActionSubscribe_EventSubscribe extends Event {
    
       
    protected $oUserProfile = null;
    
    protected $sMenuHeadItemSelect = 'subscribe';


    public function Init() {
        if (!($this->oUserProfile = $this->User_GetUserByLogin(Router::GetActionEvent()))) {
            return false;
        }
    }
    /**
     * Главная страница
     *
     */
    public function EventList()
    {
        $aEvents = $this->PluginSubscribe_Subscribe_GetEventItemsByFilter([
            'enable' => 1,
            '#index-from' => 'code'
        ]);
        
        if(!$aEvents){
            return Router::ActionError('');
        }
        
        $sEvent = $this->GetParam(0);
        
        if(!$sEvent){
            $oEvent = array_shift($aEvents);
            $sEvent = $oEvent->getCode();
        }else{
            $oEvent = $aEvents[$sEvent];
        }
        
        $iPage =  $this->GetParamEventMatch(2, 1) ;
        if(!$iPage){
            $iPage = 1;
        }
        
        $aSubscribes = $this->PluginSubscribe_Subscribe_GetSubscribeItemsByFilter([
            'event_id' => $oEvent->getId(),
            '#page' => [$iPage, Config::Get('plugin.subscribe.subscribes.paging.count_on_page')]
        ]);
        
        $aPaging = $this->Viewer_MakePaging(
            $aSubscribes['count'], 
            $iPage, 
            Config::Get('plugin.subscribe.subscribes.paging.count_on_page'), 
            Config::Get('plugin.subscribe.subscribes.paging.count_page'), 
            Router::GetPath($this->sCurrentEvent.'/'.$this->oUserProfile->getLogin().'/'.$sEvent)
        );
        
        $this->Menu_Get('settings')->setActiveItem('subscribe');
        $this->Menu_Get('subscribe')->setActiveItem($sEvent);
        
        $this->Viewer_Assign('aEvents', $aEvents);
        $this->Viewer_Assign('aSubscribes', $aSubscribes['collection']);
        $this->Viewer_Assign('aPaging', $aPaging);
        $this->Viewer_Assign('oUserProfile', $this->oUserProfile);
        $this->SetTemplateAction('subscribes');
    }
    
    
}
