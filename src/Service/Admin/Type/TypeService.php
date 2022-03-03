<?php

namespace App\Service\Admin\Type;

use App\Entity\PriceType;
use App\Entity\Type;
use App\Repository\CategoryRepository;
use App\Repository\PriceTypeRepository;
use App\Repository\TypeRepository;

class TypeService implements TypeServiceInterface
{
    public function __construct(
        private TypeRepository $typeRepository,
        private PriceTypeRepository $priceTypeRepository,
        private CategoryRepository $categoryRepository,
    )
    {
    }

    public function add(Type $type): ?bool
    {
        return $this->typeRepository->insert($type);
    }

    public function edit(Type $type): ?bool
    {
        return $this->typeRepository->update($type);
    }

    public function delete(Type $type): ?bool
    {
        return $this->typeRepository->remove($type);
    }

    public function all(): ?array
    {
        return $this->typeRepository->findAll();
    }

    public function addPeriod(PriceType $priceType): ?bool
    {
        return $this->priceTypeRepository->insert($priceType);
    }

    public function editPeriod(PriceType $priceType): ?bool
    {
        return $this->priceTypeRepository->update($priceType);
    }

    public function deletePeriod(PriceType $priceType): ?bool
    {
        return $this->priceTypeRepository->delete($priceType);
    }

    public function allPeriod(): ?array
    {
        return $this->priceTypeRepository->findAll();
    }

    public function buildMenu(): ?array
    {
        $menu = [];
        $rows = $this->typeRepository->findAll();
        foreach ($rows as $row) {
            array_push(
                $menu,
                array_filter(
                    [
                        'id' => $row->getUuid(),
                        'title' => $row->translate()->getTitle()
                    ]
                )
            );

        }
        return $menu;
    }

    public function showMenu(): void
    {
        foreach ($this->buildMenu() as $item) {
            $link = "<a href='/listings/type/".$item['id']."'>" . $item['title'] . "</a>";
            echo "<li>$link</li>";
        }
    }

    public function buildMenuTypeProperty(): ?array
    {
        $category = [];
        $rows = $this->categoryRepository->findAll();
        foreach ($rows as $row) {
            array_push(
                $category,
                array_filter(
                    [
                        'id' => $row->getUuid(),
                        'title' => $row->translate()->getTitle()
                    ]
                )
            );

        }
        return $category;
    }

    public function showMenuTypeProperty(): void
    {
        foreach ($this->buildMenuTypeProperty() as $item) {
            $link = "<a href='/listings/".$item['id']."'>" . $item['title'] . "</a>";
            echo "<li>$link</li>";
        }
    }
}