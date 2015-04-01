<?php


namespace Kayue\WordpressBundle\Tests\Wordpress\Shortcode;


use Kayue\WordpressBundle\Wordpress\Shortcode\GalleryShortcode;
use Kayue\WordpressBundle\Wordpress\Shortcode\ShortcodeChain;

class GalleryShortcodeTest extends \PHPUnit_Framework_TestCase
{
    public function testProcess()
    {
        $attachmentManagerMock = $this->getMockBuilder('Kayue\WordpressBundle\Model\AttachmentManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $attachmentManagerMock
            ->expects($this->any())
            ->method('findImageWithIds')
            ->will($this->returnValue(array()))
        ;
        $templatingMock = $this->getMock('Symfony\Component\Templating\EngineInterface');
        $templatingMock
            ->expects($this->any())
            ->method('render')
            ->will($this->returnValue('something'))
        ;
        $container = $this->getMock('Symfony\Component\DependencyInjection\Container');
        $container
            ->expects($this->any())
            ->method('get')
            ->will($this->onConsecutiveCalls($attachmentManagerMock, $templatingMock))
        ;

        $galleryShortcode = new GalleryShortcode($container);
        $final = $galleryShortcode->process(array('ids' => '1,2,3'));

        $this->assertEquals($final, 'something');
    }
}
