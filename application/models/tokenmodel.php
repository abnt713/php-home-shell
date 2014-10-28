<?php

class TokenModel extends Model{
    
    public function getToken($authToken){
        $sql = "SELECT * FROM hs_tokens WHERE token = :token";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':token', $authToken);
        
        $statement->execute();
        
        return $statement->fetch();
    }
    
    public function revalidateToken($tokenId, $validTime){
        $sql = "UPDATE hs_tokens SET valid = :valid WHERE token_id = :token";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':valid', $validTime);
        $statement->bindParam(':token', $tokenId);
        
        return $statement->execute();
    }
    
    public function createToken($userId, $token, $created, $valid){
        $sql = "INSERT INTO hs_tokens (user_id, token, created, valid) VALUES (:user, :token, :created, :valid)";
        $statement = $this->db->prepare($sql);
        
        $statement->bindParam(':user', $userId);
        $statement->bindParam(':token', $token);
        $statement->bindParam(':created', $created);
        $statement->bindParam(':valid', $valid);
        
        return $statement->execute();
    }
    
    public function removeAllTimedOutTokens($currentTime){
        $sql = "DELETE FROM hs_tokens WHERE valid < '{$currentTime}'";
        return $this->db->exec($sql);
    }
}

