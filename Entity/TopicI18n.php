<?php

namespace JMS\SupportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="support_topics_i18n")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\HasLifecycleCallbacks
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class TopicI18n
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="JMS\SupportBundle\Entity\Topic")
     */
    private $topic;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=5)
     */
    private $locale;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime;
        $this->answers = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTopic(Topic $topic)
    {
        if (null !== $this->topic) {
            throw new \RuntimeException('This translation is already linked to a topic.');
        }
        $this->topic = $topic;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;
    }
}