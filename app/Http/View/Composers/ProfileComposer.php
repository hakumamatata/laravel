<?php

namespace App\Http\View\Composers;


use App\Repositories\User\UserRepository;
use Illuminate\View\View;

class ProfileComposer
{
    /**
     * 實現 UserRepository
     * @var string
     */
    protected $user;

    /**
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        # 由服務容器 自己實現
        $this->user = $user;
    }

    /**
     * 將數據綁定到視圖
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', $this->user->getName());
    }
}