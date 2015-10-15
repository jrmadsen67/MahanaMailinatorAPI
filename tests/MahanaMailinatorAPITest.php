<?php 

use jrmadsen67\MahanaMailinatorAPI\MahanaMailinatorAPI;

class MahanaMailinatorAPITest extends \PHPUnit_Framework_TestCase
{

     /**
     * Until these are changed to mocks, you will need to set inbox & token to your own values
     *
     */
     
    private $inbox = '';

    private $token = '';

    private $private_domain = null;

    public function testWorks()
    {
        $this->assertTrue(true);
    }

    /**
    * @expectedException Exception
    * @expectedExceptionMessage Please set your Mailinator API Token.
    */
    public function testNoTokenThrowsError()
    {
        $token = null;
        $mmapi = new MahanaMailinatorAPI($token);
    }

    public function testShouldReturnEmailsInInbox()
    {
        $mmapi = new MahanaMailinatorAPI($this->token);

        $emails = $mmapi->fetchInbox($this->inbox);

        $this->assertInternalType('array', $emails);
    }

    public function testCreateCallbackParametersStringReturnsTokenString()
    {
        $mmapi = new MahanaMailinatorAPI($this->token);

        $params = ['to' => $this->inbox];

        $callbackParams = $mmapi->createCallbackParametersString($params);

        $this->assertEquals('to=' . $this->inbox . '&token=' . $this->token , $callbackParams);
    }

    public function testCreateCallbackParametersStringReturnsTokenStringAndPrivateDomain()
    {
        $private_domain = 'myowndomain';

        $mmapi = new MahanaMailinatorAPI($this->token, $private_domain);

        $params = ['to' => $this->inbox];

        $callbackParams = $mmapi->createCallbackParametersString($params);

        $compareString = 'to=' . $this->inbox . '&token=' . $this->token . '&private_domain=' . $private_domain;

        $this->assertEquals($compareString , $callbackParams);
    }  

}    