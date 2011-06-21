<?php

namespace JMS\SupportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="support_answers")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="JMS\SupportBundle\Entity\Topic")
     */
    private $topic;

    /**
     * @ORM\OneToMany(targetEntity="JMS\SupportBundle\Entity\TopicI18n", mappedBy="answer", orphanRemoval=true, cascade = {"persist"})
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function setTopic($topic)
    {
        if (null !== $this->topic) {
            throw new \RuntimeException('This answer is already linked to a topic.');
        }
        $this->topic = $topic;
    }

    public function addTranslation(AnswerI18n $translation)
    {
        $this->translations->set($translation->getLocale(), $translation);
    }

    public function setTranslations(ArrayCollection $translations)
    {
        $this->translations = $translations;
    }
}