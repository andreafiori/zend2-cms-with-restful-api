<?php

namespace Admin\Model\AlboPretorio;

use Admin\Model\FormData\CrudHandlerAbstract;
use Admin\Model\FormData\CrudHandlerInsertUpdateInterface;
use Admin\Model\FormData\CrudHandlerInterface;
use Application\Model\Database\DbTableContainer;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 * @author Andrea Fiori
 * @since  23 October 2014
 */
class AlboPretorioArticoliCrudHandler extends CrudHandlerAbstract implements CrudHandlerInterface, CrudHandlerInsertUpdateInterface
{
    private $dbTable;

    public function __construct()
    {
        $this->form = new AlboPretorioArticoliForm();
        $this->form->addSezioni(array(
            1 => 'Bandi',
            2 => 'Concorsi',
        ));
        $this->form->addTitolo();
        $this->form->addMainFields();
        $this->form->addRettifica();
        $this->form->addFacebook();

        $this->formInputFilter = new AlboPretorioArticoliFormInputFilter();

        $this->dbTable = DbTableContainer::alboArticoli;
    }

    /**
     * @param InputFilterAwareInterface $formData
     * @return array
     */
    public function validateFormData(InputFilterAwareInterface $formData)
    {
        $error = $this->checkValidateFormDataError(
            $formData,
            array('userId', 'sezione', 'numeroAtto', 'anno', 'dataScadenza', 'titolo')
        );

        if (!is_numeric($formData->numeroAtto)) {
            $error[] = 'Numero atto non &egrave; un numero';
        }

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
            'utente_id'             => $userDetails->id,
            'sezione_id'            => $formData->sezione,
            'numero_progressivo'    => $formData->numeroProgressivo,
            'numero_atto'           => $formData->numeroAtto,
            'anno'                  => $formData->anno,
            'data_attivazione'      => date("Y-m-d H:i:s"),
            'ora_attivazione'       => date("H:i:s"),
            'data_pubblicare'       => date("Y-m-d H:i:s"),
            'ora_pubblicare'        => date("H:i:s"),
            'data_scadenza'         => $formData->dataScadenza,
            'data_pubblicare'       => date("Y-m-d H:i:s"),
            'titolo'                => $formData->titolo,
            'pubblicare'            => 0,
            'annullato'             => 0,
            'check_invia_regione'   => isset($formData->checkInviaRegione) ? $formData->checkInviaRegione : 0,
            'anno_atto'             => date("Y"),
            'ente_terzo'            => $formData->enteTerzo,
            'fonte_url'             => $formData->fonteUrl,
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

        return $this->getConnection()->update(
            $this->dbTable,
            array(
                'utente_id'             => $userDetails->id,
                'sezione_id'            => $formData->sezione,
                'numero_progressivo'    => $formData->numeroProgressivo,
                'numero_atto'           => $formData->numeroAtto,
                'anno'                  => $formData->anno,
                'data_attivazione'      => date("Y-m-d H:i:s"),
                'ora_attivazione'       => date("H:i:s"),
                'data_pubblicare'       => date("Y-m-d H:i:s"),
                'ora_pubblicare'        => date("H:i:s"),
                'data_scadenza'         => $formData->dataScadenza,
                'data_pubblicare'       => date("Y-m-d H:i:s"),
                'titolo'                => $formData->titolo,
                'pubblicare'            => 0,
                'annullato'             => 0,
                'check_invia_regione'   => isset($formData->checkInviaRegione) ? $formData->checkInviaRegione : 0,
                'anno_atto'             => date("Y"),
                'ente_terzo'            => $formData->enteTerzo,
                'fonte_url'             => $formData->fonteUrl,
                'note'                  => $formData->note,
            ),
            array('id' => $formData->id)
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
            'module_id' => 2,
            'message'   => $userDetails->name.' '.$userDetails->surname."', ha inserito l'atto albo pretorio ".$inputFilter->titolo,
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
            'module_id' => 2,
            'message'   => $userDetails->name.' '.$userDetails->surname."', errore nell'inserimento atto albo pretorio ".$inputFilter->titolo.'Messaggio: '.$message,
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
            'module_id' => 2,
            'message'   => $userDetails->name.' '.$userDetails->surname."', ha aggiornato l'atto albo pretorio ".$inputFilter->titolo,
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
            'module_id' => 2,
            'message'   => $userDetails->name.' '.$userDetails->surname."', errore nell'aggiornamento dell'atto albo pretorio ".$inputFilter->titolo.' Messaggio: '.$message,
            'type'      => 'error',
            'backend'   => 1,
        ));
    }
}

