<?php

namespace App\Repositories;

use App\Interfaces\PostOrderInterfaces;

class PostOrderRepository implements PostOrderInterfaces
{
    public function getPostOrderDataFromSession()
    {
        return session()->get('postOrder');
    }

    public function savePostOrderDataToSession($data)
    {
        session()->put('postOrder', $data);
    }
}
