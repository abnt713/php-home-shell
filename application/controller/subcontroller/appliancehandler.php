<?php

class ApplianceHandler extends HomeShellSubController {

    private $appliancesModel;

    public function __construct(\HomeShellRequest $request) {
        parent::__construct($request);
        $this->appliancesModel = $this->loadModel('AppliancesModel');
    }

    public function handleSingleAppliance($applianceId, $args) {

        $appliance = $this->appliancesModel->getAppliance($applianceId);

        if (!$appliance) {
            $this->addLocalizedMessage('appliance-not-found');
            $this->end();
        }

        if (count($args) > (argsCount(REQUEST_ENTITY))) {
            // There is more than entity ID
            $divergion = $args[REQUEST_SUBTYPE];

            switch ($divergion) {
                case 'services':
                    $this->handleServices($applianceId, $args);
                    break;
                case 'status':
                    $this->handleStatus($applianceId, $args);
                    break;
                default:
                    $this->setStatus(0);
                    $this->addLocalizedMessage('entity-invalid-parameter');
                    $this->end();
                    break;
            }
        } else {
            // There is only entity id
            $this->getAppliance($applianceId);
        }
    }

    private function getAppliance($applianceId) {
        $appliance = $this->appliancesModel->getAppliance($applianceId);

        if (!$appliance) {
            $this->addLocalizedMessage('appliance-not-found');
            $this->end();
        }

        $services = $this->appliancesModel->getApplianceServices($applianceId);
        $status = $this->appliancesModel->getApplianceStatus($applianceId);

        $servicesJson = array();
        foreach ($services as $service) {
            $servicesJson[] = array(
                'name' => $service->service_trigger
            );
        }

        $statusJson = array();
        foreach ($status as $singleStatus) {
            $statusJson[] = array(
                $singleStatus->status_key => $singleStatus->status_value
            );
        }

        $json = array(
            'id' => $appliance->appliance_id,
            'type' => $appliance->type,
            'services' => $servicesJson,
            'status' => $statusJson
        );

        $this->setStatus(1);
        $this->addLocalizedMessage('operation-success');
        $this->addContent('appliance', $json);
        $this->end();
    }

    private function handleServices($applianceId, $args) {
        if (count($args) > argsCount(REQUEST_SUBTYPE)) {
            $this->addLocalizedMessage('invalid-request');
            $this->addLiteralMessage('Services call must use POST method');
            $this->end();
        } else {
            $services = $this->appliancesModel->getApplianceServices($applianceId);

            $servicesJson = array();
            foreach ($services as $service) {
                $servicesJson[] = array(
                    'name' => $service->service_trigger
                );
            }

            $this->setStatus(1);
            $this->addLocalizedMessage('operation-success');
            $this->addContent('services', $servicesJson);
            $this->end();
        }
    }

    private function handleStatus($applianceId, $args) {
        if (count($args) > (argsCount(REQUEST_SUBTYPE))) {
            $statusName = $args[REQUEST_ACTION];
            $statusModel = $this->loadModel('StatusModel');
            $status = $statusModel->getApplianceStatusByName($applianceId, $statusName);

            if (!$status) {
                $this->addLocalizedMessage('appliance-status-not-found');
                $this->end();
            }

            $this->setStatus(1);
            $this->addLocalizedMessage('operation-success');
            $this->addContent('value', $status->status_value);
            $this->end();
        } else {
            $status = $this->appliancesModel->getApplianceStatus($applianceId);

            $statusJson = array();
            foreach ($status as $singleStatus) {
                $statusJson[] = array(
                    $singleStatus->status_key => $singleStatus->status_value
                );
            }

            $this->setStatus(1);
            $this->addLocalizedMessage('operation-success');
            $this->addContent('status', $statusJson);
            $this->end();
        }
    }

}
