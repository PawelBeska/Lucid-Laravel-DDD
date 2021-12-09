<?php

namespace App\Http\Controllers;

use App\Features\StoreLinkFeature;
use Illuminate\Support\Facades\Log;
use Lucid\Units\Controller;

class LinkController extends Controller
{

    public function store()
    {

        return $this->serve(StoreLinkFeature::class);
    }
}
