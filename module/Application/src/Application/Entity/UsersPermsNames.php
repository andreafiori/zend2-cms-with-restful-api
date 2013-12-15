<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersPermsNames
 *
 * @ORM\Table(name="users_perms_names")
 * @ORM\Entity
 */
class UsersPermsNames
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomelabel", type="string", length=50, nullable=true)
     */
    private $nomelabel = '';

    /**
     * @var string
     *
     * @ORM\Column(name="nameperm", type="string", length=50, nullable=true)
     */
    private $nameperm = '';

    /**
     * @var string
     *
     * @ORM\Column(name="modulename", type="string", length=50, nullable=true)
     */
    private $modulename = '';

    /**
     * @var string
     *
     * @ORM\Column(name="moduletocheck", type="string", length=50, nullable=true)
     */
    private $moduletocheck = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="posizperm", type="integer", nullable=false)
     */
    private $posizperm;



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
     * Set nomelabel
     *
     * @param string $nomelabel
     * @return UsersPermsNames
     */
    public function setNomelabel($nomelabel)
    {
        $this->nomelabel = $nomelabel;

        return $this;
    }

    /**
     * Get nomelabel
     *
     * @return string 
     */
    public function getNomelabel()
    {
        return $this->nomelabel;
    }

    /**
     * Set nameperm
     *
     * @param string $nameperm
     * @return UsersPermsNames
     */
    public function setNameperm($nameperm)
    {
        $this->nameperm = $nameperm;

        return $this;
    }

    /**
     * Get nameperm
     *
     * @return string 
     */
    public function getNameperm()
    {
        return $this->nameperm;
    }

    /**
     * Set modulename
     *
     * @param string $modulename
     * @return UsersPermsNames
     */
    public function setModulename($modulename)
    {
        $this->modulename = $modulename;

        return $this;
    }

    /**
     * Get modulename
     *
     * @return string 
     */
    public function getModulename()
    {
        return $this->modulename;
    }

    /**
     * Set moduletocheck
     *
     * @param string $moduletocheck
     * @return UsersPermsNames
     */
    public function setModuletocheck($moduletocheck)
    {
        $this->moduletocheck = $moduletocheck;

        return $this;
    }

    /**
     * Get moduletocheck
     *
     * @return string 
     */
    public function getModuletocheck()
    {
        return $this->moduletocheck;
    }

    /**
     * Set posizperm
     *
     * @param integer $posizperm
     * @return UsersPermsNames
     */
    public function setPosizperm($posizperm)
    {
        $this->posizperm = $posizperm;

        return $this;
    }

    /**
     * Get posizperm
     *
     * @return integer 
     */
    public function getPosizperm()
    {
        return $this->posizperm;
    }
}
