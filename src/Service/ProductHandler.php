<?php

namespace App\Service;

class ProductHandler
{

    /**
     * 计算商品总金额
     * @param $products
     * @return int|mixed
     */
    public function getTotalPrice($products)
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }

        return $totalPrice;
    }

    /**
     * 对数组的price进行降序排列
     * @param $a
     * @param $b
     * @return int
     */
    private function rsortPrice($a, $b)
    {
        if($a['price'] == $b['price']) {
            return 0;
        }
        return ($a['price'] > $b['price']) ? -1 : 1;
    }

    /**
     * 根据种类筛选产品
     * @param $products
     * @param $filter
     * @return array
     */
    private function getProductsByType($products, $filter)
    {
        //定义过滤后的商品
        $filteredProducts = array();
        //根据种类type过滤商品
        foreach ($products as $product) {
            if ($product['type'] == $filter) {
                $filteredProducts[] = $product;
            }
        }
        return $filteredProducts;
    }


    /**
     * 按照商品的某个key进行筛选，并按照金额降序排列，返回排序后的数组
     * @param $products
     * @param $filter
     * @return array
     */
    public function rsortPriceWithTypeFilter($products, $filter)
    {
        //根据种类筛选返回筛选后的商品
        $filteredProducts = $this->getProductsByType($products, $filter);

        //对商品按金额降序排列
        uasort($filteredProducts, [$this, "rsortPrice"]);

        return $filteredProducts;
    }

    /** 将商品中的创建日期转换为unix_timestamp
     * @param $products
     * @return array
     */
    public function transCreateAtToTimestamp($products){
        return array_map([$this, "transDatetimeToUnixTimestamp"], $products);
    }


    /**
     * 将数组中的create_at字段转换成unix_timestamp
     * @param $arg
     * @return mixed
     */
    private function transDatetimeToUnixTimestamp(&$arg)
    {
        $arg['create_at'] = strtotime($arg['create_at']);
        return $arg;
    }
}