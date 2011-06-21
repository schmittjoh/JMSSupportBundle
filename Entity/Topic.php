<?php

namespace JMS\SupportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="support_topics")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class Topic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="JMS\SupportBundle\Entity\Answer", mappedBy="topic", orphanRemoval=true, cascade = {"persist"})
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="JMS\SupportBundle\Entity\TopicI18n", mappedBy="topic", orphanRemoval=true, cascade = {"persist"}, indexBy="locale")
     */
    private $translations;

    private $currentLocale;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getTitle()
    {
        if (null === $this->currentLocale) {
            throw new \RuntimeException('The currentLocale was not set.');
        }

        $translation = $this->translations->get($this->currentLocale);
        if (!$translation) {
            throw new \RuntimeException(sprintf('There is no translation for locale "%s".', $this->currentLocale));
        }

        return $translation->getTitle();
    }

    public function setCurrentLocale($locale)
    {
        if ($this->currentLocale === $locale) {
            return;
        }

        $this->currentLocale = $locale;
        foreach ($this->answers as $answer) {
            $answer->setCurrentLocale($locale);
        }
    }

    public function addAnswer(Answer $answer)
    {
        $answer->setTopic($this);
        $this->answers->add($answer);
    }

    public function setAnswers(ArrayCollection $answers)
    {
        $this->answers = $answers;
    }

    public function addTranslation(TopicI18n $translation)
    {
        $translation->setTopic($this);
        $this->translations->set($translation->getLocale(), $translation);
    }

    public function setTranslations(ArrayCollection $translations)
    {
        $this->translations = $translations;
    }
}