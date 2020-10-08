<?php

namespace App\Models;

use Session;
use Carbon\Carbon;
use App\Extension\CommonExtension;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = true;
    public $mensagemAlias = [];
    public function __construct($timestamps = true){
       $this->timestamps = $timestamps;
       $this->connection = $this->connection ?: Session::get('usuario_banco');
    }

    public function getAllAttributes()
    {
        $columns = $this->getFillable();
        $attributes = $this->getAttributes();

        foreach ($columns as $column)
            if (!array_key_exists($column, $attributes))
                $attributes[$column] = null;

        return $attributes;
    }

    public static function obterModelDados($model, array $attributes = []){
        $columns = $model->getFillable();
        $check_chave = "check_";

        foreach($attributes as $chave => $valor){
            if (in_array($chave, $columns)){

                $adicionar = !(startsWith($chave, "id") == true && CommonExtension::in($valor, array("", "0", null, "true", "false")));
                if($adicionar){
                    $campoFormatado = $valor;

                    if(str_contains($chave, "data")){
                        $data = date_create(str_replace("/", "-", substr($campoFormatado, "0", "10") ));
                        $campoFormatado = date_format($data, 'Y/m/d');
                    }

                    $campoFormatado = strpos($campoFormatado, ".") && strpos($campoFormatado, ",") ? str_replace(".", "", $campoFormatado) : $campoFormatado;

                    if(str_contains($chave, "password")){
                        $model->$chave = str_replace(",", ".", $campoFormatado);
                    }else{
                        $model->$chave = strtoupper(str_replace(",", ".", $campoFormatado));
                    }

                } else if($valor === 'true' || $valor === 'false')
                    $model->$chave = $valor === 'true' ? "1" : "0";
            }
        }

        $chaveEmpresa = "idempresa";
        if(in_array($chaveEmpresa, $columns))
            $model->$chaveEmpresa = "1";

        return $model;
    }

    public static function inserir(array $attributes = [])
    {
        $model = BaseModel::obterModelDados(new static($attributes), $attributes);
        $model->save();

        return $model;
    }

    public static function alterar($modelo, array $attributes = [])
    {
        $model = BaseModel::obterModelDados($modelo, $attributes);
        return $model->update();
    }
}
