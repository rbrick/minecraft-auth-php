<?php

  /*
    A profile consists of a name and a uuid
  */
  class Profile {
 
     static $uname = null;
	 static $uuid = null;
 
    /**
     * 
     * @param String $name
     * @param String $uuid
     */
    public function __construct($name, $uuid) {
        self::$uname = $name;
        self::$uuid = $uuid;
    }

    public function get_account_name() {
      return self::$uname;
    }

    public function get_account_id() {
      return self::$uuid;
    }
  }



 class Authenticator {



   public function authenticate($name, $password) {
     // The data we will write to the body
	 $auth_url = "https://authserver.mojang.com/authenticate";
		
     $raw_data = array("agent" => array("name" => "minecraft","version" => 1),"username" => $name,"password" => $password);

     $data = json_encode($raw_data);

     $headers = array('http' => array('header' => 'Content-Type: application/json', 'method' => 'POST', 'content' => $data));

     $context  = stream_context_create($headers);
     $result = file_get_contents($auth_url,false,$context);

     $json_info = json_decode($result);
	
	 // The profile info 
	 $id = $json_info->{'selectedProfile'}->{'id'};
	 $name = $json_info->{'selectedProfile'}->{'name'};
	 
	 return new Profile($name, $id);
   }

 }

 