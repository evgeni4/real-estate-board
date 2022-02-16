<?php

namespace App\Controller\Main;

use App\Form\Main\Search\SearchAdvancedType;
use App\Form\Main\Search\SearchType;
use App\Service\Property\PropertyServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(private PropertyServiceInterface $propertyService)
    {
    }

    #[Route('/search', name: 'ajax_search', methods: 'GET')]
    public function searchAction(Request $request,): Response
    {
        if ($request->isXmlHttpRequest()) {
            $keyword = $request->query->get('q');
            $entities = $this->propertyService->searchKeywords($keyword);

            if (!$entities) {
                $result['entities']['error'] = 'foo.no_records';
            } else {
                $result['entities'] = $this->getRealEntities($entities, $request->getLocale());
            }
            return new Response(json_encode($result));
        }

        return new Response('',200);
    }

    public function getRealEntities($entities, $locale)
    {

        foreach ($entities as $entity) {
            $realEntities[] = $entity->translate($locale)->getTitle();
        }

        return $realEntities;
    }

    public function search(): Response
    {
        $form = $this->createForm(SearchType::class);
        return $this->render('main/_embed/_search/_form_search.html.twig', ['form' => $form->createView()]);
    }

    public function advancedSearch(): Response
    {
        $form = $this->createForm(SearchAdvancedType::class);
        return $this->render('main/_embed/_search/_form_advanced_search.html.twig', ['formAdvanced' => $form->createView()]);
    }
}