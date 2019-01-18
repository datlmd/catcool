<?php

namespace entities;
use Doctrine\ORM\Mapping as ORM;
/**
 * User
 *
 * @Table(name="user")
 * @Entity
 */
class User
{
    /**
     * @var integer
     *
     * @Column(name="id", type="bigint", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;
    /**
     * @var string
     *
     * @Column(name="email", type="string", length=150, nullable=false)
     */
    private $email;
    /**
     * @var string
     *
     * @Column(name="password", type="string", length=40, nullable=true)
     */
    private $password;
    /**
     * @var string
     *
     * @Column(name="first_name", type="string", length=100, nullable=false)
     */
    private $firstName;
    /**
     * @var string
     *
     * @Column(name="last_name", type="string", length=100, nullable=true)
     */
    private $lastName;
    /**
     * @var string
     *
     * @Column(name="mobile", type="string", length=15, nullable=true)
     */
    private $mobile;
    /**
     * @var string
     *
     * @Column(name="timezone", type="string", length=6, nullable=false)
     */
    private $timezone;
    /**
     * @var string
     *
     * @Column(name="validation_key", type="string", length=40, nullable=true)
     */
    private $validationKey;
    /**
     * @var string
     *
     * @Column(name="image_path", type="string", length=255, nullable=true)
     */
    private $imagePath;
    /**
     * @var string
     *
     * @Column(name="logo_path", type="string", length=500, nullable=true)
     */
    private $logoPath;
    /**
     * @var DateTime
     *
     * @Column(name="last_log_in", type="datetime", nullable=true)
     */
    private $lastLogIn;
    /**
     * @var string
     *
     * @Column(name="ip_address", type="string", length=15, nullable=true)
     */
    private $ipAddress;
    /**
     * @var string
     *
     * @Column(name="host", type="string", length=500, nullable=true)
     */
    private $host;
    /**
     * @var string
     *
     * @Column(name="phone", type="string", length=50, nullable=true)
     */
    private $phone;
    /**
     * @var string
     *
     * @Column(name="land_phone", type="string", length=50, nullable=true)
     */
    private $landPhone;
    /**
     * @var boolean
     *
     * @Column(name="is_active", type="boolean", nullable=false, options={"default":0})
     */
    private $isActive;
    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User")
     * @JoinColumns({
     *   @JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $parent;
    /**
     * @var UserType
     *
     * @ManyToOne(targetEntity="UserType")
     * @JoinColumns({
     *   @JoinColumn(name="user_type_id", referencedColumnName="id")
     * })
     */
    private $userType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isActive = 0;
        $this->lastLogIn = new \DateTime("now");
    }
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }
    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }
    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }
    /**
     * Set mobile
     *
     * @param string $mobile
     * @return User
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }
    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }
    /**
     * Set timezone
     *
     * @param string $timezone
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }
    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
    /**
     * Set validationKey
     *
     * @param string $validationKey
     * @return User
     */
    public function setValidationKey($validationKey)
    {
        $this->validationKey = $validationKey;

        return $this;
    }
    /**
     * Get validationKey
     *
     * @return string
     */
    public function getValidationKey()
    {
        return $this->validationKey;
    }
    /**
     * Set imagePath
     *
     * @param string $imagePath
     * @return User
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }
    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
    /**
     * Set logoPath
     *
     * @param string $logoPath
     * @return User
     */
    public function setLogoPath($logoPath)
    {
        $this->logoPath = $logoPath;

        return $this;
    }
    /**
     * Get logoPath
     *
     * @return string
     */
    public function getLogoPath()
    {
        return $this->logoPath;
    }
    /**
     * Set lastLogIn
     *
     * @param DateTime $lastLogIn
     * @return User
     */
    public function setLastLogIn($lastLogIn)
    {
        $this->lastLogIn = $lastLogIn;

        return $this;
    }
    /**
     * Get lastLogIn
     *
     * @return DateTime
     */
    public function getLastLogIn()
    {
        return $this->lastLogIn;
    }
    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return User
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }
    /**
     * Set host
     *
     * @param string $host
     * @return User
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }
    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set landPhone
     *
     * @param string $landPhone
     * @return User
     */
    public function setLandPhone($landPhone)
    {
        $this->landPhone = $landPhone;

        return $this;
    }
    /**
     * Get landPhone
     *
     * @return string
     */
    public function getLandPhone()
    {
        return $this->landPhone;
    }
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
    /**
     * Set parent
     *
     * @param User $parent
     * @return User
     */
    public function setParent(User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }
    /**
     * Get parent
     *
     * @return User
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Set userType
     *
     * @param UserType $userType
     * @return User
     */
    public function setUserType(UserType $userType = null)
    {
        $this->userType = $userType;

        return $this;
    }
    /**
     * Get userType
     *
     * @return UserType
     */
    public function getUserType()
    {
        return $this->userType;
    }
}