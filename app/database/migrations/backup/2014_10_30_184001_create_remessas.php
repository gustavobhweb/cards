<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemessas extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remessas', function (Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->tinyInteger('deletado');
            $table->tinyInteger('baixado');
            $table->integer('usuario_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('usuario_id')
                ->references('id')
                ->on('usuarios');
        });
        
        // Schema::hasTable('solicitacoes_remessa') ?: Schema::drop('solicitacoes_remessa');
        
        Schema::create('solicitacoes_remessa', function (Blueprint $table)
        {
            
            echo 'solicitacoes_remessa', PHP_EOL;
            
            $table->increments('id')->unsigned();
            $table->integer('solicitacao_id')->unsigned();
            $table->integer('remessa_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('solicitacao_id')
                ->references('id')
                ->on('solicitacoes');
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
        Schema::table('remessas', function (Blueprint $table)
        {
            //
        });
    }
}
