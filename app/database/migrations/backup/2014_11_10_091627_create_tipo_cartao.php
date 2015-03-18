<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoCartao extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::hasTable('tipos_cartao') ?  : Schema::create('tipos_cartao', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('nome', 255);
        });
        
        Schema::table('protocolos', function (Blueprint $table)
        {
            $table->integer('tipo_cartao_id')->unsigned();
            $table->foreign('tipo_cartao_id')
                ->references('id')
                ->on('tipos_cartao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
