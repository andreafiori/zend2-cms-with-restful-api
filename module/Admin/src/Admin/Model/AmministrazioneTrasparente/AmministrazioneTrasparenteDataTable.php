<?php

namespace Admin\Model\AmministrazioneTrasparente;

use Admin\Model\DataTable\DataTableAbstract;
use Admin\Model\Contenuti\ContenutiGetter;
use Admin\Model\Contenuti\ContenutiGetterWrapper;

/**
 * @author Andrea Fiori
 * @since  11 January 2015
 */
class AmministrazioneTrasparenteDataTable extends DataTableAbstract
{
    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        parent::__construct($input);
        
        $this->setTitle('Amministrazione trasparente');
        $this->setDescription('Gestione amministrazione trasparente');
        $this->setColumns( array(
            "Sezione", 
            "Sottosezione", 
            "Titolo", 
            "Anno", 
            "Data inserimento", 
            "Data scadenza",
            "Inserito da", 
            "&nbsp;",
            "&nbsp;",
            "&nbsp;",
            "&nbsp;",
            "&nbsp;",
            "&nbsp;",
            )
        );
        
        $paginatorRecords = $this->getRecordsPaginator();
        
        $this->setVariables(array(
            'paginator'     => $paginatorRecords,
            'tablesetter'   => 'amministrazione-trasparente',
            //'formSearch'    => $formSearch,
            //'formExport'    => $formSearch
            )
        );

        $this->setRecords($this->getFormattedRecords($paginatorRecords));
        
        //$this->setTemplate('datatable/datatable_amministrazione_trasparente.phtml');
    }
    
        /**
         * @return array 
         */
        private function getRecordsPaginator()
        {
            $param = $this->getInput('param', 1);

            $wrapper = new ContenutiGetterWrapper( new ContenutiGetter($this->getInput('entityManager',1)) );
            $wrapper->setInput( array('orderBy' => 'contenuti.id DESC') );
            $wrapper->setupQueryBuilder();
            $wrapper->setupPaginator( $wrapper->setupQuery( $this->getInput('entityManager', 1) ) );
            $wrapper->setupPaginatorCurrentPage(isset($param['route']['page']) ? $param['route']['page'] : null);
            $wrapper->setupPaginatorItemsPerPage(isset($param['route']['perpage']) ? $param['route']['perpage'] : null);

            return $wrapper->getPaginator();
        }

        /**
         * @param type $records
         * @return boolean|array
         */
        private function getFormattedRecords($records)
        {
            if (!$records) {
                return false;
            }

            $recordsToReturn = array();
            foreach($records as $record) {
                $activeDisableButtonValue = ($record['attivo']!=0) ? 'toDisable' : 'toActive';
                $recordsToReturn[] = array(
                    utf8_encode($record['nomeSezione']),
                    utf8_encode($record['nomeSottosezione']),
                    utf8_encode($record['titolo']),
                    $record['anno'],
                    $record['dataInserimento'],
                    $record['dataScadenza'],
                    $record['name'].' '.$record['surname'],
                    array(
                        'type'      => $record['home']!=0 ? 'homepagePutButton' : 'homepageDelButton',
                        'href'      => '?homepage='.$activeDisableButtonValue.'&amp;id='.$record['id'],
                        'value'     => $record['attivo'],
                        'title'     => 'Homepage'
                    ),
                    array(
                        'type'      => $record['attivo']!=0 ? 'activeButton' : 'disableButton',
                        'href'      => '?active='.$activeDisableButtonValue.'&amp;id='.$record['id'],
                        'value'     => $record['attivo'],
                        'title'     => 'Attiva \ Disattiva'
                    ),
                    array(
                        'type'      => 'updateButton',
                        'href'      => $this->getInput('baseUrl',1).'formdata/amministrazione-trasparente/'.$record['id'],
                        'title'     => 'Modifica'
                    ),
                    array(
                        'type'      => 'deleteButton',
                        'href'      => $this->getInput('baseUrl',1).'formdata/amministrazione-trasparente/'.$record['id'],
                        'title'     => 'Elimina',
                        'data-id'   => $record['id']
                    ),
                    array(
                        'type'      => 'attachButton',
                        'href'      => $this->getInput('baseUrl',1).'formdata/attachments/amministrazione-trasparente/'.$record['id'],
                    ),
                    array(
                        'type'      => 'tableButton',
                        'href'      => $this->getInput('baseUrl',1).'formdata/amministrazione-trasparente/'.$record['id'],
                        'title'     => ''
                    ),
                );
            }

            return $recordsToReturn;
        }
}