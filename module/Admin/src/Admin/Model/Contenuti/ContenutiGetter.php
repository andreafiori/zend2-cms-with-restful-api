<?php

namespace Admin\Model\Contenuti;

use Application\Model\QueryBuilderHelperAbstract;

/**
 * @author Andrea Fiori
 * @since  11 January 2015
 */
class ContenutiGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields("contenuti.id, contenuti.anno, contenuti.numero, 
            contenuti.titolo, contenuti.sommario, contenuti.testo, 
            contenuti.dataInserimento, contenuti.dataScadenza,
                                
            contenuti.attivo, contenuti.home, 

            sezione.nome AS nomeSezione,

            sottosezione.nome AS nomeSottosezione,
            
            u.name, u.surname
            
            ");

        $this->getQueryBuilder()->select($this->getSelectQueryFields())
                                ->from('Application\Entity\ZfcmsComuniContenuti', 'contenuti')
                                ->join('contenuti.sottosezione', 'sottosezione')
                                ->join('contenuti.utente', 'u')
                                ->join('sottosezione.sezione', 'sezione')
                                ->join('sezione.modulo', 'modulo')
                                ->where('( contenuti.sottosezione = sottosezione.id AND contenuti.utente = u.id AND sottosezione.sezione = sezione.id AND sezione.modulo = modulo.id) ');

        return $this->getQueryBuilder();
    }
    
    /**
     * @param number|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('contenuti.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('contenuti.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        return $this->getQueryBuilder();
    }
    
    public function setSottosezione($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('contenuti.sottosezione = :sottosezione ');
            $this->getQueryBuilder()->setParameter('sottosezione', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('contenuti.sottosezione IN ( :sottosezione ) ');
            $this->getQueryBuilder()->setParameter('sottosezione', $id);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * @param int $id
     */
    public function setNumero($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('contenuti.numero = :numero ');
            $this->getQueryBuilder()->setParameter('numero', $id);
        }
    }
    
    /**
     * @param int $anno
     */
    public function setAnno($anno)
    {
        if ( is_numeric($anno) ) {
            $this->getQueryBuilder()->andWhere('contenuti.anno = :anno ');
            $this->getQueryBuilder()->setParameter('anno', $anno);
        }
    }
    
    /**
     * @param date $dataScadenza
     */
    public function setDataScadenza($dataScadenza)
    {
        if ( isset($dataScadenza) ) {
            $this->getQueryBuilder()->andWhere('contenuti.dataScadenza = :scadenza ');
            $this->getQueryBuilder()->setParameter('scadenza', $dataScadenza);
        }
    }
}
