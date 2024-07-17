<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLang($locale)
    {  
         if(in_array($locale,['ar','fr'])){
        App::setLocale($locale);
        Session::put('locale', $locale);
        }
        return back();
    }
}
