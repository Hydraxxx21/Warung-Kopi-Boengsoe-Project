<?php

namespace App\Interfaces;

interface PostOrderInterfaces
{
    public function getPostOrderDataFromSession();

    public function savePostOrderDataToSession($data);
}
