<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // \App\Models\User::factory(10)->create();
        $this->call(CreateUserSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionGroupsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(SystemSettingsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(SeoMetasTableSeeder::class);
        $this->call(GalleryGroupTableSeeder::class);
        $this->call(BlogCategoriesTableSeeder::class);
        $this->call(ImageGalleryTableSeeder::class);
        $this->call(BlogTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(MenuDropdownTableSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(CouponCodesTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(OddsJamSportsBookSeeder::class);
        $this->call(OddsjamgameeventcronjobsTableSeeder::class);
        $this->call(SportsbooksTableSeeder::class);
    }
}
