<?php

declare(strict_types=1);

/**
 * Write a recursive function to print title, price and category from the given php array.
 * Required Output
 * [
 *  [title] => SanDisk 256,
 *  [price] => 24.45,
 *  [category] => Home > Electronics & Accessories
 * ]
 * [
 *  [title] => Jabra Wireless Headset
 *  [price] => 55.12
 *  [category] => Home > Electronics & Accessories
 * ]
 * [
 *  [title] => DJI OM 5 Smartphone Gimbal Stabilizer
 *  [price] => 129.99
 *  [category] => Home > Electronics & Accessories > Accessories
 * ]
 * [
 *  [title] => SAMSUNG Galaxy SmartTag
 *  [price] => 30.00
 *  [category] => Home > Electronics & Accessories > Accessories
 * ]
 */

$products = [
  'Home' => [
    'Electronics & Accessories' => [
      'items' => [
        [
          'title' => 'SanDisk 256',
          'price' => '24.45'
        ],
        [
          'title' => 'Jabra Wireless Headset',
          'price' => '55.12'
        ]
      ],
      'Accessories' => [
        'items' => [
          [
            'title' => 'DJI OM 5 Smartphone Gimbal Stabilizer',
            'price' => '129.99'
          ],
          [
            'title' => 'SAMSUNG Galaxy SmartTag',
            'price' => '30.00'
          ]
        ],
      ],
    ]
  ],
];

function getProducts(array $products): array
{
  $resultantArray = [];

  foreach ($products as $category => $categoryItems) {
    if ($category !== 'items') {
      $subCategoryProducts = getProducts($categoryItems);
      foreach ($subCategoryProducts as $subCategoryProduct) {
        $subCategoryProduct['category'] = $category . ' > ' . $subCategoryProduct['category'];
        array_push($resultantArray, $subCategoryProduct);
      }
    }

    if (isset($categoryItems['items'])) {
      foreach ($categoryItems['items'] as $item) {
        $product = [
          'title' => $item['title'],
          'price' => $item['price'],
          'category' => $category
        ];
        array_push($resultantArray, $product);
      }
    }
  }

  return $resultantArray;
}

foreach (getProducts($products) as $product) {
  print_r($product);
}
