<?php
/**
 * Created by PhpStorm.
 * User: Krisz
 * Date: 2017.03.02.
 * Time: 19:01
 */

namespace Modules\Frontend\Controllers;


use Modules\BusinessLogic\Search\StorageSearch;

class ProductController extends ControllerBase
{
    public function getProductsAction(){
        $storageSearch = StorageSearch::createStorageSearch();
        $storageSearch->unwind = '$products';
        $storageSearch->type = 'discount';
        $discounts = $storageSearch->aggregate();
        dd($discounts);
    }
}