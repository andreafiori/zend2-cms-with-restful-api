<?php

namespace AdminTest\Controller\Posts;

use Admin\Controller\Posts\BlogsSummaryController;
use ApplicationTest\TestSuite;

/**
 * @author Andrea Fiori
 * @since  11 April 2015
 */
class BlogsSummaryControllerTest extends TestSuite
{
    private  $controller;

    protected function setUp()
    {
        parent::setUp();

        $this->controller = new BlogsSummaryController();
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($this->getServiceManager());
    }

    public function testIndexAction()
    {
        $this->routeMatch->setParam('action', 'index');

        $this->controller->dispatch($this->request);

        $this->assertEquals(200, $this->controller->getResponse()->getStatusCode());
    }
}