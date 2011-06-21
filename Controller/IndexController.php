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
class IndexController
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
     * @Route("/")
     * @Template
     */
    public function viewAction()
    {
        $topics = $this->em->createQuery("SELECT t, tt FROM JMS\SupportBundle\Entity\Topic t INNER JOIN t.translations tt INDEX BY tt.locale WHERE tt.locale = :locale")
                                ->setParameter('locale', $this->session->getLocale())
                                ->getResult();

        $locale = $this->session->getLocale();
        foreach ($topics as $topic) {
            $topic->setCurrentLocale($locale);
        }

        return array('topics' => $topics);
    }
}