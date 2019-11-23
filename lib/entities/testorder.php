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
        foreach ($this->elementsId as $elementId) {
            $this->releaseOrder($elementId);
            Order::delete($elementId);
        }
    }

    private function releaseOrder($orderId): void
    {
        $order = Order::load($orderId);
        if ($order) {
            $this->releasePayments($order);
            $this->releaseShipments($order);
            $this->releaseDiscounts($order);
        }
        $order->save();
    }

    private function releasePayments(Order $order): void
    {
        foreach ($order->getPaymentCollection() as $orderPayment) {
            /** @var Payment $orderPayment */
            $orderPayment->setField('PAID', false);
        }
    }

    private function releaseShipments(Order $order): void
    {
        foreach ($order->getShipmentCollection() as $orderShipment) {
            /** @var Shipment $orderShipment */
            if (!$orderShipment->isSystem()) {
                $orderShipment->setField('DEDUCTED', false);
            }
        }
    }

    private function releaseDiscounts(Order $order): void
    {
        OrderDiscountDataTable::clearByOrder($order->getId());
        OrderCouponsTable::clearByOrder($order->getId());
    }
}