<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductsShippingCap
 *
 * @ORM\Table(name="products_shipping_cap", indexes={@ORM\Index(name="geocap_id", columns={"geocap_id"}), @ORM\Index(name="usercompany_id", columns={"usercompany_id"})})
 * @ORM\Entity
 */
class ProductsShippingCap
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="geocap_id", type="bigint", nullable=false)
     */
    private $geocapId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="usercompany_id", type="bigint", nullable=false)
     */
    private $usercompanyId = '0';



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set geocapId
     *
     * @param integer $geocapId
     * @return ProductsShippingCap
     */
    public function setGeocapId($geocapId)
    {
        $this->geocapId = $geocapId;

        return $this;
    }

    /**
     * Get geocapId
     *
     * @return integer 
     */
    public function getGeocapId()
    {
        return $this->geocapId;
    }

    /**
     * Set usercompanyId
     *
     * @param integer $usercompanyId
     * @return ProductsShippingCap
     */
    public function setUsercompanyId($usercompanyId)
    {
        $this->usercompanyId = $usercompanyId;

        return $this;
    }

    /**
     * Get usercompanyId
     *
     * @return integer 
     */
    public function getUsercompanyId()
    {
        return $this->usercompanyId;
    }
}
