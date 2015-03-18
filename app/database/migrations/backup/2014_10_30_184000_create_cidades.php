<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidades extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table)
        {
            $table->increments('id', true);
            $table->string('nome', 255);
            $table->integer('uf_id')->unsigned();
            $table->timestamps();
            $table->foreign('uf_id')
                ->references('id')
                ->on('ufs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cidades');
    }
}
