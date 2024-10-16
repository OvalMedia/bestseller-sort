<?php

declare(strict_types=1);

namespace OM\BestsellerSort\Service;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Catalog\Model\Product\Action;

class AggregateService
{
    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected AdapterInterface $_db;

    /**
     * @var \Magento\Catalog\Model\Product\Action
     */
    protected Action $_action;

    /**
     * @param \Magento\Framework\App\ResourceConnection $connection
     * @param \Magento\Catalog\Model\Product\Action $action
     */
    public function __construct(
        ResourceConnection $connection,
        Action $action
    ) {
        $this->_db = $connection->getConnection('default');
        $this->_action = $action;
    }

    /**
     * @return void
     * @throws \Zend_Db_Statement_Exception
     */
    public function execute()
    {
        $res = $this->_db->query(
            "SELECT attribute_id 
            FROM eav_attribute 
            WHERE attribute_code = 'bestseller'
            AND entity_type_id = 4"
        );

        $attribute_id = $res->fetchColumn();

        if ($attribute_id) {
            $this->_db->query(
                "DELETE FROM catalog_product_entity_int WHERE attribute_id = :attribute_id",
                ['attribute_id' => $attribute_id]
            );

            $start = new \DateTime('first day of last month');
            $end = new \DateTime('last day of last month');

            $res = $this->_db->query(
                "SELECT o.store_id, p.entity_id, SUM(oi.qty_ordered) AS total_units_sold
                FROM sales_order_item AS oi
                JOIN sales_order AS o ON oi.order_id = o.entity_id
                JOIN catalog_product_entity AS p ON oi.product_id = p.entity_id
                WHERE o.created_at BETWEEN '" . $start->format('Y-m-d') . " 00:00:00' AND '" . $end->format('Y-m-d') . " 23:59:59'
                AND o.status IN ('complete')
                GROUP BY o.store_id, p.entity_id"
            );

            while ($row = $res->fetchObject()) {
                $this->_action->updateAttributes([$row->entity_id], [
                    'bestseller' => $row->total_units_sold], $row->store_id);
            }
        }
    }
}