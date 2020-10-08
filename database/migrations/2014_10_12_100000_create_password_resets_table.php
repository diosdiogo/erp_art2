<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends BaseMigrationAtivacao
{
    public function __construct()
    {
        parent::__construct("password_resets");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }
}
