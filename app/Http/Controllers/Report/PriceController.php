<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Repositories\Report\Price\PriceRepository;

class PriceController extends Controller
{
    /**
     * PriceController constructor.
     */
    public function __construct()
    {
//        $this->middleware('auth');
//
//        $this->middleware('log')->only('taiwan');
//
//        $this->middleware('subscribed')->except('taiwan');
    }

    /**
     * @return string
     */
    public function taiwan()
    {

//        dd($this->app);
        $data = resolve(PriceRepository::class);
//        dump($data->getTaiwanPrice());
//        dd($data);
        return 'HERE TAIWAN :' . $data->getTaiwanPrice();
    }

    /**
     * @return string
     */
    public function japan()
    {
        $data = resolve(PriceRepository::class);
        return 'HERE JAPAN :' . $data->getJapanPrice();
    }

    /**
     * 測試由 服務容器 自動解析 (優化可使用Facades 再降低耦合性)
     * @param PriceRepository $priceRepository
     * @return string
     */
    public function test(PriceRepository $priceRepository)
    {
        return 'TAIWAN: ' . $priceRepository->getTaiwanPrice() . ',<br> JAPAN: ' . $priceRepository->getJapanPrice();
    }
}
