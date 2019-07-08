<?php

namespace categories\models;

/**
 * @Entity
 * @Table(name="categories")
 */
class Category {
	
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @Column(type="text")
     */
    private $description;

    /**
     * @Column(type="string", length=100, nullable=false)
     */
    private $context;

    /**
     * @Column(type="string", length=30, nullable=false)
     */
    private $language;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $precedence;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $parent_id;

    /**
     * @Column(type="boolean", options={"default"=1})
     */
    private $published;

    /**
     * @Column(type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $ctime;

    /**
     * @Column(name="mtime", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $mtime;


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

    public function precedence($value = NULL)
    {
        if (is_null($value))
            return $this->precedence;
        else
            $this->precedence = $value;
    }

    public function parent_id($value = NULL)
    {
        if (is_null($value))
            return $this->parent_id;
        else
            $this->parent_id = $value;
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
