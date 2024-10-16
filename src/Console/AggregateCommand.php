<?php
declare(strict_types=1);

namespace OM\BestsellerSort\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use OM\BestsellerSort\Service\AggregateService;
use Magento\Framework\App\State;

class AggregateCommand extends Command
{
    /**
     * @var \Magento\Framework\App\State
     */
    protected State $_state;

    /**
     * @var \OM\BestsellerSort\Service\AggregateService
     */
    protected AggregateService $_aggregateService;

    /**
     * @param \Magento\Framework\App\State $state
     * @param \OM\BestsellerSort\Service\AggregateService $aggregateService
     */
    public function __construct(
        State $state,
        AggregateService $aggregateService
    ) {
        $this->_state = $state;
        $this->_aggregateService = $aggregateService;
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('om:bestsellersort:aggregate')
            ->setDescription('Aggregate the amount of units sold')
        ;

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Zend_Db_Statement_Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->_state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        $this->_aggregateService->execute();
        return 0;
    }
}