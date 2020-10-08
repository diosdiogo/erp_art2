<?php

namespace App\Models\Sistema\Usuario;

use App\Models\BaseModelAtivacao;

class Usuario extends BaseModelAtivacao
{   
    protected $table = "user";

    protected $fillable = ['ativo',
                        'name',
                        'email',
                        'supervisor',
                        'imagem',
                        'idempresafilial',
                        'password'];

    public function validarInserir(){
        return [
            'name' => 'required|max:100',
            'email' => 'required|max:100',
            'usuarioAtualSupervisor' => "not_in:0"
        ];
    }

    public function validarAntesDeDeletar(){
        return [
            'usuariomobi' => "not_in:1",
            'usuarioAtualSupervisor' => "not_in:0"
        ];
    }        

    public function validarAntesDeAlterar(){
        return [
            'usuariomobi' => 'not_in:1',
            'usuarioAtualSupervisor' => "not_in:0"
        ];
    }

    public function validarAlias(){
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'supervisor' => 'Supervisor',        
        ];
    }

    public $mensagemAlias = [
        'usuariomobi.not_in' => 'Não é possivel alterar ou deletar usuário [MOBI]',
        'usuarioAtualSupervisor.not_in' => 'Está operação só é permitida para usuários administradores'
    ]; 
}
