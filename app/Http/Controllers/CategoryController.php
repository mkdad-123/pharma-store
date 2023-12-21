<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Trait\CrudTrait;
use App\Trait\DatawithMedicineTrait;

class CategoryController extends Controller
{
    use DatawithMedicineTrait,CrudTrait;

    public function __construct()
    {
        $this->setmodel(new Category());
        $this->setModelCrud(new Category());
    }




}
