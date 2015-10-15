<?php 
namespace jrmadsen67\MahanaMailinatorAPI;


/**
* MahanaMailinatorAPI
*
* @description Php Mailinator API library
*
* For use with https://mailinator.com/apidocs.jsp
*
* @author Jeff Madsen
* @url http://codebyjeff.com
* 
*/

class MahanaMailinatorAPI{


    private $token;

    private $private_domain;

    private $apiEndpoint = "https://api.mailinator.com/api/";
    
    private $inboxCount = 0;

    public function __construct($token = null, $private_domain = false)
    {
        if (empty($token))
        {
            throw new \Exception('Please set your Mailinator API Token.');
        }  

        if ($private_domain)
        {
            $this->private_domain = $private_domain;
        }  

        $this->token = $token;
    }

    private function call($method, $params)
    {
        $ch = curl_init();

        $callback_parameters = $this->createCallbackParametersString($params);

        curl_setopt($ch, CURLOPT_URL, $this->apiEndpoint . $method . '?' . $callback_parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $exec = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if(isset($info["http_code"]) && $info["http_code"] == 200)
        {
            return json_decode($exec, true);
        }
        
        throw new \Exception('There was an error contacting the mailinator API endpoint.');
    }

    public function createCallbackParametersString($params)
    {
        $additionalParams = ['token' => $this->token];

        if (!empty($this->private_domain))
        {
            $additionalParams['private_domain'] = $this->private_domain;
        }    
        
        return http_build_query(array_merge($params, $additionalParams),'', '&');
    }

     /**
     * Get entire inbox. Inbox can include "@mailinator" or not
     *
     * @param string $inbox
     *
     * @return array
     */
    public function fetchInbox($inbox)
    {
        $query = $this->call('inbox', ['to' => $inbox]);

        if(!isset($query["messages"]))
        {
            throw new \Exception('Missing messages data in response from mailinator API.');
        }

        // TODO: using or not?
        $this->inboxCount = count($query["messages"]);
        return $query["messages"];
    }

    public function fetchMail($msgId)
    {
        $query = $this->call('email', array('id' => $msgId));

        if(!isset($query["data"]))
        {
            throw new \Exception('Missing data in response from mailinator API.');
        }

        return $query["data"];
    }

    public function deleteMail($msgId)
    {
        $query = $this->call('delete', array('id' => $msgId));

        if($query['status'] != 'ok')
        {
            throw new \Exception('Missing delete data in response from mailinator API.');
        }

        return $query['status'];
    }

    
}
