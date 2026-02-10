<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Subprocess;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasSubProcessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRoleName = RoleEnum::SUPER_ADMIN;

        // 1. Encontrar al usuario superadministrador.
        $superAdmin = User::whereHas('roles', function ($query) use ($superAdminRoleName) {
            $query->where('name', $superAdminRoleName);
        })->first();

        // 2. Si no existe el superadministrador, no hacer nada.
        if (! $superAdmin) {
            return;
        }

        // 3. Obtener todos los subprocesos.
        $subprocesses = Subprocess::pluck('id');

        // 4. Preparar los datos para la inserción.
        $data = $subprocesses->map(function ($subprocessId) use ($superAdmin) {
            return [
                'user_id' => $superAdmin->id,
                'subprocess_id' => $subprocessId,
            ];
        })->all();

        // 5. Insertar las relaciones en la tabla pivote.
        DB::table('user_has_sub_processes')->insert($data);
    }
}
