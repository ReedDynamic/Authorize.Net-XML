<?php
    require('../config.inc.php');
    require('../AuthnetXML.class.php');

/*
    <?xml version="1.0" encoding="utf-8"?>
    <createCustomerProfileTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
        <merchantAuthentication>
            <name>YourUserLogin</name>
            <transactionKey>YourTranKey</transactionKey>
        </merchantAuthentication>
        <transaction>
            <profileTransRefund>
                <amount>10.95</amount>
                <tax>
                    <amount>1.00</amount>
                    <name>WA state sales tax</name>
                    <description>Washington state sales tax</description>
                </tax>
                <shipping>
                    <amount>2.00</amount>
                    <name>ground based shipping</name>
                    <description>Ground based 5 to 10 day shipping</description>
                </shipping>
                <lineItems>
                    <itemId>ITEM00001</itemId>
                    <name>name of item sold</name>
                    <description>Description of item sold</description>
                    <quantity>1</quantity>
                    <unitPrice>6.95</unitPrice>
                    <taxable>true</taxable>
                </lineItems>
                <lineItems>
                    <itemId>ITEM00002</itemId>
                    <name>name of other item sold</name>
                    <description>Description of other item sold</description>
                    <quantity>1</quantity>
                    <unitPrice>1.00</unitPrice>
                    <taxable>true</taxable>
                </lineItems>
                <customerProfileId>10000</customerProfileId>
                <customerPaymentProfileId>20000</customerPaymentProfileId>
                <customerShippingAddressId>30000</customerShippingAddressId>
                <creditCardNumberMasked>XXXX1111</creditCardNumberMasked>
                <order>
                    <invoiceNumber>INV000001</invoiceNumber>
                    <description>description of transaction</description>
                    <purchaseOrderNumber>PONUM000001</purchaseOrderNumber>
                </order>
                <transId>40000</transId>
            </profileTransRefund>
        </transaction>
        <extraOptions><![CDATA[]]></extraOptions>
    </createCustomerProfileTransactionRequest>
*/

    $xml = new AuthnetXML(AUTHNET_LOGIN, AUTHNET_TRANSKEY, AuthnetXML::USE_DEVELOPMENT_SERVER);
    $xml->createCustomerShippingAddressRequest(array(
        'transaction' => array(
            'profileTransRefund' => array(
                'amount' => '10.95',
                'tax' => array(
                    'amount' => '1.00',
                    'name' => 'WA state sales tax',
                    'description' => 'Washington state sales tax'
                ),
                'shipping' => array(
                    'amount' => '2.00',
                    'name' => 'ground based shipping',
                    'description' => 'Ground based 5 to 10 day shipping'
                ),
                'lineItems' => array(
                    'itemId' => 'ITEM00001',
                    'name' => 'name of item sold',
                    'description' => 'Description of item sold',
                    'quantity' => '1',
                    'unitPrice' => '6.95',
                    'taxable' => 'true'
                ),
                'lineItems' => array(
                    'itemId' => 'ITEM00002',
                    'name' => 'other name of item sold',
                    'description' => 'Description of other item sold',
                    'quantity' => '1',
                    'unitPrice' => '1.00',
                    'taxable' => 'true'
                ),
                'customerProfileId' => '10000',
                'customerPaymentProfileId' => '20000',
                'customerShippingAddressId' => '30000',
                'creditCardNumberMasked' => 'XXXX1111',
                'order' => array(
                    'invoiceNumber' => 'INV000001',
                    'description' => 'description of transaction',
                    'purchaseOrderNumber' => 'PONUM000001'
                ),
                'transID' => '4000'
            )
        ),
        'extraOptions' => '<![CDATA[]]>'
    ));

?>