<?php

namespace Database\Seeders;

use App\Models\Usuarios\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;
use Webpatser\Uuid\Uuid;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = new Usuario();
        DB::table('usuarios')->insert([
           'id' => Uuid::generate()->string,
            'nombre_completo' => 'Administrador',
            'correo_electronico' => 'afescobar043@misena.edu.co',
            'password' => $usuario->setPasswordAttribute('Andres123'),
        ]);
    }
}
