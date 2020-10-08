<?php

namespace App\Extension;

class CommonExtension
{
    public static function in($valor, $comparador = array()){
        return in_array($valor, $comparador);
    }

    public static function formatarParaMoeda($valor){
        return sprintf('R$ %s', number_format($valor, 2, ',', '.'));
    }

    public static function formatarParaQuantidade($valor){
        return sprintf('%s', number_format($valor, 2, ',', '.'));
    }

    public static function formatarTextoParaDecimal($valor){
        return str_replace(",", ".", str_replace(".", "", $valor));
    }

    public static function removerVirgulaPorPonto($valor){
        return str_replace(",", ".",  $valor);
    }

    public static function numero($valor){
        return number_format(round((float)($valor),4),2);
    }

    public static function formatarParaMoedaDecimal($valor){
        return sprintf('%s', number_format($valor, 2, ',', ''));
    }

    public static function adicionarCodigoEDescricao($model, $idCampo = 'id', $campo = 'descricao'){
        $retorno = "";
        if($model != null && $model[$idCampo])
            $retorno =  $model[$idCampo] . ' - ' . strtoupper($model[$campo]);
        else if($model['descricao'])
            $retorno =  $model['id'] . ' - ' . strtoupper($model['descricao']);
        else
            $retorno =  $model['id'] . ' - ' . strtoupper($model['nomefantasia']);

        return $retorno;
    }

    public static function codigoEDescricaoPessoa($model){
        $retorno = "";
        if($model != null && $model['id'])
            $retorno =  $model['id'] . ' - ' . strtoupper($model['razaosocial']);

        return $retorno;
    }

    public static function formatarData($data, $formato = 'd/m/Y'){
        return date_format($data, $formato);
    }

    public static function stringZero($string, $valorStr = 6){
        $quantidade = strlen($string);
        return str_pad("" .$string, $valorStr, "0", STR_PAD_LEFT);
    }

    public static function mascaraGenerica($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++)
        {
            if($mask[$i] == '#')
            {
                if(isset($val[$k]))
                $maskared .= $val[$k++];
            }
            else
            {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public static function removerCNPJ($cnpj){
        return preg_replace("/\D+/", "", $cnpj);
    }

    public static function removerMascaraIE($ie){
        return preg_replace("/\D+/", "", $ie);
    }

    public static function removerMascaraCEP($cep){
        return str_replace("-", "", $cep);
    }
    
    public static function removerMascaraTelefone($telefone){
        return preg_replace("/[\(\)\.\s-]+/", "", $telefone);
    }

    public static function formatarCNPJ($cnpj){
        return CommonExtension::mascaraGenerica($cnpj, "##.###.###/####-##");
    }

}