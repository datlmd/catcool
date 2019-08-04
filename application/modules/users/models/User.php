<?php

namespace users\models;

/**
 * @Entity
 * @Table(name="users")
 */
class User
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
     * @Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @Column(name="password", type="text", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=254, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="activation_selector", type="string", length=255, nullable=true)
     */
    private $activation_selector;

    /**
     * @var string
     *
     * @Column(name="activation_code", type="string", length=255, nullable=true)
     */
    private $activation_code;

    /**
     * @var string
     *
     * @Column(name="forgotten_password_selector", type="string", length=255, nullable=true)
     */
    private $forgotten_password_selector;

    /**
     * @var string
     *
     * @Column(name="forgotten_password_code", type="string", length=255, nullable=true)
     */
    private $forgotten_password_code;


    /**
     * @var integer
     *
     * @Column(name="forgotten_password_time", type="integer", nullable=true)
     */
    private $forgotten_password_time;

    /**
     * @var string
     *
     * @Column(name="remember_selector", type="string", length=255, nullable=true)
     */
    private $remember_selector;

    /**
     * @var string
     *
     * @Column(name="remember_code", type="string", length=255, nullable=true)
     */
    private $remember_code;

    /**
     * @var integer
     *
     * @Column(name="created_on", type="integer", nullable=true)
     */
    private $created_on;

    /**
     * @var integer
     *
     * @Column(name="last_login", type="integer", nullable=true)
     */
    private $last_login;

    /**
     * @var boolean
     *
     * @Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @Column(name="first_name", type="string", length=50, nullable=true)
     */
    private $first_name;

    /**
     * @var string
     *
     * @Column(name="last_name", type="string", length=50, nullable=true)
     */
    private $last_name;

    /**
     * @var string
     *
     * @Column(name="company", type="string", length=100, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var boolean
     *
     * @Column(name="gender", type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var boolean
     *
     * @Column(name="super_admin", type="boolean", nullable=true)
     */
    private $super_admin;

    /**
     * @var boolean
     *
     * @Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @Column(name="is_delete", type="string", nullable=false)
     */
    private $is_delete = 'no';

    /**
     * @var string
     *
     * @Column(name="ip_address", type="string", length=45, nullable=true)
     */
    private $ip_address;

    /**
     * @var string
     *
     * @Column(name="language", type="string", length=30, nullable=true)
     */
    private $language = 'vn';

    /**
     * @var \DateTime
     *
     * @Column(name="ctime", type="datetime", nullable=false,  options={"default"="0000-00-00 00:00:00"})
     */
    private $ctime;

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
				
    public function username($value = NULL)
    {
        if (empty($value))
            return $this->username;
        else
            $this->username = $value;
    }

    public function password($value = NULL)
    {
        if (empty($value))
            return $this->password;
        else
            $this->password = $value;
    }

    public function email($value = NULL)
    {
        if (empty($value))
            return $this->email;
        else
            $this->email = $value;
    }

    public function activation_selector($value = NULL)
    {
        if (empty($value))
            return $this->activation_selector;
        else
            $this->activation_selector = $value;
    }

    public function activation_code($value = NULL)
    {
        if (empty($value))
            return $this->activation_code;
        else
            $this->activation_code = $value;
    }

    public function forgotten_password_selector($value = NULL)
    {
        if (empty($value))
            return $this->forgotten_password_selector;
        else
            $this->forgotten_password_selector = $value;
    }

    public function forgotten_password_code($value = NULL)
    {
        if (empty($value))
            return $this->forgotten_password_code;
        else
            $this->forgotten_password_code = $value;
    }

    public function forgotten_password_time($value = NULL)
    {
        if (empty($value))
            return $this->forgotten_password_time;
        else
            $this->forgotten_password_time = $value;
    }

    public function remember_selector($value = NULL)
    {
        if (empty($value))
            return $this->remember_selector;
        else
            $this->remember_selector = $value;
    }

    public function remember_code($value = NULL)
    {
        if (empty($value))
            return $this->remember_code;
        else
            $this->remember_code = $value;
    }

    public function created_on($value = NULL)
    {
        if (empty($value))
            return $this->created_on;
        else
            $this->created_on = $value;
    }

    public function last_login($value = NULL)
    {
        if (empty($value))
            return $this->last_login;
        else
            $this->last_login = $value;
    }

    public function active($value = NULL)
    {
        if (empty($value))
            return $this->active;
        else
            $this->active = $value;
    }

    public function first_name($value = NULL)
    {
        if (empty($value))
            return $this->first_name;
        else
            $this->first_name = $value;
    }

    public function last_name($value = NULL)
    {
        if (empty($value))
            return $this->last_name;
        else
            $this->last_name = $value;
    }

    public function company($value = NULL)
    {
        if (empty($value))
            return $this->company;
        else
            $this->company = $value;
    }

    public function phone($value = NULL)
    {
        if (empty($value))
            return $this->phone;
        else
            $this->phone = $value;
    }

    public function address($value = NULL)
    {
        if (empty($value))
            return $this->address;
        else
            $this->address = $value;
    }

    public function dob($value = NULL)
    {
        if (empty($value))
            return $this->dob;
        else
            $this->dob = $value;
    }

    public function gender($value = NULL)
    {
        if (empty($value))
            return $this->gender;
        else
            $this->gender = $value;
    }

    public function image($value = NULL)
    {
        if (empty($value))
            return $this->image;
        else
            $this->image = $value;
    }

    public function super_admin($value = NULL)
    {
        if (empty($value))
            return $this->super_admin;
        else
            $this->super_admin = $value;
    }

    public function status($value = NULL)
    {
        if (empty($value))
            return $this->status;
        else
            $this->status = $value;
    }

    public function is_delete($value = NULL)
    {
        if (empty($value))
            return $this->is_delete;
        else
            $this->is_delete = $value;
    }

    public function ip_address($value = NULL)
    {
        if (empty($value))
            return $this->ip_address;
        else
            $this->ip_address = $value;
    }

    public function language($value = NULL)
    {
        if (empty($value))
            return $this->language;
        else
            $this->language = $value;
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
