<?php

namespace relationships\models;

/**
 * @Entity
 * @Table(name="relationships")
 */
class Relationship
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
     * @Column(name="candidate_table", type="string", length=100, nullable=false)
     */
    private $candidate_table;

    /**
     * @var integer
     *
     * @Column(name="candidate_key", type="integer", nullable=false)
     */
    private $candidate_key;

    /**
     * @var string
     *
     * @Column(name="foreign_table", type="text", length=65535, nullable=false)
     */
    private $foreign_table;

    /**
     * @var integer
     *
     * @Column(name="foreign_key", type="integer", nullable=false)
     */
    private $foreign_key;


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
				
    public function candidate_table($value = NULL)
    {
        if (empty($value))
            return $this->candidate_table;
        else
            $this->candidate_table = $value;
    }

    public function candidate_key($value = NULL)
    {
        if (empty($value))
            return $this->candidate_key;
        else
            $this->candidate_key = $value;
    }

    public function foreign_table($value = NULL)
    {
        if (empty($value))
            return $this->foreign_table;
        else
            $this->foreign_table = $value;
    }

    public function foreign_key($value = NULL)
    {
        if (empty($value))
            return $this->foreign_key;
        else
            $this->foreign_key = $value;
    }
}
