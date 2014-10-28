<?php

class AppliancesModel extends Model{
    
    public function getAllAppliances(){
        $sql = "SELECT * FROM hs_appliances";
        $statement = $this->db->query($sql);
        
        return $statement->fetchAll();
    }
    
    public function getAppliance($applianceId){
        $sql = "SELECT * FROM hs_appliances WHERE appliance_id = :appliance";
        
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':appliance', $applianceId);
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public function getApplianceServices($applianceId){
        $sql = "SELECT * FROM hs_appliance_services WHERE appliance_id = :appliance";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':appliance', $applianceId);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
    public function getApplianceStatus($applianceId){
        $sql = "SELECT * FROM hs_appliance_status WHERE appliance_id = :appliance";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':appliance', $applianceId);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
}

