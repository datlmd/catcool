<?php

namespace menus\models;

/**
 * @Entity
 * @Table(name="menus")
 */
class Menu
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
     * @Column(name="title", type="string", length=255, nullable=false)
     */
    private $title = '';

    /**
     * @var string
     *
     * @Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @Column(name="description", type="text", length=255, nullable=true)
     */
    private $description = '';

    /**
     * @var string
     *
     * @Column(name="context", type="string", length=100, nullable=false)
     */
    private $context;

    /**
     * @var integer
     *
     * @Column(name="parent_id", type="integer", nullable=false)
     */
    private $parent_id;

    /**
     * @var integer
     *
     * @Column(name="user_id", type="integer", nullable=false)
     */
    private $user_id;

    /**
     * @var string
     *
     * @Column(name="language", type="string", length=30, nullable=true)
     */
    private $language = 'vn';

    /**
     * @var integer
     *
     * @Column(name="precedence", type="integer", nullable=true)
     */
    private $precedence;

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
        if (is_null($value))
            return $this->id;
        else
            $this->id = $value;
    }
				
    public function title($value = NULL)
    {
        if (is_null($value))
            return $this->title;
        else
            $this->title = $value;
    }

    public function slug($value = NULL)
    {
        if (is_null($value))
            return $this->slug;
        else
            $this->slug = $value;
    }

    public function description($value = NULL)
    {
        if (is_null($value))
            return $this->description;
        else
            $this->description = $value;
    }

    public function context($value = NULL)
    {
        if (is_null($value))
            return $this->context;
        else
            $this->context = $value;
    }

    public function language($value = NULL)
    {
        if (is_null($value))
            return $this->language;
        else
            $this->language = $value;
    }

    public function parent_id($value = NULL)
    {
        if (is_null($value))
            return $this->parent_id;
        else
            $this->parent_id = $value;
    }

    public function user_id($value = NULL)
    {
        if (is_null($value))
            return $this->user_id;
        else
            $this->user_id = $value;
    }

    public function precedence($value = NULL)
    {
        if (is_null($value))
            return $this->precedence;
        else
            $this->precedence = $value;
    }

    public function published($value = NULL)
    {
        if (is_null($value))
            return $this->published;
        else
            $this->published = $value;
    }

    public function ctime($value = NULL)
    {
        if (is_null($value))
            return $this->ctime;
        else
            $this->ctime = $value;
    }

    public function mtime($value = NULL)
    {
        if (is_null($value))
            return $this->mtime;
        else
            $this->mtime = $value;
    }
}