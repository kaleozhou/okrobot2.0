<?php
namespace App\OKCoin;
class Requestor
{

    public function doCurlRequest($curl)
    {
        $response = curl_exec($curl);
        // Check for errors
        if($response === false) {
            $error = curl_errno($curl);
            $message = curl_error($curl);
            curl_close($curl);
            var_dump("Network error " . $message . " (" . $error . ")");
        }
        // Check status code
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if($statusCode != 200) {
            var_dump("Status code " . $statusCode, $statusCode, $response);
        }

        return array( "statusCode" => $statusCode, "body" => $response );
    }

}
