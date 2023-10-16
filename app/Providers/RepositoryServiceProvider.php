<?php

namespace App\Providers;

use App\Services\SystemSettings\Repositories\SystemSettingRepository;
use App\Services\SystemSettings\Repositories\SystemSettingRepositoryInterface;
use App\Services\Users\Repositories\UserRepository;
use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\PermissionGroups\Repositories\PermissionGroupRepository;
use App\Services\PermissionGroups\Repositories\PermissionGroupRepositoryInterface;
use App\Services\Permissions\Repositories\PermissionRepository;
use App\Services\Permissions\Repositories\PermissionRepositoryInterface;
use App\Services\Roles\Repositories\RoleRepository;
use App\Services\Roles\Repositories\RoleRepositoryInterface;
use App\Services\Pages\Repositories\PageRepository;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\SeoMetas\Repositories\SeoMetasRepository;
use App\Services\SeoMetas\Repositories\SeoMetasRepositoryInterface;
use App\Services\Sections\Repositories\SectionRepository;
use App\Services\Sections\Repositories\SectionRepositoryInterface;
use App\Services\Sections\Repositories\SectionDisplayHandler;
use App\Services\Sections\Repositories\SectionDisplayHandlerInterface;
use App\Services\GalleryGroups\Repositories\GalleryGroupRepository;
use App\Services\GalleryGroups\Repositories\GalleryGroupRepositoryInterface;
use App\Services\GalleryImages\Repositories\GalleryImageRepository;
use App\Services\GalleryImages\Repositories\GalleryImageRepositoryInterface;
use App\Services\BlogCategories\Repositories\BlogCategoryRepository;
use App\Services\BlogCategories\Repositories\BlogCategoryRepositoryInterface;
use App\Services\Blogs\Repositories\BlogRepository;
use App\Services\Blogs\Repositories\BlogRepositoryInterface;
use App\Services\Contacts\Repositories\ContactRepository;
use App\Services\Contacts\Repositories\ContactRepositoryInterface;
use App\Services\Newsletters\Repositories\NewsletterRepository;
use App\Services\Newsletters\Repositories\NewsletterRepositoryInterface;
use App\Services\Menus\Repositories\MenuRepository;
use App\Services\Menus\Repositories\MenuRepositoryInterface;
use App\Services\MenuDropdowns\Repositories\MenuDropdownRepository;
use App\Services\MenuDropdowns\Repositories\MenuDropdownRepositoryInterface;
//ecommerce
use App\Services\UserAddressDetails\Repositories\UserAddressDetailRepository;
use App\Services\UserAddressDetails\Repositories\UserAddressDetailRepositoryInterface;
use App\Services\ProductCategories\Repositories\ProductCategoryRepository;
use App\Services\ProductCategories\Repositories\ProductCategoryRepositoryInterface;
use App\Services\Products\Repositories\ProductRepository;
use App\Services\Products\Repositories\ProductRepositoryInterface;
use App\Services\Carts\Repositories\CartRepository;
use App\Services\Carts\Repositories\CartRepositoryInterface;
use App\Services\CouponCodes\Repositories\CouponCodeRepository;
use App\Services\CouponCodes\Repositories\CouponCodeRepositoryInterface;
use App\Services\OrderAddressDetails\Repositories\OrderAddressDetailRepository;
use App\Services\OrderAddressDetails\Repositories\OrderAddressDetailRepositoryInterface;
use App\Services\OrderCouponDetails\Repositories\OrderCouponDetailsRepository;
use App\Services\OrderCouponDetails\Repositories\OrderCouponDetailsRepositoryInterface;
use App\Services\OrderItemDetails\Repositories\OrderItemDetailsRepository;
use App\Services\OrderItemDetails\Repositories\OrderItemDetailsRepositoryInterface;
use App\Services\OrderLogs\Repositories\OrderLogRepository;
use App\Services\OrderLogs\Repositories\OrderLogRepositoryInterface;
use App\Services\OrderPaymentDetails\Repositories\OrderPaymentDetailRepository;
use App\Services\OrderPaymentDetails\Repositories\OrderPaymentDetailRepositoryInterface;
use App\Services\OrderShippingDetails\Repositories\OrderShippingDetailRespository;
use App\Services\OrderShippingDetails\Repositories\OrderShippingDetailRespositoryInterface;
use App\Services\OrderTaxDetails\Repositories\OrderTaxDetailsRepository;
use App\Services\OrderTaxDetails\Repositories\OrderTaxDetailsRepositoryInterface;
use App\Services\Orders\Repositories\OrderRepository;
use App\Services\Orders\Repositories\OrderRepositoryInterface;
use App\Services\Cities\Repositories\CityRepository;
use App\Services\Cities\Repositories\CityRepositoryInterface;
use App\Services\Countries\Repositories\CountryRepository;
use App\Services\Countries\Repositories\CountryRepositoryInterface;
use App\Services\States\Repositories\StateRepository;
use App\Services\States\Repositories\StateRepositoryInterface;
use App\Services\CategoryPerProducts\Repositories\CategoryPerProductRepository;
use App\Services\CategoryPerProducts\Repositories\CategoryPerProductRepositoryInterface;
use App\Services\OddsJamGameEventCronJobs\Repositories\OddsJamGameEventCronJobRepository;
use App\Services\OddsJamGameEventCronJobs\Repositories\OddsJamGameEventCronJobRepositoryInterface;
use App\Services\SportsBooks\Repositories\SportsBookRepository;
use App\Services\SportsBooks\Repositories\SportsBookRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SystemSettingRepositoryInterface::class, SystemSettingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PermissionGroupRepositoryInterface::class, PermissionGroupRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        $this->app->bind(SeoMetasRepositoryInterface::class, SeoMetasRepository::class);
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(SectionDisplayHandlerInterface::class, SectionDisplayHandler::class);
        $this->app->bind(GalleryGroupRepositoryInterface::class, GalleryGroupRepository::class);
        $this->app->bind(GalleryImageRepositoryInterface::class, GalleryImageRepository::class);
        $this->app->bind(BlogCategoryRepositoryInterface::class, BlogCategoryRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(NewsletterRepositoryInterface::class, NewsletterRepository::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(MenuDropdownRepositoryInterface::class, MenuDropdownRepository::class);
        //ecommerce
        $this->app->bind(UserAddressDetailRepositoryInterface::class, UserAddressDetailRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CouponCodeRepositoryInterface::class, CouponCodeRepository::class);
        $this->app->bind(OrderAddressDetailRepositoryInterface::class, OrderAddressDetailRepository::class);
        $this->app->bind(OrderCouponDetailsRepositoryInterface::class, OrderCouponDetailsRepository::class);
        $this->app->bind(OrderItemDetailsRepositoryInterface::class, OrderItemDetailsRepository::class);
        $this->app->bind(OrderLogRepositoryInterface::class, OrderLogRepository::class);
        $this->app->bind(OrderPaymentDetailRepositoryInterface::class, OrderPaymentDetailRepository::class);
        $this->app->bind(OrderShippingDetailRespositoryInterface::class, OrderShippingDetailRespository::class);
        $this->app->bind(OrderTaxDetailsRepositoryInterface::class, OrderTaxDetailsRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(CategoryPerProductRepositoryInterface::class, CategoryPerProductRepository::class);
        $this->app->bind(OddsJamGameEventCronJobRepositoryInterface::class, OddsJamGameEventCronJobRepository::class);
        $this->app->bind(SportsBookRepositoryInterface::class, SportsBookRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
