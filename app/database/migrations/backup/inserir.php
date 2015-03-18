<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InserirUsuario extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('usuarios')->delete();
        DB::table('niveis')->delete();
        DB::table('status')->delete();
        
        DB::table('niveis')->insert([
            
            [
                'id' => 1,
                'titulo' => 'Aluno'
            ],
            [
                'id' => 2,
                'titulo' => 'Produção'
            ],
            [
                'id' => 3,
                'titulo' => 'Administrador'
            ],
            [
                'id' => 4,
                'titulo' => 'Cliente'
            ],
            [
                'id' => 5,
                'titulo' => 'Conferente'
            ]
        ]);
        
        DB::table('status')->insert(array(
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
            )
        ));
        
        DB::table('usuarios')->insert([
            0 => [
                'username' => 'wallacemaxters@gmail.com',
                'password' => Hash::make('123456'),
                'cpf' => '09405098659',
                'matricula' => 123456,
                'nome' => 'Wallace',
                'nivel_id' => '1'
            ],
            
            1 => [
                'username' => 'wallacemaxters@gmail.com',
                'password' => Hash::make('123456'),
                'cpf' => '09405098659',
                'nome' => 'Cliente',
                'nivel_id' => '3',
                'matricula' => 123457
            ]
        ]
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
