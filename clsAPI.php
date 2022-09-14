<?php

//generic REST API call class. Returns a JSON object with data or throws an exception
class APICall { 
  
    public static function post($configObject, $service, $arrParams = array()){
        return self::call($configObject,  "POST", $service, $arrParams);
    }
    public static function get($configObject, $service, $arrParams = array()){
                return self::call($configObject, "GET", $service, $arrParams);
    }
 // other methods can be implemented in the future (delete, put)
	private static function call($configObject, $curl_method, $service, $arrParams = array()) {
        $curl_endpoint= $configObject["endpoint"];
        $token=$configObject["token"];
        $post_items = array();
        foreach ( $arrParams as $key => $value) {
            $post_items[] = urlencode($key) . '=' . urlencode($value);
        }
	//create the final string to be posted using implode()
        $post_string = implode ('&', $post_items);

        //create cURL connection
        $curl_connection = curl_init($curl_endpoint.$service.'?format=json&'.($curl_method == "POST" ? '' : $post_string));

        //set options
        if ($token){
            $headers = array();  //add auth token if present
            $headers[] = "X-Authorization: $token";            
            $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
         
        //set data to be posted
        if($curl_method == "POST"){
            curl_setopt($curl_connection, CURLOPT_POST, true); 
            curl_setopt($curl_connection, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl_connection, CURLOPT_HTTPGET, false);
        }else{
            curl_setopt($curl_connection, CURLOPT_POST, false); 
            curl_setopt($curl_connection, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl_connection, CURLOPT_HTTPGET, true);
        }
        curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

        //makes the call
        $result = curl_exec($curl_connection);
        $bom = pack('H*','EFBBBF');
        $result = preg_replace("/^$bom/", '', $result); //ensure is raw UTF8
        //show information regarding the request
     if($result){
         $json = json_decode($result);
         if ($json->error) throw new Exception('Service Error: '.$json->error,8);
         return $json;
     }else{
         throw new Exception('API Communication problem',9); // in the future use custom exceptions with more info
     }
 }
}


//this code should be in a separated config manager class fileS
class configManager{
    private $endpoint;
    private $token;
    //in the future this can be overloaded to get config info from better sources
    public function __construct($api_url, $token){
          $this->endpoint = $api_url;
          $this->token = $token;
    }
    public function getConfig() 
    {
      
      $config = array('endpoint'=> "".$this->endpoint."");
      $config += array('token'=> "".$this->token."");
      return $config;
    }
  
  }

?>

