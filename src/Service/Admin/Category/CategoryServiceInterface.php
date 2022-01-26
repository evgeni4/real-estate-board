<?php

namespace App\Service\Admin\Category;

use App\Entity\Category;

interface CategoryServiceInterface
{
    public function add(Category $category): ?bool;

    public function edit(Category $category): ?bool;

    public function remove(Category $category): ?bool;

    public function all(): array;
}