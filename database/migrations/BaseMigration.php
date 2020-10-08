<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// AuthenticatesUsers | Quando atualizar o .json colocar no model  return str_replace('_','',str_replace('\\', '', Str::snake((class_basename($this)))));//str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
class BaseMigration extends Migration
{
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
