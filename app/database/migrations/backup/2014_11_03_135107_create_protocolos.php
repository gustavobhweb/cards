<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolos extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocolos', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->integer('remessa_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios');
            $table->foreign('remessa_id')
                ->references('id')
                ->on('remessas');
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
