<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Form\TeamType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends ApiBaseController
{

    /**
     * @Route("/api/{league}/teams.json", methods={"GET"}, name="apiGetTeam")
     * @ParamConverter("league", class="App:League", options={"mapping": {"league": "name"}})
     */
    public function getTeamsAction(League $league)
    {
        $teams = $this->getDoctrine()->getRepository('App:Team')->findBy(['league' => $league]);

        $list = [];

        // best is to JSM serialize the entity, but for quick task we will just create array
        if ($teams) {
            foreach ($teams as $team) {
                $list[] = [
                    'name' => $team->getName(),
                    'strip' => $team->getStrip(),
                ];
            }
        }

        return new JsonResponse($list);
    }

    /**
     * @Route("/api/team/create.json", methods={"POST"}, name="apiCreateTeam")
     */
    public function postTeamsAction(Request $request)
    {
        $team = new Team();

        /** @var FormInterface $form */
        $form = $this->createAPIForm(TeamType::class, $team);
        $form->handleRequest($request);

        if (!$form->isSubmitted() or !$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return new JsonResponse(['message' => 'invalid request', 'errors' => $errors], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();

        return new JsonResponse([
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league' => $team->getLeague()->getName()
        ]);
    }

    /**
     * @Route("/api/team/{id}.json", methods={"PUT"}, name="apiUpdateTeam")
     */
    public function putTeamsAction(Request $request, Team $team)
    {
        /** @var FormInterface $form */
        $form = $this->createAPIForm(TeamType::class, $team, ['method' => 'PUT']);
        $form->handleRequest($request);

        if (!$form->isSubmitted() or !$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return new JsonResponse(['message' => 'invalid request', 'errors' => $errors], 400);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();

        return new JsonResponse([
            'id' => $team->getId(),
            'name' => $team->getName(),
            'strip' => $team->getStrip(),
            'league' => $team->getLeague()->getName()
        ]);
    }

    /**
     * @Route("/api/league/{name}.json", methods={"DELETE"}, name="apiDeleteLeague")
     */
    public function deleteLeagueAction(League $league)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($league);
        $em->flush();

        return new Response();
    }
}