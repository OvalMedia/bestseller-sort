<?php

declare(strict_types=1);

namespace OM\BestsellerSort\Service;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;

class AggregateService
{
    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected AdapterInterface $_db;

    /**
     * @param \Magento\Framework\App\ResourceConnection $connection
     */
    public function __construct(
        ResourceConnection $connection
    ) {
        $this->_db = $connection->getConnection('default');
    }

    public function execute()
    {
        $res = $this->_db->query(
            "SELECT p.entity_id
            SUM(oi.qty_ordered) AS total_units_sold
            FROM sales_order_item AS oi
            JOIN sales_order AS o ON oi.order_id = o.entity_id
            JOIN catalog_product_entity AS p ON oi.product_id = p.entity_id
            WHERE o.created_at BETWEEN '2024-01-01 00:00:00' AND '2024-08-31 23:59:59'
            AND o.status IN ('complete')
            GROUP BY p.entity_id"
        );
    }
}