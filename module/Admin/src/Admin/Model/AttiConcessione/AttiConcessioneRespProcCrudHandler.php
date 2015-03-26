<?php

namespace Admin\Model\AttiConcessione;

use Admin\Model\FormData\CrudHandlerAbstract;
use Admin\Model\FormData\CrudHandlerInsertUpdateInterface;
use Admin\Model\FormData\CrudHandlerInterface;
use Admin\Model\Modules\ModulesContainer;
use Application\Model\Database\DbTableContainer;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 * @author Andrea Fiori
 * @since  25 March 2015
 */
class AttiConcessioneRespProcCrudHandler extends CrudHandlerAbstract implements CrudHandlerInterface, CrudHandlerInsertUpdateInterface
{
    private $dbTable;

    private $moduleId;

    public function __construct()
    {
        $this->form = new AttiConcessioneRespProcForm();

        $this->formInputFilter = new AttiConcessioneRespF();

        $this->dbTable = DbTableContainer::attiConcessioneRespProc;

        $this->moduleId = ModulesContainer::atti_concessione;
    }

    /**
     * @param InputFilterAwareInterface $formData
     *
     * @return array
     */
    public function validateFormData(InputFilterAwareInterface $formData)
    {
        $error = $this->checkValidateFormDataError(
            $formData,
            array('titolo', 'beneficiario', 'importo', 'modassegn', 'dataInserimento', 'anno')
        );

        /* chars, symbols and string are in the old db
        if (!is_numeric($formData->importo)) {
            $error[] = 'Importo non &egrave; un numero';
        }
        */

        if ( (int)$formData->anno > 2030 or (int)$formData->anno < 1954 ) {
            $error[] = 'Anno atto deve essere un anno valido.';
        }

        return $error;
    }

    /**
     * @param InputFilterAwareInterface $formData
     *
     * @return int
     */
    public function insert(InputFilterAwareInterface $formData)
    {
        $this->asssertConnection();

        $this->assertUserDetails();

        $userDetails = $this->getUserDetails();

        return $this->getConnection()->insert($this->dbTable, array(
            'titolo'        => $formData->titolo,
            'beneficiario'  => $formData->beneficiario,
            'importo'       => $formData->importo,
            'modassegn'     => $formData->modassegn,
            'data'          => $formData->dataInserimento,
            'anno'          => $formData->anno,
            'settore_id'    => $formData->ufficioResponsabile,
            'resp_proc_id'  => $formData->respProc,
            'utente'        => $userDetails->id,
        ));
    }

    /**
     * @param InputFilterAwareInterface $formData
     *
     * @return int
     */
    public function update(InputFilterAwareInterface $formData)
    {
        $this->asssertConnection();

        $this->assertUserDetails();

        $userDetails = $this->getUserDetails();

        $arrayToUpdate = array(
            'titolo'        => $formData->titolo,
            'beneficiario'  => $formData->beneficiario,
            'importo'       => $formData->importo,
            'modassegn'     => $formData->modassegn,
            'data'          => $formData->dataInserimento,
            'anno'          => $formData->anno,
            'settore_id'    => $formData->ufficioResponsabile,
            'resp_proc_id'  => $formData->respProc,
        );

        if (isset($formData->utente)) {
            $arrayToUpdate['utente_id'] = $formData->utente;
        }

        return $this->getConnection()->update(
            $this->dbTable,
            $arrayToUpdate,
            array('id'    => $formData->id),
            array('limit' => 1)
        );
    }

    /**
     * TODO: delete attachments
     *
     * @param $id
     */
    public function delete($id)
    {
        return $this->getConnection()->delete(
            $this->dbTable,
            array('id'    => $id),
            array('limit' => 1)
        );
    }

    /**
     * @return bool
     *
     * @throws \Application\Model\NullException
     */
    public function logInsertOk()
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $logsWriter = $this->getLogsWriter();

        $inputFilter = $this->getFormInputFilter();

        return $logsWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => $userDetails->name.' '.$userDetails->surname."', ha inserito l'atto concessione ".$inputFilter->titolo,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }

    /**
     * @param null $message
     *
     * @return bool
     */
    public function logInsertKo($message = null)
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $logsWriter = $this->getLogsWriter();

        $inputFilter = $this->getFormInputFilter();

        return $logsWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => $userDetails->name.' '.$userDetails->surname."', errore nell'inserimento atto concessione ".$inputFilter->titolo.'Messaggio: '.$message,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }

    /**
     * @return bool
     */
    public function logUpdateOk()
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $logsWriter = $this->getLogsWriter();

        $inputFilter = $this->getFormInputFilter();

        return $logsWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => $userDetails->name.' '.$userDetails->surname."', ha aggiornato l'atto concessione ".$inputFilter->titolo,
            'type'      => 'info',
            'backend'   => 1,
        ));
    }

    /**
     * @param null $message
     *
     * @return bool
     */
    public function logUpdateKo($message = null)
    {
        $this->assertUserDetails();

        $this->assertLogWriter();

        $userDetails = $this->getUserDetails();

        $logsWriter = $this->getLogsWriter();

        $inputFilter = $this->getFormInputFilter();

        return $logsWriter->writeLog(array(
            'user_id'   => $userDetails->id,
            'module_id' => $this->moduleId,
            'message'   => $userDetails->name.' '.$userDetails->surname."', errore nell'aggiornamento dell'atto concessione ".$inputFilter->titolo.' Messaggio: '.$message,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }
}