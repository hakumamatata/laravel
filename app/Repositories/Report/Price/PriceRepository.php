<?php
/**
 * Created by PhpStorm.
 * User: JIN
 * Date: 2020/5/19
 * Time: 下午 03:35
 */

namespace App\Repositories\Report\Price;


interface PriceRepository
{
    public function getTaiwanPrice();

    public function getJapanPrice();
}