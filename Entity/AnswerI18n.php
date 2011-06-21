<?php

namespace JMS\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="support_answers_i18n")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\HasLifecycleCallbacks
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class AnswerI18n
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="JMS\SupportBundle\Entity\Answer")
     */
    private $answer;

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

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTime;
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

    public function getText()
    {
        return $this->text;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAnswer(Answer $answer)
    {
        if (null !== $this->answer) {
            throw new \RuntimeException('This translation is already linked to an answer.');
        }
        $this->answer = $answer;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime;
    }
}