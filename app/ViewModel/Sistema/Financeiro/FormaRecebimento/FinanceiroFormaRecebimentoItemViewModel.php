<?php

namespace App\ViewModel\Sistema\Financeiro\FormaRecebimento;

use App\ViewModel\BaseViewModel;

class FinanceiroFormaRecebimentoItemViewModel extends BaseViewModel {

    const CAMPOS = array('id' => '', 'utilizacompra' => 1, 'utilizavenda' => 1, 'descricao' => '', 'numeroparcelas' => 0, 'recorrencia' => 0, 'diaprimeiraparcela' => 0);

    public function rules()
    {
        return [
          //  'descricao' => 'required',
        ];
    }
}