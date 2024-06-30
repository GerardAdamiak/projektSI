<?php
/*
 * This file is part of the YourProject package.
 *
 * (c) Your Name <your-email@example.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Dto;

use App\Entity\Category;

/**
 * Class PostListFiltersDto.
 *
 * Data Transfer Object (DTO) for holding filters for the Post list.
 */
class PostListFiltersDto
{
    /**
     * @param Category|null           $category Category filter
     * @param \DateTimeInterface|null $dateFrom Date filter from
     * @param \DateTimeInterface|null $dateTo   Date filter to
     */
    public function __construct(?Category $category = null, ?\DateTimeInterface $dateFrom = null, ?\DateTimeInterface $dateTo = null)
    {
        // Constructor code here
    }
}
