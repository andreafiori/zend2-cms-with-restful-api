<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeoProvince
 *
 * @ORM\Table(name="geo_province", indexes={@ORM\Index(name="searchprovince", columns={"cod_regione", "cod_provincia"})})
 * @ORM\Entity
 */
class GeoProvince
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
     * @var string
     *
     * @ORM\Column(name="cod_regione", type="string", length=14, nullable=true)
     */
    private $codRegione;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_provincia", type="string", length=16, nullable=true)
     */
    private $codProvincia;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=28, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sigla", type="string", length=21, nullable=true)
     */
    private $sigla;

    /**
     * @var string
     *
     * @ORM\Column(name="capoluogo", type="string", nullable=true)
     */
    private $capoluogo = 'no';



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
     * Set codRegione
     *
     * @param string $codRegione
     * @return GeoProvince
     */
    public function setCodRegione($codRegione)
    {
        $this->codRegione = $codRegione;

        return $this;
    }

    /**
     * Get codRegione
     *
     * @return string 
     */
    public function getCodRegione()
    {
        return $this->codRegione;
    }

    /**
     * Set codProvincia
     *
     * @param string $codProvincia
     * @return GeoProvince
     */
    public function setCodProvincia($codProvincia)
    {
        $this->codProvincia = $codProvincia;

        return $this;
    }

    /**
     * Get codProvincia
     *
     * @return string 
     */
    public function getCodProvincia()
    {
        return $this->codProvincia;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return GeoProvince
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return GeoProvince
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;

        return $this;
    }

    /**
     * Get sigla
     *
     * @return string 
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set capoluogo
     *
     * @param string $capoluogo
     * @return GeoProvince
     */
    public function setCapoluogo($capoluogo)
    {
        $this->capoluogo = $capoluogo;

        return $this;
    }

    /**
     * Get capoluogo
     *
     * @return string 
     */
    public function getCapoluogo()
    {
        return $this->capoluogo;
    }
}
