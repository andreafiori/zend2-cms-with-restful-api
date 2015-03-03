<?php

namespace Admin\Model\Sezioni;

use Application\Model\QueryBuilderHelperAbstract;

/**
 * @author Andrea Fiori
 * @since  10 January 2015
 */
class SottoSezioniGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields("sottosezioni.id AS idSottosezione, IDENTITY(sottosezioni.sezione) AS sezione,
            sottosezioni.nome AS nomeSottosezione, sottosezioni.immagine, sezioni.id AS idSezione, sezioni.nome AS nomeSezione,
            sottosezioni.profonditaDa, sottosezioni.profonditaA, sottosezioni.url, sottosezioni.attivo,
            sottosezioni.url, sottosezioni.urlTitle, sottosezioni.posizione
        ");

        $this->getQueryBuilder()->select($this->getSelectQueryFields())
                                ->from('Application\Entity\ZfcmsComuniSottosezioni', 'sottosezioni')
                                ->join('sottosezioni.sezione', 'sezioni')
                                ->join('sezioni.modulo', 'modulo')
                                ->where("sottosezioni.sezione = sezioni.id ");

        return $this->getQueryBuilder();
    }
    
    /**
     * @param number|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('sottosezioni.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('sottosezioni.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        return $this->getQueryBuilder();
    }

    /**
     * @param string $slug
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setSlug($slug)
    {
        if ( isset($slug) ) {
            $this->getQueryBuilder()->andWhere('sottosezioni.slug = :slug ');
            $this->getQueryBuilder()->setParameter('slug', $slug);
        }

        return $this->getQueryBuilder();
    }
    
    /**
     * @param int $sezioneId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setSezioneId($sezioneId)
    {
        if (is_numeric($sezioneId) ) {
            $this->getQueryBuilder()->andWhere('sottosezioni.sezione = :sezioneId ');
            $this->getQueryBuilder()->setParameter('sezioneId', $sezioneId);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param int $isSottoSezione
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setIsSs($isSottoSezione)
    {
        if (is_numeric($isSottoSezione) ) {
            $this->getQueryBuilder()->andWhere('sottosezioni.isSs = :isSs ');
            $this->getQueryBuilder()->setParameter('isSs', $isSottoSezione);
        }

        return $this->getQueryBuilder();
    }
    
    /**    
     * @param int $profonditaDa
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setProfonditaDa($profonditaDa)
    {
        if (is_numeric($profonditaDa) ) {
            $this->getQueryBuilder()->andWhere('sottosezioni.profonditaDa = :profonditaDa ');
            $this->getQueryBuilder()->setParameter('profonditaDa', $profonditaDa);
        }

        return $this->getQueryBuilder();
    }

    /**    
     * @param int $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setModulo($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('sezioni.modulo = :moduloId ');
            $this->getQueryBuilder()->setParameter('moduloId', $id);
        }
        
        return $this->getQueryBuilder();
    }

    /**
     * @param int $attivo
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setAttivo($attivo)
    {
        if ( is_numeric($attivo) ) {
            $this->getQueryBuilder()->andWhere('sottosezioni.attivo = :attivo ');
            $this->getQueryBuilder()->setParameter('attivo', $attivo);
        }

        return $this->getQueryBuilder();
    }
}