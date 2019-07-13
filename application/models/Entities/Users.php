<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="uc_email", columns={"email"}), @ORM\UniqueConstraint(name="uc_activation_selector", columns={"activation_selector"}), @ORM\UniqueConstraint(name="uc_forgotten_password_selector", columns={"forgotten_password_selector"}), @ORM\UniqueConstraint(name="uc_remember_selector", columns={"remember_selector"})})
 * @ORM\Entity
 */
class Users
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
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=45, nullable=false)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_selector", type="string", length=255, nullable=true)
     */
    private $activationSelector;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_code", type="string", length=255, nullable=true)
     */
    private $activationCode;

    /**
     * @var string
     *
     * @ORM\Column(name="forgotten_password_selector", type="string", length=255, nullable=true)
     */
    private $forgottenPasswordSelector;

    /**
     * @var string
     *
     * @ORM\Column(name="forgotten_password_code", type="string", length=255, nullable=true)
     */
    private $forgottenPasswordCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="forgotten_password_time", type="integer", nullable=true)
     */
    private $forgottenPasswordTime;

    /**
     * @var string
     *
     * @ORM\Column(name="remember_selector", type="string", length=255, nullable=true)
     */
    private $rememberSelector;

    /**
     * @var string
     *
     * @ORM\Column(name="remember_code", type="string", length=255, nullable=true)
     */
    private $rememberCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_on", type="integer", nullable=false)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_login", type="integer", nullable=true)
     */
    private $lastLogin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=100, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;


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
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Users
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
     * Set username
     *
     * @param string $username
     *
     * @return Users
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
     * Set password
     *
     * @param string $password
     *
     * @return Users
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
     * Set email
     *
     * @param string $email
     *
     * @return Users
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
     * Set activationSelector
     *
     * @param string $activationSelector
     *
     * @return Users
     */
    public function setActivationSelector($activationSelector)
    {
        $this->activationSelector = $activationSelector;

        return $this;
    }

    /**
     * Get activationSelector
     *
     * @return string
     */
    public function getActivationSelector()
    {
        return $this->activationSelector;
    }

    /**
     * Set activationCode
     *
     * @param string $activationCode
     *
     * @return Users
     */
    public function setActivationCode($activationCode)
    {
        $this->activationCode = $activationCode;

        return $this;
    }

    /**
     * Get activationCode
     *
     * @return string
     */
    public function getActivationCode()
    {
        return $this->activationCode;
    }

    /**
     * Set forgottenPasswordSelector
     *
     * @param string $forgottenPasswordSelector
     *
     * @return Users
     */
    public function setForgottenPasswordSelector($forgottenPasswordSelector)
    {
        $this->forgottenPasswordSelector = $forgottenPasswordSelector;

        return $this;
    }

    /**
     * Get forgottenPasswordSelector
     *
     * @return string
     */
    public function getForgottenPasswordSelector()
    {
        return $this->forgottenPasswordSelector;
    }

    /**
     * Set forgottenPasswordCode
     *
     * @param string $forgottenPasswordCode
     *
     * @return Users
     */
    public function setForgottenPasswordCode($forgottenPasswordCode)
    {
        $this->forgottenPasswordCode = $forgottenPasswordCode;

        return $this;
    }

    /**
     * Get forgottenPasswordCode
     *
     * @return string
     */
    public function getForgottenPasswordCode()
    {
        return $this->forgottenPasswordCode;
    }

    /**
     * Set forgottenPasswordTime
     *
     * @param integer $forgottenPasswordTime
     *
     * @return Users
     */
    public function setForgottenPasswordTime($forgottenPasswordTime)
    {
        $this->forgottenPasswordTime = $forgottenPasswordTime;

        return $this;
    }

    /**
     * Get forgottenPasswordTime
     *
     * @return integer
     */
    public function getForgottenPasswordTime()
    {
        return $this->forgottenPasswordTime;
    }

    /**
     * Set rememberSelector
     *
     * @param string $rememberSelector
     *
     * @return Users
     */
    public function setRememberSelector($rememberSelector)
    {
        $this->rememberSelector = $rememberSelector;

        return $this;
    }

    /**
     * Get rememberSelector
     *
     * @return string
     */
    public function getRememberSelector()
    {
        return $this->rememberSelector;
    }

    /**
     * Set rememberCode
     *
     * @param string $rememberCode
     *
     * @return Users
     */
    public function setRememberCode($rememberCode)
    {
        $this->rememberCode = $rememberCode;

        return $this;
    }

    /**
     * Get rememberCode
     *
     * @return string
     */
    public function getRememberCode()
    {
        return $this->rememberCode;
    }

    /**
     * Set createdOn
     *
     * @param integer $createdOn
     *
     * @return Users
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return integer
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set lastLogin
     *
     * @param integer $lastLogin
     *
     * @return Users
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return integer
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Users
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Users
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
     *
     * @return Users
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
     * Set company
     *
     * @param string $company
     *
     * @return Users
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Users
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
}

