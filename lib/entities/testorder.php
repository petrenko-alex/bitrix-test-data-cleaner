<?php namespace Petrenko\TestDataCleaner\Entities;


// TODO: PHP Doc
use Bitrix\Sale\Order;
use Bitrix\Sale\Payment;
use Bitrix\Sale\Shipment;
use Bitrix\Sale\OrderTable;
use Bitrix\Sale\Internals\OrderCouponsTable;
use Bitrix\Sale\Internals\OrderDiscountDataTable;

class TestOrder extends BaseTestEntity
{
    public function findElements(): array
    {
        $elements = OrderTable::getList(array(
            'filter' => array(
                'USER_DESCRIPTION' => $this->testDataFilter->getFilter(),
            ),
            'select' => array('ID', 'USER_DESCRIPTION'),
        ))->fetchAll();

        return array_map(static function ($el) { return $el['ID']; }, $elements);
    }

    protected function removeElements(): void
    {
        // TODO: refactor
        foreach ($this->elementsId as $elementId)
        {
            $order = Order::load($elementId);
            if ($order)
            {

                foreach ($order->getPaymentCollection() as $orderPayment)
                {
                    /** @var Payment $orderPayment */
                    $orderPayment->setField('PAID', false);
                }

                foreach ($order->getShipmentCollection() as $orderShipment)
                {
                    /** @var Shipment $orderShipment */
                    if (!$orderShipment->isSystem())
                    {
                        $orderShipment->setField('DEDUCTED', false);
                    }
                }

                OrderDiscountDataTable::clearByOrder($order->getId());
                OrderCouponsTable::clearByOrder($order->getId());
            }
            $order->save();

            $res = Order::delete($elementId);
        }
    }

    private function releaseOrder($orderId)
    {

    }
}