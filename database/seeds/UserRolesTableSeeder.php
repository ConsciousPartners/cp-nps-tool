<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \DB::table('roles')->delete();

    \DB::table('roles')->insert(array(
      0 => 
      array (
        'id' => 1,
        'name' => 'admin',
        'display_name' => 'Admin',
      )
    ));
  }
}
