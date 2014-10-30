<?php

class UsersModel extends Model{
    
    public function doLogin($username, $password){
        // TODO: Check if we should avoid creating multiple tokens
        $sql = "SELECT user_id FROM hs_users WHERE (username = :username OR email = :username) AND password = :password";
//        $sql = "SELECT user_id FROM hs_users WHERE (username = '{$username}' OR email = '{$username}') AND password = sha1('{$password}')";
        $statement = $this->db->prepare($sql);
        
        $password = sha1($password);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':username', $username);
        
        $statement->execute();
        
        $allRecords = $statement->fetchAll();
        if(count($allRecords) > 0){
            return $allRecords[0];
        }else{
            return null;
        }
    }
    
    public function getUser($userId){
        $sql = "SELECT * FROM hs_users WHERE user_id = :user";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':user', $userId);
        $statement->execute();
        
        $allUsers = $statement->fetchAll();
        
        if(count($allUsers) > 0){
            return $allUsers[0];
        }else{
            return null;
        }
    }
    
}

