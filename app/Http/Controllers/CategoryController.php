<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Trait\DatawithMedicineTrait;

class CategoryController extends Controller
{
    use DatawithMedicineTrait;

    public function __construct()
    {
        $this->setmodel(new Category());
    }
}
