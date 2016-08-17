<?php

/**
 * Curl actions class. 
 */
class CurlRequestComponent extends Component {
    
    /**
     * Execute the curl method - always POST     	
     */
    public function curlRequest($url, $postData) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}