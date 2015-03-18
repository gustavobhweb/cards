<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEntrega extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::hasTable('tipos_entrega') ?  : Schema::create('tipos_entrega', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('nome', 255);
        });
        
        Schema::table('protocolos', function (Blueprint $table)
        {
            $table->integer('tipo_entrega_id')->unsigned();
            $table->foreign('tipo_entrega_id')
                ->references('id')
                ->on('tipos_entrega');
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
