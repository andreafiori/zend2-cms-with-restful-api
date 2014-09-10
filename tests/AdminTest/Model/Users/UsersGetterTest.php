<?php

namespace AdminTest\Model\Users;

use ApplicationTest\TestSuite;
use Admin\Model\Users\UsersGetter;

/**
 * @author Andrea Fiori
 * @since  16 June 2014
 */
class UsersGetterTest extends TestSuite
{
    private $objectGetter;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->objectGetter = new UsersGetter($this->getEntityManagerMock());
    }
    
    public function testSetMainQuery()
    {
        $this->objectGetter->setMainQuery();
        
        $this->assertTrue( is_array($this->objectGetter->getQueryResult()) );
    }
    
    public function testSetId()
    {
        $this->objectGetter->setId(1);
        
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('id'));
    }
    
    public function testSetIdWithArrayInInput()
    {
        $this->objectGetter->setId( array(1,2,3) );
        
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('id'));
    }
    
    public function testSetSurname()
    {
        $this->objectGetter->setSurname('Doe');
        
        $this->assertNotEmpty($this->objectGetter->getQueryBuilder()->getParameter('surname'));
    }
    
    public function testSetStatus()
    {
        $this->objectGetter->setStatus('active');
 
        $this->assertNotEmpty( $this->objectGetter->getQueryBuilder()->getParameter('status') );
    }
}
