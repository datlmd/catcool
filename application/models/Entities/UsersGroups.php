<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * UsersGroups
 *
 * @ORM\Table(name="users_groups", uniqueConstraints={@ORM\UniqueConstraint(name="uc_users_groups", columns={"user_id", "group_id"})}, indexes={@ORM\Index(name="fk_users_groups_users1_idx", columns={"user_id"}), @ORM\Index(name="fk_users_groups_groups1_idx", columns={"group_id"})})
 * @ORM\Entity
 */
class UsersGroups
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
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     * })
     */
    private $group;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


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
     * Set group
     *
     * @param \Groups $group
     *
     * @return UsersGroups
     */
    public function setGroup(\Groups $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Groups
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set user
     *
     * @param \Users $user
     *
     * @return UsersGroups
     */
    public function setUser(\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Users
     */
    public function getUser()
    {
        return $this->user;
    }
}

