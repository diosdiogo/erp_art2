<?php

namespace App\Constants\NFe;

abstract class NfeConstant
{
    const VERSAO = "4.00";
    const MODELO = "55";
    const NFeNORMAL = "1";
    const OperacaoInterna = "1";
    const OperacaoInterestadual = "2";
    const CodigoBrasil = "1058";
    const Brasil = "Brasil";


    public function NFeOperacao(){
        return (object) [
            '' => '',
            '' => '',
            '' => '',
        ];
    }
    //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
}