<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Dummy
 *
 * @ORM\Table(name="dummy", uniqueConstraints={@ORM\UniqueConstraint(name="slug", columns={"slug"})})
 * @ORM\Entity
 */
class Dummy
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
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="context", type="string", length=100, nullable=true)
     */
    private $context = '';

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=30, nullable=true)
     */
    private $language = 'vn';

    /**
     * @var integer
     *
     * @ORM\Column(name="precedence", type="integer", nullable=true)
     */
    private $precedence;

    /**
     * @var string
     *
     * @ORM\Column(name="published", type="string", nullable=false)
     */
    private $published = 'yes';

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
     * @return Dummy
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
     * @return Dummy
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
     * @return Dummy
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
     * Set context
     *
     * @param string $context
     *
     * @return Dummy
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get context
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Dummy
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
     * Set precedence
     *
     * @param integer $precedence
     *
     * @return Dummy
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
     * Set published
     *
     * @param string $published
     *
     * @return Dummy
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
     * Set ctime
     *
     * @param \DateTime $ctime
     *
     * @return Dummy
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
     * @return Dummy
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
