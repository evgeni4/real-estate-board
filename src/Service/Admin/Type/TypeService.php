<?php

namespace App\Service\Admin\Type;

use App\Entity\PriceType;
use App\Entity\Type;
use App\Repository\PriceTypeRepository;
use App\Repository\TypeRepository;

class TypeService implements TypeServiceInterface
{
    public function __construct(private TypeRepository $typeRepository, private  PriceTypeRepository $priceTypeRepository)
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
}