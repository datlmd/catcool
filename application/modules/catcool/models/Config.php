<?php

namespace catcool\models;

/**
 * @Entity
 * @Table(name="configs")
 */
class Config
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
     * @Column(name="config_key", type="string", length=255, nullable=false)
     */
    private $config_key;

    /**
     * @var string
     *
     * @Column(name="config_value", type="string", length=255, nullable=false)
     */
    private $config_value;

    /**
     * @var string
     *
     * @Column(name="description", type="text", length=255, nullable=true)
     */
    private $description;

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

    public function description($value = NULL)
    {
        if (empty($value))
            return $this->description;
        else
            $this->description = $value;
    }

    public function config_key($value = NULL)
    {
        if (empty($value))
            return $this->config_key;
        else
            $this->config_key = $value;
    }

    public function config_value($value = NULL)
    {
        if (empty($value))
            return $this->config_value;
        else
            $this->config_value = $value;
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
