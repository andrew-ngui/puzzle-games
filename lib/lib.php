<?php
	require_once "dbconnect_string.php";
        function db_connect(){
                global $g_dbconnect_string;
                $dbconn = @pg_connect($g_dbconnect_string);
                if(!$dbconn){
			return null;
		} else return $dbconn;
        }

	// return the errors in a standard format
        function view_msg($msg){
                $s="";
                foreach($msg as $key=>$value){
                        $s .= "<br/> $value";
                }
                return $s;
        }

        function page_token() {
                $token = md5(uniqid(rand(), true));
                $_SESSION['token'] = $token;
                $form = "<input type='text' name='token' value='";
                $form .= $token;
                $form .= "' style='display:none'>";
                return $form;
        }

        function create_lifetime_session($second) {
                session_save_path("sess");
                session_start();
                if (!isset($_SESSION['created'])) { 
                        $_SESSION['created'] = time();
                } elseif (time()-$_SESSION['created'] > $second) {
                        session_unset();
                        session_destroy();
                        session_save_path("sess");
                        session_start(); 
                        $_SESSION['created'] = time();
                        unset($_REQUEST);
                }
        }


?>
