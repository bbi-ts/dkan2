<?php

namespace Drupal\Tests\dkan_datastore\Unit\Controller;

use Drupal\dkan_common\Tests\DkanTestBase;
use Drupal\dkan_datastore\Service\Datastore;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\dkan_datastore\Controller\Api;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;

/**
 * @coversDefaultClass Drupal\dkan_datastore\Controller\Datastore
 * @group              dkan_datastore
 */
class DatastoreApiTest extends DkanTestBase {

  public function getContainer() {
    parent::setUp(); // TODO: Change the autogenerated stub
    $container = $this->getMockBuilder(ContainerInterface::class)
        ->setMethods(['get'])
        ->disableOriginalConstructor()
        ->getMockForAbstractClass();
    $container->method('get')
      ->with($this->logicalOr($this->equalTo('dkan_datastore.service')))
      ->will($this->returnCallback([$this, 'containerGet']));
    return $container;
  }

  public function containerGet($serviceName) {
    switch ($serviceName) {
      case 'dkan_datastore.service':
        $mockEntityTypeManager = $this->createMock(EntityTypeManagerInterface::class);
        $mockLogger = $this->createMock(LoggerChannelInterface::class);
        $mockConnection = $this->createMock(Connection::class);
        return new Datastore($mockEntityTypeManager, $mockLogger, $mockConnection);
    }
  }


  /**
   * Tests Construct().
   */
  public function testDatasetWithSummary() {
    $controller = Api::create($this->getContainer());
    $response = $controller->summary('asdbv');
    print_r($response->getContent());
  }
}