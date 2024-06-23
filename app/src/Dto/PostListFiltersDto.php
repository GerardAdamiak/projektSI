<?php

namespace App\Dto;

use App\Entity\Category;

class PostListFiltersDto
{
    public ?Category $category;
    public ?\DateTimeInterface $dateFrom;
    public ?\DateTimeInterface $dateTo;

    public function __construct(?Category $category = null, ?\DateTimeInterface $dateFrom = null, ?\DateTimeInterface $dateTo = null)
    {
        $this->category = $category;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;



    }
}
