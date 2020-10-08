<?php

namespace App\Models\Sistema\Pessoa;

use App\Models\BaseModel;
use App\Models\Sistema\Pessoa\Pessoa;

class PesssoaEPessoaRelacao extends BaseModel
{
    protected $table = 'pessoaepessoarelacao';

    protected $fillable = ['idpessoa', 'idpessoarelacao'];

    public function __construct()
    {
        parent::__construct(false);
    }

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'idpessoarelacao');
    }
}
