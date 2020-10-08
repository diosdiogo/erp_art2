<?php

namespace App\ViewModel;

use App\Http\Requests\Request;

class BaseViewModel extends Request
{

    protected function obterItem($id){
        $parametro = $this->obterParametros();
        return $parametro->has($id) ? $this->obterParametros()[$id] : "";
    }

    protected function obterParametros(){
        return collect($this->query);
    }

    public function rules()
    {
        return array();
    }   

    public function authorize()
    {
        return true;
    }
}