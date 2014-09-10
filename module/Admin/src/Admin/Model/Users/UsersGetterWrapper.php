<?php

namespace Admin\Model\Users;

use Application\Model\RecordsGetterWrapperAbstract;
use Admin\Model\Users\UsersGetter;

/**
 * @author Andrea Fiori
 * @since  14 June 2014
 */
class UsersGetterWrapper extends RecordsGetterWrapperAbstract
{
    /** @var \Admin\Model\Users\UsersGetter **/
    protected $objectGetter;

    /**
     * @param \Admin\Model\Users\UsersGetter $usersGetter
     */
    public function __construct(UsersGetter $usersGetter)
    {
        $this->setObjectGetter($usersGetter);
    }
    
    public function setupQueryBuilder()
    {
        $this->objectGetter->setSelectQueryFields( $this->getInput('fields', 1) );
        
        $this->objectGetter->setMainQuery();
        
        $this->objectGetter->setId( $this->getInput('id', 1) );
        $this->objectGetter->setSurname( $this->getInput('surname', 1) );
        $this->objectGetter->setEmail( $this->getInput('email', 1) );
        $this->objectGetter->setUsername( $this->getInput('username', 1) );
        $this->objectGetter->setPassword( $this->getInput('password', 1) );
        $this->objectGetter->setStatus( $this->getInput('status', 1) );
        $this->objectGetter->setOrderBy( $this->getInput('orderBy', 1) );
        $this->objectGetter->setGroupBy( $this->getInput('groupBy', 1) );
        $this->objectGetter->setLimit( $this->getInput('limit', 1) );
    }
}