<?php
/*
<?xml version="1.0"?>
<createCustomerProfileTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  <merchantAuthentication>
    <name>cnpdev4289</name>
    <transactionKey>SR2P8g4jdEn7vFLQ</transactionKey>
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
        <itemId>ITEM00002</itemId>
        <name>other name of item sold</name>
        <description>Description of other item sold</description>
        <quantity>1</quantity>
        <unitPrice>1.00</unitPrice>
        <taxable>true</taxable>
      </lineItems>
      <customerProfileId>5427896</customerProfileId>
      <customerPaymentProfileId>4796541</customerPaymentProfileId>
      <customerShippingAddressId>4907537</customerShippingAddressId>
      <creditCardNumberMasked>XXXX1111</creditCardNumberMasked>
      <order>
        <invoiceNumber>INV000001</invoiceNumber>
        <description>description of transaction</description>
        <purchaseOrderNumber>PONUM000001</purchaseOrderNumber>
      </order>
      <transId>2165735174</transId>
    </profileTransRefund>
  </transaction>
  <extraOptions>&lt;![CDATA[x_customer_ip=100.0.0.1]]&gt;</extraOptions>
</createCustomerProfileTransactionRequest>

<?xml version="1.0" encoding="utf-8"?>
<createCustomerProfileTransactionResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  <messages>
    <resultCode>Ok</resultCode>
    <message>
      <code>I00001</code>
      <text>Successful.</text>
    </message>
  </messages>
  <directResponse>1,1,1,This transaction has been approved.,,P,2165736189,INV000001,description of transaction,10.95,CC,credit,12345,John,Smith,,123 Main Street,Townsville,NJ,12345,,800-555-1234,,newaddress@example.com,John,Doe,,123 Main St.,Bellevue,WA,98004,USA,1.00,,2.00,,PONUM000001,51DEB62B250542109C649849AF94F600,,,,,,,,,,,,,XXXX1111,Visa,,,,,,,,,,,,,,,,,4907537,100.0.0.1]]&gt;</directResponse>
</createCustomerProfileTransactionResponse>
*/

    require('../config.inc.php');
    require('../AuthnetXML.class.php');

    $xml = new AuthnetXML(AUTHNET_LOGIN, AUTHNET_TRANSKEY, AuthnetXML::USE_DEVELOPMENT_SERVER);
    $xml->createCustomerProfileTransactionRequest(array(
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
                'customerProfileId' => '5427896',
                'customerPaymentProfileId' => '4796541',
                'customerShippingAddressId' => '4907537',
                'creditCardNumberMasked' => 'XXXX1111',
                'order' => array(
                    'invoiceNumber' => 'INV000001',
                    'description' => 'description of transaction',
                    'purchaseOrderNumber' => 'PONUM000001'
                ),
                'transId' => '2165735174'
            )
        ),
        'extraOptions' => '<![CDATA[x_customer_ip=100.0.0.1]]>'
    ));

    echo $xml;

?>