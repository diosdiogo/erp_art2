<?php

namespace App\Helper\Controller;

use App\Extension\MapperExtension;
use App\Enums\Controller\ControllerEnum;
use Validator;

class HelperDeControllerGridUpdateBase
{
    public static function obterUpdateViewModel($pasta, $model){
        return "App\\ViewModel\\Sistema\\$pasta\\Update$model". "ViewModel";
    }

    public static function obterGridViewModel($pasta, $model){
        return "App\\ViewModel\\Sistema\\$pasta\\Grid$model". "ViewModel";
    }

    public static function obterRepositorio($pasta, $model){
        return "App\\Repositorio\\Sistema\\$pasta\\RepositorioDe$model";
    }

    public static function obterViewUpdate($model, $folder){
        $pasta = str_replace("\\", ".", $folder);
        return strtolower("$pasta.update$model");
    }

    public static function ValidarAlias($validador, $model){
        if(method_exists($model, ControllerEnum::InserirAlterarValidarAlias))
            $validador->setAttributeNames($model->validarAlias());
    }

    public static function ValidarAntesDeAlterar($model, $dados){
        $validator = null;
        if(method_exists($model, ControllerEnum::ValidarAntesDeAlterar)){
            $validator = Validator::make($dados->toArray(), $model->validarAntesDeAlterar($dados->id), $model->mensagemAlias);
            HelperDeControllerGridUpdateBase::ValidarAlias($validator, $model);
        }else
            $validator = Validator::make(array(), array());

        return $validator;
    } 

    public static function ValidarAntesDeDeletar($model, $dados){
        $validator = null;
        if(method_exists($model, ControllerEnum::ValidarAntesDeDeletar)){
            $validator = Validator::make($dados->toArray(), $model->validarAntesDeDeletar($dados->id), $model->mensagemAlias);
            HelperDeControllerGridUpdateBase::ValidarAlias($validator, $model);
        }else
            $validator = Validator::make(array(), array());

        return $validator;
    } 
}