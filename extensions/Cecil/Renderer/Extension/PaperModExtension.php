<?php

namespace Cecil\Renderer\Extension;

use Cecil\Builder;
use Cecil\Collection\Page\Collection as PagesCollection;
use Cecil\Collection\Page\Page;
use Cecil\Config;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PaperModExtension extends AbstractExtension
{
    /** @var Builder */
    protected $builder;

    /** @var Config */
    protected $config;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
        $this->config = $builder->getConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'CoreExtension';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('sort_by', [$this, 'sortBy']),
        ];
    }

    /**
     * @return array<string, Page>|array<string, Page>|array<string, array<string, Page>>
     */
    public function sortBy(PagesCollection $pages, array $options = []): \Traversable
    {
        $byMonths = $options['months'] ?? true;
        $byYears = $options['years'] ?? true;

        $sorted = new \ArrayIterator();

        if ($byMonths === false && $byYears === false) {
            return $pages;
        }

        /**
         * @var Page $page
         */
        foreach ($pages as $page) {
            $date = $page->getVariables()['date'];
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
