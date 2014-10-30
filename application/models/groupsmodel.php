<?php

class GroupsModel extends Model{
    
    public function getAllGroups(){
        $sql = "SELECT * FROM hs_groups";
        $statement = $this->db->query($sql);
        
        return $statement->fetchAll();
    }
    
    public function getGroup($groupId){
        $sql = "SELECT * FROM hs_groups WHERE group_id = :group";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':group', $groupId);
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public function getAllAppliancesFromGroup($groupId){
        $sql = "SELECT appliance_id FROM hs_group_appliances WHERE group_id = :group";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':group', $groupId);
        $statement->execute();
        
        return $statement->fetchAll();
    }
    
}

