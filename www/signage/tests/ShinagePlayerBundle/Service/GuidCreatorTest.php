<?php

namespace mztx\tests\ShinagePlayerBundle\Service;

use mztx\ShinagePlayerBundle\Service\GuidCreator;
use PHPUnit\Framework\TestCase;

class GuidCreatorTest extends TestCase
{
    /** @var GuidCreator */
    protected $testSubject;

    protected function setUp()
    {
        parent::setUp();
        $this->testSubject = new GuidCreator();
    }

    public function testCreateGUIDFormat()
    {
        $guid = $this->testSubject->createGUID();
        $this->assertEquals(
            1,
            preg_match('/^[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}$/', $guid),
            "Format of GUID wrong. Has to be: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
        );
    }

    public function testCreateGUIDNotZero()
    {
        $guid = $this->testSubject->createGUID();
        $this->assertNotEquals("00000000-0000-0000-0000-000000000000", $guid, "GUID empty/zero!");
    }
}
