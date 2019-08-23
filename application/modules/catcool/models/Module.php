<?php

namespace catcool\models;

/**
 * @Entity
 * @Table(name="modules")
 */
class Module
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="module", type="string", length=100, nullable=false)
     */
    private $module;

    /**
     * @var string
     *
     * @Column(name="sub_module", type="text", length=100, nullable=true)
     */
    private $sub_module;

    /**
     * @var integer
     *
     * @Column(name="user_id", type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @var string
     *
     * @Column(name="published", type="string", nullable=false)
     */
    private $published = 'yes';

    /**
     * @var \DateTime
     *
     * @Column(name="ctime", type="datetime", nullable=false,  options={"default"="0000-00-00 00:00:00"})
     */
    private $ctime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @Column(name="mtime", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $mtime = 'CURRENT_TIMESTAMP';


    /**
     * Constructor
     */
    public function __construct()
    {
       $this->ctime = new \DateTime("now");
       $this->mtime = new \DateTime("now");
    }

    public function id($value = NULL)
    {
        if (empty($value))
            return $this->id;
        else
            $this->id = $value;
    }
				
    public function module($value = NULL)
    {
        if (empty($value))
            return $this->module;
        else
            $this->module = $value;
    }

    public function sub_module($value = NULL)
    {
        if (empty($value))
            return $this->sub_module;
        else
            $this->sub_module = $value;
    }

    public function user_id($value = NULL)
    {
        if (empty($value))
            return $this->user_id;
        else
            $this->user_id = $value;
    }

    public function published($value = NULL)
    {
        if (empty($value))
            return $this->published;
        else
            $this->published = $value;
    }

    public function ctime($value = NULL)
    {
        if (empty($value))
            return $this->ctime;
        else
            $this->ctime = $value;
    }

    public function mtime($value = NULL)
    {
        if (empty($value))
            return $this->mtime;
        else
            $this->mtime = $value;
    }
}
