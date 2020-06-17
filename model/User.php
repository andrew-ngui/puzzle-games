<?php

class User {
    public $username;
    public $first;
    public $last;
    public $given;
    public $gender;
    public $dob;
    public $yearofstudy;
    public $study = array();

    public function __construct() {}

    public static function find_user($dbconn,$data) {
        if ($dbconn) {
            $query="SELECT password FROM users WHERE username='".$data['username']."';";
            $result=pg_query($dbconn, $query);
            while ($row = pg_fetch_row($result)) {
                if (password_verify($data['password'],$row[0])){
                    return true;
                }
            }
        }
        return false;
    }

    public static function add_user($dbconn,$data){
        if($dbconn) {
            $query="SELECT username FROM users WHERE username='".$data['username']."';";
            $result=pg_query($dbconn, $query);
            if(pg_num_rows($result)==0) {
                $query="INSERT INTO users (username, first, last, given, gender ,dob, yearofstudy, password) VALUES ($1,$2,$3,$4,$5,$6,$7,$8);";
                $result = pg_prepare($dbconn, "add_user_query", $query);
                $result = pg_execute($dbconn, "add_user_query", array($data['username'],$data['first'],$data['last'],
                $data['given'],$data['gender'],$data['dob'],$data['yearofstudy'],
                password_hash($data['password'],PASSWORD_DEFAULT))); 
                if (pg_affected_rows($result)==1) {
                    return true;
                }
            };
        }
        return false;
    }

    public static function add_study($dbconn,$data) {
        if($dbconn) {
                $query="INSERT INTO study (username, study) VALUES ($1,$2);";
                $result = pg_prepare($dbconn, "add_study_query", $query);
                foreach($data['study'] as $key=>$value) {
                    $result = pg_execute($dbconn, "add_study_query", array($data['username'],$value));
                }
                return true;  
        };
        return false;
    }

    public function extract_user($dbconn,$data) {
        if($dbconn){
           $query="SELECT * FROM users WHERE username='".$data['username']."';";
           $result=pg_query($dbconn, $query);
           $this->username = $data['username'];
           while ($row = pg_fetch_row($result)) {
               $this->first = $row[1];
               $this->last = $row[2];
               $this->given = $row[3];
               $this->gender = $row[4];
               $this->dob = $row[5];
               $this->yearofstudy = $row[6];
           }
           $query="SELECT * FROM study WHERE username='".$data['username']."';";
           $result=pg_query($dbconn, $query);
           while ($row = pg_fetch_row($result)) {
               $this->study[] = $row[1];
           }
           return true;
        }
        return false;
    }

    public function update_user($dbconn,$data) {
        if($dbconn) {
                $query="UPDATE users SET first = $2, last = $3, given = $4, gender=$5, dob=$6, yearofstudy=$7 WHERE username = $1;";
                $result = pg_prepare($dbconn, "update_user_query", $query);
                $result = pg_execute($dbconn, "update_user_query", array($data['username'],
                $data['first'],$data['last'],$data['given'],$data['gender'],$data['dob'],$data['yearofstudy']));
                if(pg_affected_rows($result)==1) {
                    $this->first = $data['first'];
                    $this->last = $data['last'];
                    $this->given = $data['given'];
                    $this->gender = $data['gender'];
                    $this->dob = $data['dob'];
                    $this->yearofstudy = $data['yearofstudy'];
                    return true;
                }
            };
        return false;
    }
    
    public function update_study($dbconn,$data) {
        if($dbconn) {
                $query="DELETE FROM study WHERE username = $1;";
                $result = pg_prepare($dbconn, "delete_study_query", $query);
                $result = pg_execute($dbconn, "delete_study_query", array($data['username']));
                if (User::add_study($dbconn,$data)){
                    $this->study = $data['study'];
                    return true;
                }
                // return true;
            }
        return false;
    }
    
    
    public static function reset_password($dbconn,$data) {
        if($dbconn) {
                $query="UPDATE users SET password = $1 WHERE username = $2 and dob = $3;";
                $result = pg_prepare($dbconn, "reset_password_query", $query);
                $result = pg_execute($dbconn, "reset_password_query", 
                array(password_hash($data['password'],PASSWORD_DEFAULT),
                $data['username'],$data['dob']));
                if(pg_affected_rows($result)==1) {
                    return true;
                }
            };
        return false;
    }

    
    public function add_win($dbconn, $game, $rounds, $time) {
        if($dbconn) {
                $query="INSERT INTO wins (userid, game, moves, time) VALUES ($1,$2,$3,$4);";
                $result = pg_prepare($dbconn, "add_win", $query);
                $result = pg_execute($dbconn, "add_win", array($this->username, $game, $rounds, $time)); 
        };
    }
}

?>