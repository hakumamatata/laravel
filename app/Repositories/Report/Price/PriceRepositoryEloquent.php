<?php
/**
 * Created by PhpStorm.
 * User: JIN
 * Date: 2020/5/19
 * Time: 下午 03:37
 */

namespace App\Repositories\Report\Price;


class PriceRepositoryEloquent implements PriceRepository
{
    public function getTaiwanPrice(): int
    {
        return 198000;
    }

    public function getJapanPrice(): int
    {
        return 47000;
    }
}