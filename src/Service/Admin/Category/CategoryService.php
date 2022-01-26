<?php

namespace App\Service\Admin\Category;

use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(public CategoryRepository $categoryRepository)
    {
    }

    public function add(Category $category): ?bool
    {
        return $this->categoryRepository->insert($category);
    }

    public function edit(Category $category): ?bool
    {
        return $this->categoryRepository->update($category);
    }

    public function remove(Category $category): ?bool
    {
        return $this->categoryRepository->delete($category);
    }

    public function all(): array
    {
        return $this->categoryRepository->findAll();
    }
}