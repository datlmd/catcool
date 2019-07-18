<?php

namespace articles\models;

/**
 * @Entity
 * @Table(name="articles")
 */
class Article
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
    private $slug = '';

    /**
     * @var string
     *
     * @Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description = '';

    /**
     * @var string
     *
     * @Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @Column(name="seo_title", type="string", length=255, nullable=true)
     */
    private $seo_title;

    /**
     * @var string
     *
     * @Column(name="seo_description", type="string", length=255, nullable=true)
     */
    private $seo_description;

    /**
     * @var string
     *
     * @Column(name="seo_keyword", type="string", length=255, nullable=true)
     */
    private $seo_keyword;

    /**
     * @var \DateTime
     *
     * @Column(name="publish_date", type="datetime", nullable=false)
     */
    private $publish_date = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @Column(name="is_comment", type="string", nullable=false)
     */
    private $is_comment = 'yes';

    /**
     * @var string
     *
     * @Column(name="images", type="string", length=255, nullable=true)
     */
    private $images;

    /**
     * @var string
     *
     * @Column(name="categories", type="string", length=255, nullable=true)
     */
    private $categories;

    /**
     * @var string
     *
     * @Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @Column(name="author", type="string", length=100, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @var integer
     *
     * @Column(name="user_id", type="integer", nullable=false)
     */
    private $user_id = '0';

    /**
     * @var string
     *
     * @Column(name="user_ip", type="string", length=40, nullable=true)
     */
    private $user_ip = '0.0.0.0';

    /**
     * @var integer
     *
     * @Column(name="counter_view", type="integer", nullable=true)
     */
    private $counter_view = '0';

    /**
     * @var integer
     *
     * @Column(name="counter_comment", type="integer", nullable=true)
     */
    private $counter_comment = '0';

    /**
     * @var integer
     *
     * @Column(name="counter_like", type="integer", nullable=true)
     */
    private $counter_like = '0';

    /**
     * @var string
     *
     * @Column(name="is_delete", type="string", nullable=false)
     */
    private $is_delete = 'no';

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
        if (empty($value))
            return $this->id;
        else
            $this->id = $value;
    }
				
    public function title($value = NULL)
    {
        if (empty($value))
            return $this->title;
        else
            $this->title = $value;
    }

    public function slug($value = NULL)
    {
        if (empty($value))
            return $this->slug;
        else
            $this->slug = $value;
    }

    public function description($value = NULL)
    {
        if (empty($value))
            return $this->description;
        else
            $this->description = $value;
    }

    public function content($value = NULL)
    {
        if (empty($value))
            return $this->content;
        else
            $this->content = $value;
    }

    public function seo_title($value = NULL)
    {
        if (empty($value))
            return $this->seo_title;
        else
            $this->seo_title = $value;
    }

    public function seo_description($value = NULL)
    {
        if (empty($value))
            return $this->seo_description;
        else
            $this->seo_description = $value;
    }

    public function seo_keyword($value = NULL)
    {
        if (empty($value))
            return $this->seo_keyword;
        else
            $this->seo_keyword = $value;
    }

    public function publish_date($value = NULL)
    {
        if (empty($value))
            return $this->publish_date;
        else
            $this->publish_date = $value;
    }

    public function is_comment($value = NULL)
    {
        if (empty($value))
            return $this->is_comment;
        else
            $this->is_comment = $value;
    }

    public function images($value = NULL)
    {
        if (empty($value))
            return $this->images;
        else
            $this->images = $value;
    }

    public function categories($value = NULL)
    {
        if (empty($value))
            return $this->categories;
        else
            $this->categories = $value;
    }

    public function author($value = NULL)
    {
        if (empty($value))
            return $this->author;
        else
            $this->author = $value;
    }

    public function source($value = NULL)
    {
        if (empty($value))
            return $this->source;
        else
            $this->source = $value;
    }

    public function user_id($value = NULL)
    {
        if (empty($value))
            return $this->user_id;
        else
            $this->user_id = $value;
    }

    public function tags($value = NULL)
    {
        if (empty($value))
            return $this->tags;
        else
            $this->tags = $value;
    }

    public function user_ip($value = NULL)
    {
        if (empty($value))
            return $this->user_ip;
        else
            $this->user_ip = $value;
    }

    public function counter_view($value = NULL)
    {
        if (empty($value))
            return $this->counter_view;
        else
            $this->counter_view = $value;
    }

    public function counter_comment($value = NULL)
    {
        if (empty($value))
            return $this->counter_comment;
        else
            $this->counter_comment = $value;
    }

    public function counter_like($value = NULL)
    {
        if (empty($value))
            return $this->counter_like;
        else
            $this->counter_like = $value;
    }

    public function is_delete($value = NULL)
    {
        if (empty($value))
            return $this->is_delete;
        else
            $this->is_delete = $value;
    }

    public function language($value = NULL)
    {
        if (empty($value))
            return $this->language;
        else
            $this->language = $value;
    }

    public function precedence($value = NULL)
    {
        if (empty($value))
            return $this->precedence;
        else
            $this->precedence = $value;
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
