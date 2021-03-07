<?php

use Illuminate\Database\Seeder;

class CouponPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            \DB::table('permissions')->insert(array(

                array(
                    'id' => 157,
                    'name' => 'coupons.index',
                    'guard_name' => 'web',
                    'created_at' => '2020-08-23 14:58:02',
                    'updated_at' => '2020-08-23 14:58:02',
                    'deleted_at' => NULL,
                ),

                array(
                    'id' => 158,
                    'name' => 'coupons.create',
                    'guard_name' => 'web',
                    'created_at' => '2020-08-23 14:58:02',
                    'updated_at' => '2020-08-23 14:58:02',
                    'deleted_at' => NULL,
                ),

                array(
                    'id' => 159,
                    'name' => 'coupons.store',
                    'guard_name' => 'web',
                    'created_at' => '2020-08-23 14:58:02',
                    'updated_at' => '2020-08-23 14:58:02',
                    'deleted_at' => NULL,
                ),

                array(
                    'id' => 160,
                    'name' => 'coupons.edit',
                    'guard_name' => 'web',
                    'created_at' => '2020-08-23 14:58:02',
                    'updated_at' => '2020-08-23 14:58:02',
                    'deleted_at' => NULL,
                ),

                array(
                    'id' => 161,
                    'name' => 'coupons.update',
                    'guard_name' => 'web',
                    'created_at' => '2020-08-23 14:58:02',
                    'updated_at' => '2020-08-23 14:58:02',
                    'deleted_at' => NULL,
                ),

                array(
                    'id' => 162,
                    'name' => 'coupons.destroy',
                    'guard_name' => 'web',
                    'created_at' => '2020-08-23 14:58:02',
                    'updated_at' => '2020-08-23 14:58:02',
                    'deleted_at' => NULL,
                ),
            ));

            \DB::table('role_has_permissions')->insert(array(
                array(
                    'permission_id' => 157,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 158,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 159,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 160,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 161,
                    'role_id' => 2,
                ),
                array(
                    'permission_id' => 162,
                    'role_id' => 2,
                ),

            ));
        } catch (Exception $exception) {
        }
    }
}
