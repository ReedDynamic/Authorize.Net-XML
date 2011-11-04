<?php

/*************************************************************************************************

This class allows for easy use of any Authorize.Net XML based APIs. More information
about these APIs can be found at http://developer.authorize.net/api/.

PHP version 5

LICENSE: This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.

@category   Ecommerce
@package    AuthnetXML
@author     John Conde <github@johnconde.net>
@copyright  2005 - 2011 John Conde
@license    http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
@version    1.0
@link       http://www.johnconde.net/

**************************************************************************************************/

class AuthnetXMLException extends Exception {}

class AuthnetXML
{
    const USE_PRODUCTION_SERVER  = 0;
    const USE_DEVELOPMENT_SERVER = 1;

    const EXCEPTION_CURL = 10;

    private $ch;
	private $login;
    private $response;
    private $response_xml;
    private $results;
    private $transkey;
    private $url;
    private $xml;

	public function __construct($login, $transkey, $test = self::USE_PRODUCTION_SERVER)
	{
		$login    = trim($login);
        $transkey = trim($transkey);
        if (empty($login) || empty($transkey))
        {
            trigger_error('You have not configured your ' . __CLASS__ . '() login credentials properly.', E_USER_WARNING);
        }

        $this->login    = trim($login);
        $this->transkey = trim($transkey);
        $test           = (bool) $test;

        $subdomain = ($test) ? 'apitest' : 'api';
        $this->url = 'https://' . $subdomain . '.authorize.net/xml/v1/request.api';
	}

	public function __toString()
	{
	    $output  = '';
        $output .= '<table summary="Authorize.Net Results" id="authnet">' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Class Parameters</b></th>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>API Login ID</b></td><td>' . $this->login . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>Transaction Key</b></td><td>' . $this->transkey . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>cURL Handle</b></td><td>' . $this->ch . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<td><b>Authnet Server URL</b></td><td>' . $this->url . '</td>' . "\n" . '</tr>' . "\n";
        $output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Outgoing XML</b></th>' . "\n" . '</tr>' . "\n";
        if (isset($this->xml) && !empty($this->xml))
        {
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($this->xml);
            $outgoing_xml = $dom->saveXML();

            $output .= '<tr><td>' . "\n";
            $output .= 'XML:</td><td><pre>' . "\n";
            $output .= htmlentities($outgoing_xml) . "\n";
            $output .= '</pre></td></tr>' . "\n";
        }
        if (!empty($this->response))
        {
            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($this->response);
            $response = $dom->saveXML();

            $output .= '<tr><td>' . "\n";
            $output .= 'Response</td><td><pre>' . "\n";
            $output .= htmlentities($response) . "\n";
            $output .= '</pre></td></tr>' . "\n";
        }
        return $output;
	}

	public function __destruct()
    {
        if (isset($this->ch))
        {
            curl_close($this->ch);
        }
    }

    public function __get($var)
	{
	    return $this->response_xml->$var;
	}

	public function __set($key, $value)
	{
	    trigger_error('You cannot set parameters directly in ' . __CLASS__ . '.', E_USER_WARNING);
	    return false;
	}

	public function __call($api_call, $args)
	{
	    $this->xml = new SimpleXMLElement('<' . $api_call . '></' . $api_call . '>');
        $this->xml->addAttribute('xmlns', 'AnetApi/xml/v1/schema/AnetApiSchema.xsd');
	    $merch_auth = $this->xml->addChild('merchantAuthentication');
        $merch_auth->addChild('name', $this->login);
	    $merch_auth->addChild('transactionKey', $this->transkey);

		$this->setParameters($this->xml, $args[0]);
		$this->process();
	}

	private function setParameters($xml, $array)
	{
	    if (is_array($array))
	    {
    	    foreach ($array as $key => $value)
    		{
    			if (is_array($value))
    			{
    				$xml->addChild($key);
    				$this->setParameters($xml->$key, $value);
    			}
    			else
    			{
    				$xml->$key = $value;
    			}
    		}
    	}
	}

	private function process()
	{
		$this->xml = $this->xml->asXML();

		$this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
    	curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($this->ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
    	curl_setopt($this->ch, CURLOPT_HEADER, 0);
    	curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->xml);
    	curl_setopt($this->ch, CURLOPT_POST, 1);
    	curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        if(($this->response = curl_exec($this->ch)) !== false)
        {
            $this->response_xml = @new SimpleXMLElement($this->response);

		    curl_close($this->ch);
            unset($this->ch);
            return;
		}
        throw new AuthnetXMLException('Connection error: ' . curl_error($this->ch) . ' (' . curl_errno($this->ch) . ')', self::EXCEPTION_CURL);
	}

	public function isSuccessful()
    {
        return $this->response_xml->messages->resultCode === 'Ok';
    }

    public function isError()
    {
        return $this->response_xml->messages->resultCode !== 'Ok';
    }
}

?>