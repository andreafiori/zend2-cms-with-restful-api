<?php

namespace ApiWebService\Model\Resources;

use ApiWebService\Model\ApiResultGetterAbstract;
use Admin\Model\AlboPretorio\RecordsGetter;

/**
 * TODO: set paginator, set formatted contents (returns array)
 * 
 * @author Andrea Fiori
 * @since  24 August 2014
 */
class AlboPretorioApiResource extends ApiResultGetterAbstract
{
    /**
     * @param array $input
     * @return array
     */
    public function getResourceRecords(array $input)
    {
        $recordsGetter = new RecordsGetter($input);
        $recordsGetter->setEntityManager($this->getEntityManager());
        $recordsGetter->setArticoliInput($input);
        $recordsGetter->setArticoliPaginator();
        $recordsGetter->setArticoliPaginatorCurrentPage(isset($input['page']) ? $input['page'] : null);
        $recordsGetter->setArticoliPaginatorPerPage(isset($input['perpage']) ? $input['perpage'] : null);
        
        $paginator = $recordsGetter->getPaginatorRecords();
        
        $toReturn = array();
        foreach($paginator as $row) {
            $toReturn[] = $row;
        }
        return $toReturn;
    }
}