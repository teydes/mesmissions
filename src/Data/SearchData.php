<?php
/**
 * Created by PhpStorm.
 * User: GENIE
 * Date: 29/03/2022
 * Time: 18:29
 */

namespace App\Data;


use App\Entity\Category;

class SearchData
{
    /**
     * @var int
     */
    public $page = 1;
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $categories = [];
}