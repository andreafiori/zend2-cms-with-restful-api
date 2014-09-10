<?php

namespace Admin\Model\Users;

use Admin\Model\FormData\FormDataAbstract;
use Admin\Model\Users\UsersForm;

/**
 * @author Andrea Fiori
 * @since  15 June 2013
 */
class UsersFormDataHandler  extends FormDataAbstract
{
    private $usersGetterWrapper;
    
    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        parent::__construct($input);
        
        $param = $this->getInput('param', 1);

        $records = $this->getUserRecord($param['route']['option']);

        $form = new UsersForm();
        if ($records) {
            $formTitle       = 'Modifica utente';
            $formDescription = 'Modifica dati utente.';

            $form->setData($records[0]);
        } else {
            $formTitle       = 'Nuovo utente';
            $formDescription = 'Creazione nuovo utente.';
        }

        $this->setVariable('form',              $form);
        $this->setVariable('formTitle',         $formTitle);
        $this->setVariable('formDescription',   $formDescription);
        $this->setVariable('formAction',        $this->getFormAction($records));
        
        $this->setVariable('formBreadCrumbCategory',    'Utenti');
        $this->setVariable('formBreadCrumbCategoryLink', $this->getInput('baseUrl',1).'datatable/users');
    } 
        /**
         * @param number $idUser
         * @return boolean
         */
        private function getUserRecord($idUser)
        {
            if ( !is_numeric($idUser) ) {
                return false;
            }
            
            $usersGetterWrapper = new UsersGetterWrapper( new UsersGetter($this->getInput('entityManager', 1)) );
            $usersGetterWrapper->setInput( array("id" => $idUser) );
            $usersGetterWrapper->setupQueryBuilder();
            
            return $usersGetterWrapper->getRecords();
        }

    /**
     * @return string
     */
    public function getFormAction($record = null)
    {
        if (isset($record[0]['id'])) {
            return 'users/update/'.$record[0]['id'];
        }
        
        return 'users/insert/';
    }
}