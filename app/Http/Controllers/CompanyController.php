<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Trait\CrudTrait;

class CompanyController extends Controller
{
    use CrudTrait;

    public function __construct()
    {
        $this->setModelCrud(new Company());
    }
}
