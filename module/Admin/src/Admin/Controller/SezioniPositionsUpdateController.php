<?php

namespace Admin\Controller;

use Application\Controller\SetupAbstractController;
use Application\Model\Database\DbTableContainer;

/**
 * @author Andrea Fiori
 * @since  24 March 2015
 */
class SezioniPositionsUpdateController extends SetupAbstractController
{
    public function indexAction()
    {
        if (!$this->checkLogin()) {
            return $this->redirect()->toRoute('login');
        }

        $appServiceLoader = $this->recoverAppServiceLoader();

        $sql = array();

        $items = $this->params()->fromQuery('oggettoItem');

        $connection = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default')->getConnection();

        if (!empty($items)):
            foreach ($items as $position => $item):
                $connection->update(
                    DbTableContainer::sezioni,
                    array('posizione' => $position),
                    array('id' => $item)
                );
            endforeach;
        endif;

        $this->layout()->setTerminal(true);
        $this->layout('backend/templates/'.$appServiceLoader->recoverServiceKey('configurations', 'template_backend').'sezioni/positions_message.phtml');
    }
}