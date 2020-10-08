<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCacheTable extends BaseMigration
{
      public function __construct()
    {
        parent::__construct("cache");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');
        });
    }
}
