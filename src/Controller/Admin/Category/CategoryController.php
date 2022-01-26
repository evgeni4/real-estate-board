<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\Admin\Category\CategoryFormType;
use App\Service\Admin\Category\CategoryServiceInterface;
use App\Service\Admin\Settings\SettingsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

#[Route('/admin/category')]
class CategoryController extends AbstractController
{
    public function __construct(
        private TranslatorInterface      $translator,
        private Breadcrumbs              $breadcrumbs,
        private CategoryServiceInterface $categoryService,
    )
    {
    }

    #[Route('/show', name: 'admin_category_show')]
    public function show(): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addItem($this->translator->trans('categories.label'));
        return $this->render('admin/category/show.html.twig', [
            'categories' => $this->categoryService->all(),
        ]);
    }

    #[Route('/new', name: 'admin_category_new')]
    public function new(Request $request): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addRouteItem($this->translator->trans('categories.label'), 'admin_category_show');
        $this->breadcrumbs->addItem($this->translator->trans('add.label'));
        $locale = $request->getLocale();
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category, ['locale' => $locale]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->add($category);
            $this->addFlash('success', $this->translator->trans('category.added.label'));
            return $this->redirectToRoute('admin_category_show');
        }
        return $this->render('admin/category/new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/edit/{id}', name: 'admin_category_edit')]
    public function edit(Request $request, Category $category): Response
    {
        $this->breadcrumbs->addItem($this->translator->trans('catalog.label'));
        $this->breadcrumbs->addRouteItem($this->translator->trans('categories.label'), 'admin_category_show');
        $this->breadcrumbs->addItem($this->translator->trans('edit.label'));
        $form = $this->createForm(CategoryFormType::class, $category, array('locale' => $request->getLocale()));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryService->edit($category);
            $this->addFlash('success', $this->translator->trans('category.edit.label'));
            return $this->redirectToRoute('admin_category_show');
        }
        return $this->render('admin/category/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/delete/{id}', name: 'admin_category_delete')]
    public function delete(Request $request, Category $category): Response
    {
        $this->categoryService->remove($category);
        $this->addFlash('success', $this->translator->trans('category.delete.label'));
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
