<?php

namespace JMS\SupportBundle\Controller;

use JMS\DiExtraBundle\Annotation\Autowire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/support")
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class TopicController
{
    /**
     * @Autowire
     */
    private $em;

    /**
     * @Autowire
     */
    private $session;

    /**
     * @Route("/topic/{id}", requirements = {"id"= "\d+"}, name="support_topic")
     * @Template
     */
    public function viewAction($id)
    {
        try {
            $topic = $this->em->createQuery("SELECT t, tt, a, at FROM JMS\SupportBundle\Entity\Topic t INNER JOIN t.translations tt INNER JOIN t.answers a INNER JOIN a.translations at WHERE tt.locale = :locale AND at.locale = :locale")
                                ->setParameter('locale', $this->session->getLocale())
                                ->getSingleResult();
            $topic->setCurrentLocale($this->session->getLocale());

            return array('topic' => $topic);
        } catch (NoResultException $notFound) {
            throw new HttpException(404);
        }
    }
}