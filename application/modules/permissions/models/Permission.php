<?php

namespace permissions\models;

/**
 * @Entity
 * @Table(name="permissions")
 */
class Permission
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
     * @Column(name="name", type="string", length=50, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @Column(name="description", type="text", length=100, nullable=true)
     */
    private $description = '';

    /**
     * @var string
     *
     * @Column(name="published", type="string", nullable=false)
     */
    private $published = 'yes';



    /**
     * Constructor
     */
    public function __construct()
    {


    }

    public function id($value = NULL)
    {
        if (empty($value))
            return $this->id;
        else
            $this->id = $value;
    }
				
    public function name($value = NULL)
    {
        if (empty($value))
            return $this->name;
        else
            $this->name = $value;
    }

    public function description($value = NULL)
    {
        if (empty($value))
            return $this->description;
        else
            $this->description = $value;
    }

    public function published($value = NULL)
    {
        if (empty($value))
            return $this->published;
        else
            $this->published = $value;
    }
}
