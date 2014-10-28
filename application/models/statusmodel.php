<?php

class StatusModel extends Model{
    
    public function getApplianceStatusByName($applianceId, $statusName){
        $sql = "SELECT * FROM hs_appliance_status WHERE appliance_id = :appliance AND status_key = :status";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':appliance', $applianceId);
        $statement->bindParam(':status', $statusName);
        
        $statement->execute();
        return $statement->fetch();
    }
    
}

