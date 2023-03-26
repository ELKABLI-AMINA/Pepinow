<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'consulter_plantes']);
        Permission::create(['name' => 'créer_plante']);
        Permission::create(['name' => 'éditer_plantes']);
        Permission::create(['name' => 'supprimer_plantes']);
        Permission::create(['name' => 'supprimer_categorie']);
        Permission::create(['name' => 'editer_categorie']);
        Permission::create(['name' => 'creer_categorie']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo(['consulter_plantes']);

        // or may be done by chaining
        $role = Role::create(['name' => 'vendeur'])
            ->givePermissionTo([ 'consulter_plantes','créer_plante','éditer_plantes', 'supprimer_plantes', 'supprimer_categorie']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(['consulter_plantes','créer_plante', 'éditer_plantes', 'supprimer_plantes','creer_categorie', 'editer_categorie', 'supprimer_categorie']);
    }
}
