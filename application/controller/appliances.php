<?php

class Appliances extends HomeShellController {

    public function onDelete($args) {
        $this->setStatus(0);
        $this->addLocalizedMessage('invalid-request');
        $this->addLiteralMessage('Appliances request cannot answer to DELETE method');
        $this->end();
    }

    public function onGet($args) {
        $this->forceLogin();
        if (count($args) > (argsCount(REQUEST_CONTROLLER))) {
            // There is a id reference at the url
            $entityId = $args[REQUEST_ENTITY];
            $applianceHandler = $this->loadSubController('ApplianceHandler');
            $applianceHandler->handleSingleAppliance($entityId, $args);
        } else {
            $this->getAllAppliances();
        }
    }

    public function onPost($args) {
        $this->forceLogin();
        if(count($args) > argsCount(REQUEST_SUBTYPE)) {
            $applianceId = $args[REQUEST_ENTITY];
            $serviceRunner = $this->loadSubController('ServiceRunner');
            $serviceRunner->callService($applianceId, $args);
        } else {
            $this->setStatus(0);
            $this->addLocalizedMessage('invalid-request');
            $this->addLiteralMessage('Appliance POST must be used only for service calling');
            $this->end();
        }
    }

    private function getAllAppliances() {
        $this->setStatus(1);
        $this->addLiteralMessage('Looking for all appliances');
        $this->end();
    }

}
