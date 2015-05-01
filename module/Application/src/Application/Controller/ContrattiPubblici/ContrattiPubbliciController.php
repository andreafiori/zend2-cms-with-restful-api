<?php

namespace Application\Controller\ContrattiPubblici;

use Admin\Model\ContrattiPubblici\ContrattiPubbliciGetter;
use Admin\Model\ContrattiPubblici\ContrattiPubbliciGetterWrapper;
use Admin\Model\Users\Settori\UsersSettoriGetter;
use Admin\Model\Users\Settori\UsersSettoriGetterWrapper;
use Application\Controller\SetupAbstractController;
use Application\Model\ContrattiPubblici\ContrattiPubbliciFormSearch;

/**
 * @author Andrea Fiori
 * @since  17 April 2015
 */
class ContrattiPubbliciController extends SetupAbstractController
{
    public function indexAction()
    {
        $mainLayout = $this->initializeFrontendWebsite();

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $page = $this->params()->fromRoute('page');

        $templateDir = $this->layout()->getVariable('templateDir');

        $basicLayout = $this->layout()->getVariable('contratti_pubblici_basiclayout');

        $wrapper = new ContrattiPubbliciGetterWrapper(new ContrattiPubbliciGetter($em));
        $wrapper->setInput(array(
            'annullato'  => 0,
            'pubblicare' => 1,
            'attivo'     => 1,
        ));
        $wrapper->setupQueryBuilder();
        $wrapper->setupPaginator( $wrapper->setupQuery($em));
        $wrapper->setupPaginatorCurrentPage(isset($page) ? $page : 0);

        $paginatorContratti = $wrapper->getPaginator();

        $wrapper = new ContrattiPubbliciGetterWrapper(new ContrattiPubbliciGetter($em));
        $wrapper->setInput(array(
            'fields'    => 'DISTINCT(cc.anno) AS anno',
            'orderBy'   => 'cc.anno'
        ));
        $wrapper->setupQueryBuilder();

        $years = $wrapper->getRecords();

        $yearsArray = array();
        foreach($years as $year) {
            $yearsArray[] = $year['anno'];
        }

        /* Select Settori Users */
        $wrapper = new UsersSettoriGetterWrapper(new UsersSettoriGetter($em));
        $wrapper->setInput(array());
        $wrapper->setupQueryBuilder();

        $settoriRecords = $wrapper->getRecords();

        $settori = array();
        foreach($settoriRecords as $settore) {
            $settori[$settore['id']] = $settore['nome'].' '.$settore['name'].' '.$settore['surname'];
        }

        /* Form search */
        $form = new ContrattiPubbliciFormSearch();
        $form->addYears($yearsArray);
        $form->addMainFormElements();
        $form->addSettori($settori);
        $form->addSubmit();

        $this->layout()->setVariables(array(
            'form'                       => $form,
            'paginator'                  => $paginatorContratti,
            'paginator_total_item_count' => $paginatorContratti->getTotalItemCount(),
            'templatePartial'            => 'contratti-pubblici/contratti-pubblici.phtml',
        ));

        $this->layout()->setTemplate(isset($basicLayout) ? $templateDir.$basicLayout : $mainLayout);
    }
}