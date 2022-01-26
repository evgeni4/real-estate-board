<?php

namespace App\Service\Admin\Type;

use App\Entity\Type;

interface TypeServiceInterface
{
    public function add(Type $type): ?bool;

    public function edit(Type $type): ?bool;

    public function delete(Type $type): ?bool;

    public function all(): ?array;
}