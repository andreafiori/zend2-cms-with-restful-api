<?php

namespace Admin\Controller\ContrattiPubblici;

use Admin\Model\ContrattiPubblici\ContrattiPubbliciGetter;
use Admin\Model\ContrattiPubblici\ContrattiPubbliciGetterWrapper;
use Application\Controller\SetupAbstractController;

class ContrattiPubbliciSummaryController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeAdminArea();

        $page       = $this->params()->fromRoute('page');
        $perPage    = $this->params()->fromRoute('perpage');
        $em         = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $wrapper = new ContrattiPubbliciGetterWrapper( new ContrattiPubbliciGetter($em) );
        $wrapper->setInput( array('orderBy' => 'cc.id DESC') );
        $wrapper->setupQueryBuilder();
        $wrapper->setupPaginator( $wrapper->setupQuery($em) );
        $wrapper->setupPaginatorCurrentPage( is_numeric($page) ? $page : null );
        $wrapper->setupPaginatorItemsPerPage($perPage);

        $paginator = $wrapper->getPaginator();
        $wrapperRecords = $wrapper->setupRecords();
        $paginatorRecords = $this->formatArticoliRecords($wrapperRecords);

        $this->layout()->setVariables(array(
                'tableTitle'        => 'Contratti pubblici',
                'tableDescription'  => $paginator->getTotalItemCount()." contratti in archivio",
                'columns' =>array(
                    "Oggetto del bando",
                    "Struttura proponente \ responsabili",
                    "Aggiudicatario",
                    /*
                    "Scelta del Contraente",
                    "Elenco degli Operatori invitati a presentare offerte",
                    "Vedi elenco" (posizione precednete)
                    */
                    "Scelta del Contraente",
                    "Importo somme liquidate Euro",
                    /*
                    "Inserito da",
                    "Operatori invitati a presentare le offerte",
                    */
                    "Tempi",
                    "&nbsp;",
                    "&nbsp;",
                    "&nbsp;",
                    "&nbsp;",
                    "&nbsp;"
                ),
                'paginator'         => $paginator,
                'records'           => $paginatorRecords,
                'templatePartial'   => 'datatable/datatable_contratti_pubblici.phtml'
            )
        );

        $this->layout()->setTemplate($mainLayout);
    }

        /**
         * @param array $records
         * @return array
         */
        private function formatArticoliRecords($records)
        {
            $arrayToReturn = array();
            if ($records) {
                foreach($records as $key => $row) {
                    $arrayToReturn[] = array(
                        "<strong>CIG:</strong> ".$row['cig']."<br><br><strong>Oggetto del bando</strong>: ".$row['titolo']."<br><br><strong>Anno:</strong> ".$row['anno']."<br><br> <strong>Data Contratto:</strong> ".$row['data'],
                        "<strong>CF:</strong> <br><br><strong>Str. prop.:</strong> ".$row['nomeSettore']."<br><br> <strong>Resp. Proc.:</strong> ".$row['responsabileUsersName'],
                        "<br><strong>Data aggiudicazione:</strong> <br><br> <strong>Importo di aggiudicazione (Euro):</strong> ".$row['importoAggiudicazione'],
                        '<strong>Numero di offerte ammesse:</strong> '.$row['numeroOfferte']."<br><br><strong>Procedura di scelta del contraente:</strong> ".$row['nomeScelta'],
                        $row['importoLiquidato'],
                        "<strong>Inizio lavori:</strong> ".$row['dataInizioLavori']."<br><br> <strong>Fine lavori:</strong> ".$row['dataFineLavori']."<br><br> Scadenza: ".$row['scadenza'],
                        array(
                            'type'      => 'tableButton',
                            'href'      => 'contratti-pubblici-aggiudicatari/elenco/'.$row['id'],
                            'title'     => 'Elenco aggiudicatari \ partecipanti'
                        ),
                        array(
                            'type'      => $row['attivo']!=0 ? 'activeButton' : 'disableButton',
                            'href'      => '#',
                            'value'     => $row['attivo'],
                            'title'     => 'Attiva \ Disattiva'
                        ),
                        array(
                            'type'      => 'updateButton',
                            'href'      => $this->url()->fromRoute('admin/contratti-pubblici-form', array('lang' => 'it', 'id' => $row['id']) ),
                            'title'     => 'Modifica'
                        ),
                        array(
                            'type'      => 'deleteButton',
                            'href'      => '#',
                            'title'     => 'Elimina',
                            'data-id'   => $row['id']
                        ),
                        array(
                            'type'      => 'attachButton',
                            'href'      => $this->url()->fromRoute('admin/attachments-form', array(
                                'lang'      => 'it',
                                'module'    => 'contratti-pubblici',
                                'id'        => $row['id']
                                )
                            ),
                            'title'     => 'Gestione allegati'
                        ),
                    );
                }
            }

            return $arrayToReturn;
        }
}