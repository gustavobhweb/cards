<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStatus extends Migration
{

    /**
     * Run the migrations.
     *
     *
     * @return void
     */
    public function up()
    {
        DB::table('status')->delete();
        
        DB::table('status')->update(array(
            array(
                'id' => '1',
                'titulo' => 'Aguardando solicitação',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '2',
                'titulo' => 'Análise da foto',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '3',
                'titulo' => 'Fabricação',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '4',
                'titulo' => 'Conferência',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '5',
                'titulo' => 'Saiu para entrega',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '6',
                'titulo' => 'Disponível para entrega',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '7',
                'titulo' => 'Entregue',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '8',
                'titulo' => 'Foto reprovada',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '9',
                'titulo' => 'Financeiro',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            ),
            array(
                'id' => '10',
                'titulo' => 'Conferido',
                'created_at' => '2014-10-30 14:06:57',
                'updated_at' => NULL
            )
        )
        );
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
