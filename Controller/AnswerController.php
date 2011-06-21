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
class AnswerController
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
     * @Route("/answer/{id}", requirements = {"id" = "\d+"}, name="support_answer")
     * @Template
     */
    public function viewAction($id)
    {
        try {
            $answer = $this->em->createQuery("SELECT t, tt, a, at FROM JMS\SupportBundle\Entity\Answer a INNER JOIN a.topic t INNER JOIN t.translations tt INDEX BY tt.locale INNER JOIN a.translations at INDEX BY at.locale WHERE tt.locale = :locale AND at.locale = :locale")
                                    ->setParameter('locale', $this->session->getLocale())
                                    ->getSingleResult();
            $answer->setCurrentLocale($this->session->getLocale());

            return array('answer' => $answer);
        } catch (NoResultException $notFound) {
            throw new HttpException(404);
        }
    }
}