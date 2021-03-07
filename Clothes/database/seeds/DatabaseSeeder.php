<?php
/**
 * File name: DatabaseSeeder.php
 * Last modified: 2020.05.03 at 13:40:04
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CustomFieldsTableSeeder::class);
        $this->call(CustomFieldValuesTableSeeder::class);
        $this->call(AppSettingsTableSeeder::class);
        $this->call(ShopTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(FaqCategoriesTableSeeder::class);
        $this->call(OrderStatusesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(ExtraGroupsTableSeeder::class);

        $this->call(ClothesTableSeeder::class);
        $this->call(GalleriesTableSeeder::class);
        $this->call(ClothesReviewsTableSeeder::class);
        $this->call(CartsTableSeeder::class);
        $this->call(ExtrasTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);

        $this->call(ClothesOrdersTableSeeder::class);
        $this->call(CartExtrasTableSeeder::class);
        $this->call(UserShopsTableSeeder::class);
        $this->call(ClothesOrderExtrasTableSeeder::class);
        $this->call(FavoriteExtrasTableSeeder::class);

        $this->call(ShopReviewsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(DeliveryAddressesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);

        $this->call(MediaTableSeeder::class);
        $this->call(UploadsTableSeeder::class);
        $this->call(EarningsTableSeeder::class);
        $this->call(ShopsPayoutsTableSeeder::class);

        $this->call(SlidesSeeder::class);

        $this->call(OffersTableSeeder::class);
        $this->call(LikesTableSeeder::class);

        $this->call(SizeCategoryTableSeeder::class);
        $this->call(ColourCategoryTableSeeder::class);
        $this->call(ClothesCategoryTableSeeder::class);
        $this->call(ShopCategoryTableSeeder::class);
        $this->call(ClothesSizeCategoryTableSeeder::class);
        $this->call(ClothesColourCategoryTableSeeder::class);
        $this->call(ClothesCategoryClothesTableSeeder::class);
        $this->call(ShopCategoryShopTableSeeder::class);
        
        $this->call(RolesTableSeeder::class);
        $this->call(DemoPermissionsPermissionsTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(CouponPermission::class);

        $this->call(CoinStructureTableSeeder::class);
        
    }

}
