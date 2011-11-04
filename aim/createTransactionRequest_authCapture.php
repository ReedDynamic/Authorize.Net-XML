<?php
/*************************************************************************************************

Use the AIM XML API to process an Authorization and Capture transaction (Sale)

SAMPLE XML FOR API CALL
--------------------------------------------------------------------------------------------------
<?xml version="1.0"?>
<createTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  <merchantAuthentication>
    <name>cnpdev4289</name>
    <transactionKey>SR2P8g4jdEn7vFLQ</transactionKey>
  </merchantAuthentication>
  <refId>92347199</refId>
  <transactionRequest>
    <transactionType>authCaptureTransaction</transactionType>
    <amount>5</amount>
    <payment>
      <creditCard>
        <cardNumber>5424000000000015</cardNumber>
        <expirationDate>122016</expirationDate>
        <cardCode>999</cardCode>
      </creditCard>
    </payment>
    <lineItems>
      <lineItem>
        <itemId>1</itemId>
        <name>vase</name>
        <description>Cannes logo</description>
        <quantity>18</quantity>
        <unitPrice>45.00</unitPrice>
      </lineItem>
    </lineItems>
    <tax>
      <amount>4.26</amount>
      <name>level2 tax name</name>
      <description>level2 tax</description>
    </tax>
    <duty>
      <amount>8.55</amount>
      <name>duty name</name>
      <description>duty description</description>
    </duty>
    <shipping>
      <amount>4.26</amount>
      <name>level2 tax name</name>
      <description>level2 tax</description>
    </shipping>
    <poNumber>456654</poNumber>
    <customer>
      <id>18</id>
      <email>someone@blackhole.tv</email>
    </customer>
    <billTo>
      <firstName>Ellen</firstName>
      <lastName>Johnson</lastName>
      <company>Souveniropolis</company>
      <address>14 Main Street</address>
      <city>Pecan Springs</city>
      <state>TX</state>
      <zip>44628</zip>
      <country>USA</country>
    </billTo>
    <shipTo>
      <firstName>China</firstName>
      <lastName>Bayles</lastName>
      <company>Thyme for Tea</company>
      <address>12 Main Street</address>
      <city>Pecan Springs</city>
      <state>TX</state>
      <zip>44628</zip>
      <country>USA</country>
    </shipTo>
    <customerIP>192.168.1.1</customerIP>
    <transactionSettings>
      <setting>
        <settingName>testRequest</settingName>
        <settingValue>false</settingValue>
      </setting>
    </transactionSettings>
    <userFields>
      <userField>
        <name>favorite_color</name>
        <value>blue</value>
      </userField>
    </userFields>
  </transactionRequest>
</createTransactionRequest>

SAMPLE XML RESPONSE
--------------------------------------------------------------------------------------------------
<?xml version="1.0" encoding="utf-8"?>
<createTransactionResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  <refId>92347199</refId>
  <messages>
    <resultCode>Ok</resultCode>
    <message>
      <code>I00001</code>
      <text>Successful.</text>
    </message>
  </messages>
  <transactionResponse>
    <responseCode>1</responseCode>
    <authCode>S9HC6P</authCode>
    <avsResultCode>Y</avsResultCode>
    <cvvResultCode>P</cvvResultCode>
    <cavvResultCode>2</cavvResultCode>
    <transId>2165665315</transId>
    <refTransID/>
    <transHash>5FCA4E3F786673F81CC214469703BAAB</transHash>
    <testRequest>0</testRequest>
    <accountNumber>XXXX0015</accountNumber>
    <accountType>MasterCard</accountType>
    <messages>
      <message>
        <code>1</code>
        <description>This transaction has been approved.</description>
      </message>
    </messages>
    <userFields>
      <userField>
        <name>favorite_color</name>
        <value>blue</value>
      </userField>
    </userFields>
  </transactionResponse>
</createTransactionResponse>

*************************************************************************************************/

    require('../config.inc.php');
    require('../AuthnetXML.class.php');

    $xml = new AuthnetXML(AUTHNET_LOGIN, AUTHNET_TRANSKEY, AuthnetXML::USE_DEVELOPMENT_SERVER);
    $xml->createTransactionRequest(array(
        'refId' => rand(1000000, 100000000),
        'transactionRequest' => array(
            'transactionType' => 'authCaptureTransaction',
            'amount' => 5,
            'payment' => array(
                'creditCard' => array(
                    'cardNumber' => '4111111111111111',
                    'expirationDate' => '122016',
                    'cardCode' => '999',
                ),
            ),
            'lineItems' => array(
                'lineItem' => array(
                    'itemId' => '1',
                    'name' => 'vase',
                    'description' => 'Cannes logo',
                    'quantity' => '18',
                    'unitPrice' => '45.00',
                ),
            ),
            'tax' => array(
               'amount' => '4.26',
               'name' => 'level2 tax name',
               'description' => 'level2 tax',
            ),
            'duty' => array(
               'amount' => '8.55',
               'name' => 'duty name',
               'description' => 'duty description',
            ),
            'shipping' => array(
               'amount' => '4.26',
               'name' => 'level2 tax name',
               'description' => 'level2 tax',
            ),
            'poNumber' => '456654',
            'customer' => array(
               'id' => '18',
               'email' => 'someone@blackhole.tv',
            ),
            'billTo' => array(
               'firstName' => 'Ellen',
               'lastName' => 'Johnson',
               'company' => 'Souveniropolis',
               'address' => '14 Main Street',
               'city' => 'Pecan Springs',
               'state' => 'TX',
               'zip' => '44628',
               'country' => 'USA',
            ),
            'shipTo' => array(
               'firstName' => 'China',
               'lastName' => 'Bayles',
               'company' => 'Thyme for Tea',
               'address' => '12 Main Street',
               'city' => 'Pecan Springs',
               'state' => 'TX',
               'zip' => '44628',
               'country' => 'USA',
            ),
            'customerIP' => '192.168.1.1',
            'transactionSettings' => array(
                'setting' => array(
                    'settingName' => 'allowPartialAuth',
                    'settingValue' => 'false',
                ),
                'setting' => array(
                    'settingName' => 'duplicateWindow',
                    'settingValue' => '0',
                ),
                'setting' => array(
                    'settingName' => 'emailCustomer',
                    'settingValue' => 'false',
                ),
                'setting' => array(
                  'settingName' => 'recurringBilling',
                  'settingValue' => 'false',
                ),
                'setting' => array(
                    'settingName' => 'testRequest',
                    'settingValue' => 'false',
                ),
            ),
            'userFields' => array(
                'userField' => array(
                    'name' => 'MerchantDefinedFieldName1',
                    'value' => 'MerchantDefinedFieldValue1',
                ),
                'userField' => array(
                    'name' => 'favorite_color',
                    'value' => 'blue',
                ),
            ),
        ),
    ));

    echo $xml;
?>