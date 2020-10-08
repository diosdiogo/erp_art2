<?php

namespace App\Repositorio;

use DB;
use Session;
use Illuminate\Container\Container as App;

class BaseRepository {

    protected $model;
    protected $corrigirRelacionamento = false;
    protected $db;

    function __construct($_model, $_corrigirRelacionamento = false) {
        $this->model = new $_model;
        $this->corrigirRelacionamento = $_corrigirRelacionamento;
        $this->db = DB::connection(Session::get('usuario_banco'));
    }

    public function obterCompleto($columns = array('*')) {
        return $this->model->get($columns);
    }

    public function obterBasico($columns = array('*')) {
        return $this->model->get($columns);
    }

    public function paginacao($perPage = 15, $columns = array('*')) {
        return $this->model->paginate($perPage, $columns);
    }

    public function inserir(array $data) {
        return $this->model->create($data);
    }

    public function alterar(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    public function deletar($id) {
        return $this->model->destroy($id);
    }

    public function obter($id, $columns = array('*')) {
        return $this->model->findOrFail($id, $columns);
    }

    public function obterEspecifico($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function obterParaAlterar($id){
        return $this->obter($id);
    }

    function toArrayView($array) { 
      if (!is_array($array))
        return false; 

      $result = array(); 
      foreach ($array as $key => $value) { 
        if (is_array($value))
          $result = array_merge($result, array_flatten($value)); 
        else
          $result[$key] = $value; 
      } 

      return $result; 
    } 

    public function ObterIds($lista){
        return collect($lista)->map(function ($item) {
            return $item['id'];
        })->all();
    }

    public function ObterPorCampo($lista, $campo){
        return collect($lista)->map(function ($item) use(&$campo) {
            return $item[$campo];
        })->all();
    }

}