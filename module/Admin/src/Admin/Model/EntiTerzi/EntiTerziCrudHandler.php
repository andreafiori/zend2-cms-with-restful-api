<?php

namespace Admin\Model\EntiTerzi;

use Admin\Model\FormData\CrudHandlerInterface;
use Admin\Model\FormData\CrudHandlerAbstract;

/**
 * @author Andrea Fiori
 * @since  18 August 2014
 */
class EntiTerziCrudHandler extends CrudHandlerAbstract implements CrudHandlerInterface
{
    private $tableName = 'zfcms_comuni_rubrica_enti_terzi';
    
    protected function insert()
    {
        $this->getConnection()->beginTransaction();
        try {
            // Validate
            $error = array();

            $varsToCheck = array('nome', 'email');
            foreach($varsToCheck as $var) {
                if ( !isset($this->rawPost[$var]) or empty($this->rawPost[$var]) ) {
                    $error[] = 'Campo <strong>'.$var.'</strong> non settato fra i campi del form';
                }
            }

            if (!empty($error)) {
                $this->setErrorMessage($error);
                return false;
            }

            // Insert into db
            $this->getConnection()->insert($this->tableName, array(
                'nome'      => $this->rawPost['nome'],
                'email'     => $this->rawPost['email'],
            ));
            $this->getConnection()->commit();

            // Log
            $userDetails  = $this->getInput('userDetails', 1);

            $logsWriter = $this->getLogsWriter();
            $logResult = $logsWriter->writeLog(array(
                'user_id'   => $userDetails->id,
                'module_id' => '12',
                'message'   => $userDetails->name.' '.$userDetails->surname."' ha aggiornato l'ente terzo ".$this->rawPost['nome'],
                'type'      => 'info',
                'backend'   => 1,
            ));

            if ($logResult!=1) {
                $this->setSuccessMessage('Dati salvati correttamente', 'Dati salvati correttamente, ma attenzione: il log non &egrave; stato scritto nel registro. Errore: '.$logResult, 'warning');
            } else {
                $this->setSuccessMessage();
            }
            
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            $errorMessage = $e->getMessage();

            // Log
            $userDetails  = $this->getInput('userDetails', 1);

            $logsWriter = $this->getLogsWriter();
            $logResult = $logsWriter->writeLog(array(
                'user_id'   => $userDetails->id,
                'module_id' => 12,
                'message'   => $userDetails->name.' '.$userDetails->surname."', errore durante l'aggiornamento dell'ente terzo ".$this->rawPost['nome'].' Messaggio: '.$errorMessage,
                'type'      => 'error',
                'backend'   => 1,
            ));

            return $this->setErrorMessage($errorMessage);
        }

        return true;
    }
    
    protected function update()
    {
        $this->getConnection()->beginTransaction();
        try {
            // Validate input
            $error = array();

            $varsToCheck = array('nome', 'email');
            foreach($varsToCheck as $var) {
                if ( !isset($this->rawPost[$var]) or empty($this->rawPost[$var]) ) {
                    $error[] = 'Campo <strong>'.$var.'</strong> non settato fra i campi del form';
                }
            }

            $this->setArrayRecordToHandle('nome', 'nome');
            $this->setArrayRecordToHandle('email', 'email');

            // Update
            $this->getConnection()->update($this->tableName,
                    $this->getArrayRecordToHandle(),
                    array('id' => $this->rawPost['id'])
            );

            $this->getConnection()->commit();

            // Log
            $userDetails  = $this->getInput('userDetails', 1);

            $logsWriter = $this->getLogsWriter();
            $logResult = $logsWriter->writeLog(array(
                'user_id'   => $userDetails->id,
                'module_id' => 12,
                'message'   => $userDetails->name.' '.$userDetails->surname."' ha aggiornato l'ente terzo ".$this->rawPost['nome'],
                'type'      => 'info',
                'backend'   => 1,
            ));

            if ($logResult!=1) {
                $this->setSuccessMessage('Dati salvati correttamente', 'Dati salvati correttamente, ma attenzione: il log non &egrave; stato scritto nel registro. Errore: '.$logResult, 'warning');
            } else {
                $this->setSuccessMessage();
            }

        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            return $this->setErrorMessage($e->getMessage());
        }

        return true;
    }

    public function delete($id, array $recordDataDeleted)
    {
        $userDetails  = $this->getInput('userDetails', 1);

        $this->getConnection()->beginTransaction();
        try {

            $this->getConnection()->delete( $this->tableName, array('id' => $id) );

            $this->getConnection()->commit();

            // Log
            $logsWriter = $this->getLogsWriter();
            $logsWriter->writeLog(array(
                'user_id'   => $userDetails->id,
                'module_id' => 2,
                'message'   => $userDetails->name.' '.$userDetails->surname."', ha cancellato il contenuto ".$id,
                'type'      => 'error',
                'backend'   => 1,
            ));

            $this->setSuccessMessage();

        } catch (\Exception $e) {
            $this->getConnection()->rollBack();

            // Log
            $errorMessage = $e->getMessage();

            $logsWriter = $this->getLogsWriter();
            $logsWriter->writeLog(array(
                'user_id'   => $userDetails->id,
                'module_id' => '2',
                'message'   => $userDetails->name.' '.$userDetails->surname."', errore durante la cancellazione del contenuto ".$this->rawPost['nome'].' Messaggio: '.$errorMessage,
                'type'      => 'error',
                'backend'   => 1,
            ));

            return $this->setErrorMessage($errorMessage);
        }
    }
}
