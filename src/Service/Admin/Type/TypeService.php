<?php

namespace App\Service\Admin\Type;

use App\Entity\Type;
use App\Repository\TypeRepository;

class TypeService implements TypeServiceInterface
{
    public function __construct(private TypeRepository $typeRepository)
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
}