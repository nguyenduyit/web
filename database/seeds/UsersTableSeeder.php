<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Roles;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Admin::truncate();
        DB::table('admin_roles')->truncate();
        $adminRoles=Roles::where('name','admin')->first();
        $authorRoles=Roles::where('name','author')->first();
        $userRoles=Roles::where('name','user')->first();

        $admin=Admin::create([
            'admin_name'=>'Nguyen Duy',
            'admin_password' => md5(123456),
            'admin_phone'=>'0843085178',
            'admin_email'=>'nguyenngocduy100899@gmail.com'
        ]);

        $author=Admin::create([
            'admin_name'=>'Lam Phong',
            'admin_password' => md5(123456),
            'admin_phone'=>'0843085178',
            'admin_email'=>'lam032646@gmail.com'
        ]);

        $user=Admin::create([
            'admin_name'=>'Ngoc Duy',
            'admin_password' => md5(123456),
            'admin_phone'=>'0843085178',
            'admin_email'=>'nguyenphongcm10@gmail.com'
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        factory(App\Admin::class,5)->create();
    }
}
