<?php

namespace App\Interfaces;

interface CrudRepoInterface
{
    public function store($data);

    public function showAll();

    public function showOne($id);

}
