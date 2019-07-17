<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="articles", uniqueConstraints={@ORM\UniqueConstraint(name="slug", columns={"slug"})}, indexes={@ORM\Index(name="publish_date", columns={"publish_date"}), @ORM\Index(name="published", columns={"published", "is_delete"})})
 * @ORM\Entity
 */
class Articles
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title = '';

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
     */
    private $seoTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="string", length=255, nullable=true)
     */
    private $seoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keyword", type="string", length=255, nullable=true)
     */
    private $seoKeyword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_date", type="datetime", nullable=false)
     */
    private $publishDate = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="is_comment", type="string", nullable=false)
     */
    private $isComment = 'yes';

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="string", length=255, nullable=true)
     */
    private $images;

    /**
     * @var string
     *
     * @ORM\Column(name="categories", type="string", length=255, nullable=true)
     */
    private $categories;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=100, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @var integer
     *
     * @ORM\Column(name="precedence", type="integer", nullable=true)
     */
    private $precedence = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="user_ip", type="string", length=40, nullable=true)
     */
    private $userIp = '0.0.0.0';

    /**
     * @var integer
     *
     * @ORM\Column(name="counter_view", type="integer", nullable=true)
     */
    private $counterView = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="counter_comment", type="integer", nullable=true)
     */
    private $counterComment = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="counter_like", type="integer", nullable=true)
     */
    private $counterLike = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="published", type="string", nullable=false)
     */
    private $published = 'yes';

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=30, nullable=true)
     */
    private $language = 'vn';

    /**
     * @var string
     *
     * @ORM\Column(name="is_delete", type="string", nullable=false)
     */
    private $isDelete = 'no';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ctime", type="datetime", nullable=false)
     */
    private $ctime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mtime", type="datetime", nullable=false)
     */
    private $mtime = 'CURRENT_TIMESTAMP';


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
     * Set title
     *
     * @param string $title
     *
     * @return Articles
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Articles
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Articles
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Articles
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return Articles
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription
     *
     * @return Articles
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Set seoKeyword
     *
     * @param string $seoKeyword
     *
     * @return Articles
     */
    public function setSeoKeyword($seoKeyword)
    {
        $this->seoKeyword = $seoKeyword;

        return $this;
    }

    /**
     * Get seoKeyword
     *
     * @return string
     */
    public function getSeoKeyword()
    {
        return $this->seoKeyword;
    }

    /**
     * Set publishDate
     *
     * @param \DateTime $publishDate
     *
     * @return Articles
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set isComment
     *
     * @param string $isComment
     *
     * @return Articles
     */
    public function setIsComment($isComment)
    {
        $this->isComment = $isComment;

        return $this;
    }

    /**
     * Get isComment
     *
     * @return string
     */
    public function getIsComment()
    {
        return $this->isComment;
    }

    /**
     * Set images
     *
     * @param string $images
     *
     * @return Articles
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set categories
     *
     * @param string $categories
     *
     * @return Articles
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return string
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Articles
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Articles
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return Articles
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set precedence
     *
     * @param integer $precedence
     *
     * @return Articles
     */
    public function setPrecedence($precedence)
    {
        $this->precedence = $precedence;

        return $this;
    }

    /**
     * Get precedence
     *
     * @return integer
     */
    public function getPrecedence()
    {
        return $this->precedence;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Articles
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userIp
     *
     * @param string $userIp
     *
     * @return Articles
     */
    public function setUserIp($userIp)
    {
        $this->userIp = $userIp;

        return $this;
    }

    /**
     * Get userIp
     *
     * @return string
     */
    public function getUserIp()
    {
        return $this->userIp;
    }

    /**
     * Set counterView
     *
     * @param integer $counterView
     *
     * @return Articles
     */
    public function setCounterView($counterView)
    {
        $this->counterView = $counterView;

        return $this;
    }

    /**
     * Get counterView
     *
     * @return integer
     */
    public function getCounterView()
    {
        return $this->counterView;
    }

    /**
     * Set counterComment
     *
     * @param integer $counterComment
     *
     * @return Articles
     */
    public function setCounterComment($counterComment)
    {
        $this->counterComment = $counterComment;

        return $this;
    }

    /**
     * Get counterComment
     *
     * @return integer
     */
    public function getCounterComment()
    {
        return $this->counterComment;
    }

    /**
     * Set counterLike
     *
     * @param integer $counterLike
     *
     * @return Articles
     */
    public function setCounterLike($counterLike)
    {
        $this->counterLike = $counterLike;

        return $this;
    }

    /**
     * Get counterLike
     *
     * @return integer
     */
    public function getCounterLike()
    {
        return $this->counterLike;
    }

    /**
     * Set published
     *
     * @param string $published
     *
     * @return Articles
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return string
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Articles
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isDelete
     *
     * @param string $isDelete
     *
     * @return Articles
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return string
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set ctime
     *
     * @param \DateTime $ctime
     *
     * @return Articles
     */
    public function setCtime($ctime)
    {
        $this->ctime = $ctime;

        return $this;
    }

    /**
     * Get ctime
     *
     * @return \DateTime
     */
    public function getCtime()
    {
        return $this->ctime;
    }

    /**
     * Set mtime
     *
     * @param \DateTime $mtime
     *
     * @return Articles
     */
    public function setMtime($mtime)
    {
        $this->mtime = $mtime;

        return $this;
    }

    /**
     * Get mtime
     *
     * @return \DateTime
     */
    public function getMtime()
    {
        return $this->mtime;
    }
}

