<?php

namespace App\Dto;

use App\Entity\Category;

class PostListFiltersDto
{
    public function __construct(public ?Category $category = null, public ?\DateTimeInterface $dateFrom = null, public ?\DateTimeInterface $dateTo = null)
    {
    }
}
