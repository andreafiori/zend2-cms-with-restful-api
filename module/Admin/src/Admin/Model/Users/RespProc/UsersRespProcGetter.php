<?php

namespace Admin\Model\Users\RespProc;

use Application\Model\QueryBuilderHelperAbstract;

/**
 * @author Andrea Fiori
 * @since  26 March 2015
 */
class UsersRespProcGetter extends QueryBuilderHelperAbstract
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setMainQuery()
    {
        $this->setSelectQueryFields('respProc.id,

                                    u.name, u.surname,

                                    settore.nome AS nomeSettore
                                    ');

        $this->getQueryBuilder()->select( $this->getSelectQueryFields() )
                                ->from('Application\Entity\ZfcmsUsersRespProc', 'respProc')
                                ->join('respProc.user', 'u')
                                ->join('u.settore', 'settore')
                                ->where("respProc.id != 0 ");

        return $this->getQueryBuilder();
    }

    /**
     * @param number|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('respProc.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }

        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('respProc.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }

        return $this->getQueryBuilder();
    }
}