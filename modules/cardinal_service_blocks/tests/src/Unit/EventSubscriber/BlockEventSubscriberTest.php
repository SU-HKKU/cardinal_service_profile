<?php

namespace Drupal\Tests\cardinal_service_blocks\Unit\EventSubscriber;

use Drupal\cardinal_service_blocks\EventSubscriber\BlockEventSubscriber;
use Drupal\layout_builder\Event\SectionComponentBuildRenderArrayEvent;
use Drupal\layout_builder\SectionComponent;
use Drupal\Tests\UnitTestCase;

/**
 * Class BlockEventsSubscriberTest
 *
 * @group cardinal_service_blocks
 * @coversDefaultClass \Drupal\cardinal_service_blocks\EventSubscriber\BlockEventSubscriber
 */
class BlockEventSubscriberTest extends UnitTestCase {

  public function testSubscribedEvents() {
    $this->assertArrayEquals([
      'section_component.build.render_array' => [
        'onBuildRender',
        1,
      ],
    ], BlockEventSubscriber::getSubscribedEvents());
  }

  public function testOnBuildRender() {
    $component = $this->createMock(SectionComponent::class);
    $component->method('getThirdPartySetting')->willReturn('http://foo.bar');


    $event = new SectionComponentBuildRenderArrayEvent($component, []);
    $event->setBuild([]);

    $subscriber = new BlockEventSubscriber();
    $subscriber->onBuildRender($event);

    $this->assertArrayEquals(['#configuration' => ['action_url' => 'http://foo.bar']], $event->getBuild());
  }

}
