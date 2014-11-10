<?php

class StatusModel extends Model{
    
    public function getApplianceStatusByName($applianceId, $statusName){
        $sql = "SELECT * FROM hs_appliance_status WHERE appliance_id = :appliance AND status_name = :status";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':appliance', $applianceId);
        $statement->bindParam(':status', $statusName);
        
        $statement->execute();
        return $statement->fetch();
    }
    
    public function updateStatusByName($applianceId, $statusName, $value){
        $sql = "UPDATE hs_appliance_status SET status_value = :value WHERE appliance_id = :appliance"
        . " AND status_name = :name";
        
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':value', $value);
        $statement->bindParam(':appliance', $applianceId);
        $statement->bindParam(':name', $statusName);
        
        return $statement->execute();
    }
    
}

