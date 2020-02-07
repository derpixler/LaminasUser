<?php
/**
 * LaminasUser
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license AGPL-3.0 <https://www.gnu.org/licenses/agpl-3.0.en.html>
 */
namespace LaminasUserTest\Authentication\Adapter;

use LaminasUser\Authentication\Adapter\AdapterChainEvent;
use PHPUnit\Framework\TestCase;

class AdapterChainEventTest extends TestCase
{
    /**
     * The object to be tested.
     *
     * @var AdapterChainEvent
     */
    protected $event;

    /**
     * Prepare the object to be tested.
     */
    protected function setUp():void
    {
        $this->event = new AdapterChainEvent();
    }

    /**
     * @covers \LaminasUser\Authentication\Adapter\AdapterChainEvent::getCode
     * @covers \LaminasUser\Authentication\Adapter\AdapterChainEvent::setCode
     * @covers \LaminasUser\Authentication\Adapter\AdapterChainEvent::getMessages
     * @covers \LaminasUser\Authentication\Adapter\AdapterChainEvent::setMessages
     */
    public function testCodeAndMessages()
    {
        $testCode = 103;
        $testMessages = array('Message recieved loud and clear.');

        $this->event->setCode($testCode);
        $this->assertEquals($testCode, $this->event->getCode(), "Asserting code values match.");

        $this->event->setMessages($testMessages);
        $this->assertEquals($testMessages, $this->event->getMessages(), "Asserting messages values match.");
    }

    /**
     * @depends testCodeAndMessages
     * @covers \LaminasUser\Authentication\Adapter\AdapterChainEvent::getIdentity
     * @covers \LaminasUser\Authentication\Adapter\AdapterChainEvent::setIdentity
     */
    public function testIdentity()
    {
        $testCode = 123;
        $testMessages = array('The message.');
        $testIdentity = 'the_user';

        $this->event->setCode($testCode);
        $this->event->setMessages($testMessages);

        $this->event->setIdentity($testIdentity);

        $this->assertEquals($testCode, $this->event->getCode(), "Asserting the code persisted.");
        $this->assertEquals($testMessages, $this->event->getMessages(), "Asserting the messages persisted.");
        $this->assertEquals($testIdentity, $this->event->getIdentity(), "Asserting the identity matches");

        $this->event->setIdentity();

        $this->assertNull($this->event->getCode(), "Asserting the code has been cleared.");
        $this->assertEquals(array(), $this->event->getMessages(), "Asserting the messages have been cleared.");
        $this->assertNull($this->event->getIdentity(), "Asserting the identity has been cleared");
    }

    public function testRequest()
    {
        $request = $this->createMock('Laminas\Stdlib\RequestInterface');
        $this->event->setRequest($request);

        $this->assertInstanceOf('Laminas\Stdlib\RequestInterface', $this->event->getRequest());
    }
}
