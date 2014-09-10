<?php

namespace Admin\Model\AlboPretorio;

use Application\Model\RecordsGetterAbstract;
use Admin\Model\Users\UsersGetter;
use Admin\Model\Users\UsersGetterWrapper;
use Application\Model\NullException;

/**
 * @author Andrea Fiori
 * @since  27 July 2014
 */
class RecordsGetter extends RecordsGetterAbstract
{
    private $articoliWrapper;
    
    /**
     * @param array $input
     */
    public function setArticoliInput(array $input)
    {
        $this->articoliWrapper = new ArticoliGetterWrapper( new ArticoliGetter($this->getEntityManager()) );
        $this->articoliWrapper->setInput($input);
        $this->articoliWrapper->setupQueryBuilder();
        
        return $this->articoliWrapper;
    }
    
    public function setArticoliPaginator()
    {
        $this->assertAlboPretorioGetterWrapper();
        
        $arrayQuery = $this->articoliWrapper->setupQuery($this->getEntityManager());
        
        $this->articoliWrapper->setupPaginator($arrayQuery ? $arrayQuery : array());
        
        return $this->articoliWrapper;
    }
    
    /**
     * @param int $page
     * @return $this->articoliWrapper
     */
    public function setArticoliPaginatorCurrentPage($page = null)
    {
        $this->assertAlboPretorioGetterWrapper();
        
        $this->articoliWrapper->setupPaginatorCurrentPage($page);
        
        return $this->articoliWrapper;
    }
    
    /**
     * @param int $perpage
     * @return type
     */
    public function setArticoliPaginatorPerPage($perpage = null)
    {
        $this->assertAlboPretorioGetterWrapper();
        
        $this->articoliWrapper->setupPaginatorItemsPerPage($perpage);
        
        return $this->articoliWrapper;
    }
    
    public function getPaginatorRecords()
    {
        $this->assertAlboPretorioGetterWrapper();
        
        return $this->articoliWrapper->getPaginator();
    }
    
        /**
         * @throws NullException
         */
        private function assertAlboPretorioGetterWrapper()
        {
            if (!$this->articoliWrapper) {
                throw new NullException('AlboPretorioGetterWrapper is not set. Use setArticoliInput before');
            }
        }
    
    /**
     * @param type $input
     */
    public function setSezioni(array $input)
    {
        $wrapper = new SezioniGetterWrapper( new SezioniGetter($this->getEntityManager()) );
        $wrapper->setInput($input);
        $wrapper->setupQueryBuilder();

        $this->setRecords( $wrapper->getRecords() );
    }
    
    /**
     * @param array $input
     */
    public function setSettori(array $input)
    {
        $wrapper = new UsersGetterWrapper( new UsersGetter($this->getEntityManager()) );
        $wrapper->setInput($input);
        $wrapper->setupQueryBuilder();

        $this->setRecords( $wrapper->getRecords() );
    }
    
    /**
     * Get distinct years for the articoli tables
     */
    public function getYears()
    {
        $this->articoliWrapper = new ArticoliGetterWrapper( new ArticoliGetter($this->getEntityManager()) );
        $this->articoliWrapper->setInput( array('fields'=>'DISTINCT(aa.anno) AS anno','orderBy'=>'aa.anno') );
        $this->articoliWrapper->setupQueryBuilder();
        
        $records = $this->articoliWrapper->getRecords();
        
        if (!$records) {
            return false;
        }
        
        $arrayYears = array();
        foreach($records as $year) {
            if (isset($year['anno'])) {
                $arrayYears[$year['anno']] = $year['anno'];
            }
        }
        
        return $arrayYears;
    }
}