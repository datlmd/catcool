<?php


namespace entities;
/**
 * UserType
 *
 * @Table(name="user_type")
 * @Entity
 */
class UserType
{
    /**
     * @var integer
     *
     * @Column(name="id", type="smallint", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @Column(name="type_name", type="string", length=150, nullable=false)
     */
    private $typeName;

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
     * Set typeName
     *
     * @param string $typeName
     * @return UserType
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }
    /**
     * Get typeName
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }
}