<?php

namespace Agere\Module\Model;

/**
 * Module
 */
class Module
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $mnemo;

    /**
     * @var string
     */
    private $hidden;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $mnemo
     */
    public function setMnemo($mnemo)
    {
        $this->mnemo = $mnemo;
    }

    /**
     * @return string
     */
    public function getMnemo()
    {
        return $this->mnemo;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return string
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}

