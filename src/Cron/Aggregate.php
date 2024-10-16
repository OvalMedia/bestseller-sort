<?php
declare(strict_types=1);
namespace OM\BestsellerSort\Cron;

use OM\BestsellerSort\Service\AggregateService;

class Aggregate
{
    /**
     * @var \OM\BestsellerSort\Service\AggregateService
     */
    protected AggregateService $_aggregateService;

    /**
     * @param \Model\Config $config
     * @param \Api\Blacklist $blacklist
     */
    public function __construct(
        AggregateService $aggregateService
    ) {
        $this->_aggregateService = $aggregateService;
    }

    /**
     * @return void
     * @throws \Zend_Db_Statement_Exception
     */
    public function execute(): void
    {
        $this->_aggregateService->execute();
    }
}
