<?php

namespace VnCoder\Models;

class VnCart
{
    const CART_KEY = 'vn_carts';

    public static function total()
    {
        $total = 0;
        $cartData = self::getData();
        if ($cartData) {
            foreach ($cartData as $item) {
                $price = (int) $item['price'];
                $total += $price;
            }
        }
        return $total;
    }

    public static function check($type, $id)
    {
        $cartData = self::getData();
        $itemKey = self::getItemKey($type, $id);
        return isset($cartData[$itemKey]);
    }

    public static function get()
    {
        return self::getData();
    }

    public static function add($type, $id, $name, $price, $data = []): void
    {
        $itemKey = self::getItemKey($type, $id);
        $itemData = [
            'id' => $id , 'type' => $type,
            'name' => $name , 'price' => $price , 'data' => $data
        ];

        $cartData = self::getData();
        $cartData[$itemKey] = $itemData;
        self::setData($cartData);
    }

    public static function remove($type, $id)
    {
        $itemKey = self::getItemKey($type, $id);
        self::removeId($itemKey);
    }

    public static function removeId($itemKey)
    {
        $cartData = self::getData();
        if (isset($cartData[$itemKey])) {
            unset($cartData[$itemKey]);
            self::setData($cartData);
        }
    }

    public static function clear(): void
    {
        session()->forget(self::CART_KEY);
    }

    protected static function getData(): ?array
    {
        $query = session(self::CART_KEY);
        return $query ?? [];
    }

    protected static function setData($cartData): void
    {
        if ($cartData) {
            session([self::CART_KEY => $cartData]);
        } else {
            self::clear();
        }
    }

    protected static function getItemKey($type, $id)
    {
        return $type . '-' . $id;
    }
}
