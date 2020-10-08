<?php

namespace App\Helper\Controller;

use DB;
use App\Extension\MapperExtension;
use App\Enums\Controller\ControllerEnum;

class HelperDropDownList
{
    public static function obter($model, $request){
        $parametro = $request != null ? $request->all()['parametro'] : '';

        return $model::where("descricao", 'LIKE', '%'. $parametro. '%')
            ->select(DB::raw('id, UPPER(CONCAT(id, " - ", descricao)) text'))
            ->get()
            ->toArray();
    }

    public static function obterDinamico($model, $request, $campo, $campoDescricao = 'descricao'){
        $parametro = $request != null ? $request->all()['parametro'] : '';

        return $model::select(DB::raw('id, UPPER(CONCAT(' . $campo .', " - ", ' . $campoDescricao .')) text'))
            ->whereRaw("$campo LIKE '%$parametro%' OR $campoDescricao LIKE '%$parametro%'")
            ->get();
    }

    public static function obterDinamicoWhere($model, $request, $campos, $where){
        $parametro = $request != null ? $request->all()['parametro'] : '';

        return $model::where("descricao", 'LIKE', '%'. $parametro. '%')
            ->select(DB::raw('id, UPPER(CONCAT(id, " - ", descricao)) text'), DB::raw(collect($campos)->implode(', ')))
            ->whereRaw("id LIKE '%$parametro%' OR descricao LIKE '%$parametro%'")
            ->get();
    }

    public static function obterBase($model, $request){
        $parametro = $request != null ? $request->all()['parametro'] : '';

        return $model::whereRaw("descricao LIKE '%$parametro%'")
            ->select(DB::raw('id, UPPER(CONCAT(id, " - ", descricao)) text'))
            ->get()
            ->toArray();
    }

    public static function obterProduto($model, $request){
        $parametro = $request != null ? $request->all()['parametro'] : '';

        return $model::select(DB::raw('id, UPPER(CONCAT(id," - ",descricao)) text, preco as preco, idunidademedida'))
            ->whereRaw("id LIKE '%$parametro%' OR descricao LIKE '%$parametro%'")
            ->limit(50)->offset(0)->get();
    }

    public static function obterProdutoNotaFiscal($model, $request){
        $parametro = $request != null ? $request->all()['parametro'] : '';

        $db = DB::connection(\Session::get('usuario_banco'));
        $sql = @("SELECT
                id,
                UPPER(CONCAT(id,' - ',descricao)) text,
                preco,
                idunidademedida,
                idcsticms,
                if(idcfop > 0,
		                (idcfop),
		                (select idfiscalcfopdentroestado from empresa where id = idempresa)) as idcfop,
                idempresa,
                (select UPPER(CONCAT(id,' - ',descricao)) from csticms where id = idcsticms) as descricaocsticms,
                icms,
                if(idcfop > 0,
		                (select UPPER(CONCAT(id,' - ',descricao)) from fiscalcfop where id = idcfop),
		                (select UPPER(CONCAT(id,' - ',descricao)) from fiscalcfop where id = (select idfiscalcfopdentroestado from empresa where id = idempresa) )) as descricaocfop
                FROM produto
                    WHERE id LIKE '%$parametro%' OR descricao LIKE '%$parametro%' limit 30");

        return $db->select(DB::raw($sql));
    }

    public static function jsonEncode($text) {
        return json_encode( $text, JSON_UNESCAPED_UNICODE );
    }

    public static function obterBasico($model){
        return $model::select(DB::raw('id, UPPER(CONCAT(id, " - ", descricao)) descricao'))->get();
    }

    public static function obterBasicoViewModel($model, $codigo = "id"){
        return $model::select(DB::raw('id, UPPER(CONCAT('.$codigo.', " - ", descricao)) descricao'))->get();
    }

    public static function obterBasicoWhere($model, $request, $where, $campoDescricao = 'descricao'){
         $parametro = $request != null ? $request->all()['parametro'] : '';

        return $model::select(DB::raw("id, UPPER(CONCAT(id, ' - ', $campoDescricao)) text"))
            ->whereRaw($where . " AND $campoDescricao LIKE '%$parametro%'")
            ->get()
            ->toArray();
    }

    public static function obterWhere($model, $where){
        return $model::select(DB::raw('id, UPPER(CONCAT(id, " - ", descricao)) text'))
            ->whereRaw($where)
            ->get();
    }
}