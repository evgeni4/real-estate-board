<?php

namespace App\Service\Property;

use App\Entity\Property;
use App\Entity\User;

interface PropertyServiceInterface
{
    public function add(Property $property): ?bool;

    public function edit(Property $property): ?bool;

    public function delete(Property $property): ?bool;

    public function findAllByAgentListing(int $start, int $limit): ?array;

    public function similarProperties(Property $property): ?array;
}