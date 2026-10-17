<?php

namespace Cecil\Renderer\Extension;

use Cecil\Builder;
use Cecil\Collection\Page\Page;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PaperModExtension extends AbstractExtension
{
    /** @var Builder */
    protected $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('sort_by', [$this, 'sortBy']),
        ];
    }

    /**
     * Groups pages by year and/or month (keys are kept in pages order).
     *
     * @return iterable<Page>|array<string, array<Page>>|array<string, array<string, array<Page>>>
     */
    public function sortBy(iterable $pages, array $options = []): iterable
    {
        $byMonths = $options['months'] ?? true;
        $byYears = $options['years'] ?? true;

        if ($byMonths === false && $byYears === false) {
            return $pages;
        }

        $sorted = [];

        /** @var Page $page */
        foreach ($pages as $page) {
            $date = $page->getVariable('date');
            if (!$date instanceof \DateTimeInterface) {
                continue;
            }
            $month = $date->format('m');
            $year = $date->format('Y');

            switch (true) {
                case $byMonths && $byYears:
                    $sorted[$year][$month][] = $page;
                    break;
                case $byMonths:
                    $sorted[$month][] = $page;
                    break;
                case $byYears:
                    $sorted[$year][] = $page;
                    break;
            }
        }

        return $sorted;
    }
}
