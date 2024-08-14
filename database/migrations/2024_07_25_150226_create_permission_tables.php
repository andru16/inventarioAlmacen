<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->uuid('id')->primary(); // Cambiado a UUID
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) use ($columnNames) {
            $table->uuid('id')->primary(); // Cambiado a UUID
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });


        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $permissionMorphKey = $columnNames['permission_morph_key'] ?? 'permission_id'; // Proporciona un valor predeterminado
            $modelMorphKey = $columnNames['model_morph_key'] ?? 'model_id'; // Proporciona un valor predeterminado
            $table->uuid($permissionMorphKey);
            $table->string('model_type');
            $table->uuid($modelMorphKey);
            $table->foreign($permissionMorphKey)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            $table->primary([$permissionMorphKey, $modelMorphKey, 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $roleMorphKey = $columnNames['role_morph_key'] ?? 'role_id'; // Proporciona un valor predeterminado
            $modelMorphKey = $columnNames['model_morph_key'] ?? 'model_id'; // Reutiliza el valor predeterminado para model_morph_key
            $table->uuid($roleMorphKey);
            $table->string('model_type');
            $table->uuid($modelMorphKey);
            $table->foreign($roleMorphKey)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            $table->primary([$roleMorphKey, $modelMorphKey, 'model_type'],
                'model_has_roles_role_model_type_primary');
        });


        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $permissionId = $columnNames['permission_id'] ?? 'permission_id'; // Proporciona un valor predeterminado
            $roleId = $columnNames['role_id'] ?? 'role_id'; // Proporciona un valor predeterminado
            $table->uuid($permissionId)->comment('Foreign key for permissions table');
            $table->uuid($roleId)->comment('Foreign key for roles table');
            $table->foreign($permissionId)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');
            $table->foreign($roleId)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
            $table->primary([$permissionId, $roleId], 'role_has_permissions_permission_id_role_id_primary');
        });

    }

    public function down(): void {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
};
