<?php

namespace mztx\tests\ShinagePlayerBundle\Service;

use mztx\ShinagePlayerBundle\Service\UrlBuilder;
use PHPUnit\Framework\TestCase;

class UrlBuilderTest extends TestCase
{
    /** @var UrlBuilder  */
    protected $testSubject;

    protected function setUp()
    {
        parent::setUp();
        $this->testSubject = new UrlBuilder("proto", "testhost", "test/base/", ["test1" => "/test/2/"]);
    }

    /**
     * @param string $left
     * @param string $right
     * @param string $expected
     * @dataProvider provideConcatUrl
     */
    public function testConcatUrl($left, $right, $expected)
    {
        $url = $this->testSubject->concat($left, $right);
        $this->assertEquals($expected, $url, "URL not built as expected");
    }


    public function provideConcatUrl()
    {
        return [
            ['left',    'right',    'left/right'],
            ['left/',   'right',    'left/right'],
            ['left',    '/right',   'left/right'],
            ['left/',   '/right',   'left/right'],
            ['/left',   'right',    '/left/right'],
            ['/left/',  'right',    '/left/right'],
            ['/left',   '/right',   '/left/right'],
            ['/left/',  '/right',   '/left/right'],
            ['left',    'right/',   'left/right/'],
            ['left/',   'right/',   'left/right/'],
            ['left',    '/right/',  'left/right/'],
            ['left/',   '/right/',  'left/right/'],
            ['/left',   'right/',   '/left/right/'],
            ['//left/', 'right/',   '//left/right/'],
            ['///left',  '/right/', '///left/right/'],
            ['////left/', '/right/', '////left/right/'],
            ['left//',    '///right',    'left/right'],
            ['/left1/left2/',    '/right2/right1//',    '/left1/left2/right2/right1//'],
        ];
    }
}
