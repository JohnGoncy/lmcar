<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ProductHandler;

/**
 * Class ProductHandlerTest
 */
class ProductHandlerTest extends TestCase
{
    private $products = [
        [
            'id' => 1,
            'name' => 'Coca-cola',
            'type' => 'Drinks',
            'price' => 10,
            'create_at' => '2021-04-20 10:00:00',
        ],
        [
            'id' => 2,
            'name' => 'Persi',
            'type' => 'Drinks',
            'price' => 5,
            'create_at' => '2021-04-21 09:00:00',
        ],
        [
            'id' => 3,
            'name' => 'Ham Sandwich',
            'type' => 'Sandwich',
            'price' => 45,
            'create_at' => '2021-04-20 19:00:00',
        ],
        [
            'id' => 4,
            'name' => 'Cup cake',
            'type' => 'Dessert',
            'price' => 35,
            'create_at' => '2021-04-18 08:45:00',
        ],
        [
            'id' => 5,
            'name' => 'New York Cheese Cake',
            'type' => 'Dessert',
            'price' => 40,
            'create_at' => '2021-04-19 14:38:00',
        ],
        [
            'id' => 6,
            'name' => 'Lemon Tea',
            'type' => 'Drinks',
            'price' => 8,
            'create_at' => '2021-04-04 19:23:00',
        ],
    ];

    public function testGetTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }

        $productHandler = new ProductHandler();
        $this->assertEquals($productHandler->getTotalPrice($this->products), $totalPrice);
        //$this->assertEquals(143, $totalPrice);
    }

    public function testRsortPriceWithTypeFilter()
    {
        $productHandler = new ProductHandler();
        $sortedProducts = [
            [
                'id' => 4,
                'name' => 'Cup cake',
                'type' => 'Dessert',
                'price' => 35,
                'create_at' => '2021-04-18 08:45:00',
            ],
            [
                'id' => 5,
                'name' => 'New York Cheese Cake',
                'type' => 'Dessert',
                'price' => 40,
                'create_at' => '2021-04-19 14:38:00',
            ],

        ];
        //考虑到排序结果受数组下标的影响，在测试用例中，对数组下标做倒序排列以达到修正的效果
        krsort($sortedProducts);

        $this->assertEquals($sortedProducts, $productHandler->rsortPriceWithTypeFilter($this->products, 'Dessert'));
    }

    public function testTransCreateAtToTimestamp()
    {
        //初始化期望商品数组
        $expectedProducts = $this->products;
        //转换create
        foreach ($expectedProducts as $idx => $product) {
            $expectedProducts[$idx]['create_at'] = strtotime($product['create_at']);
        }
        $productHandler = new ProductHandler();
        $this->assertEquals($expectedProducts, $productHandler->transCreateAtToTimestamp($this->products));
    }
}