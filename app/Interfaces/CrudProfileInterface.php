<?php

namespace App\Interfaces;

interface CrudProfileInterface
{
    public function show();

    public function update($request);

    public function delete();
}
