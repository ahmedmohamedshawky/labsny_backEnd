@can('dashboard')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{!! url('dashboard') !!}">@if($icons)
                <i class="nav-icon fa fa-dashboard"></i>@endif
            <p>{{trans('lang.dashboard')}}</p></a>
    </li>
@endcan

@can('favorites.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('favorites*') ? 'active' : '' }}" href="{!! route('favorites.index') !!}">@if($icons)
                <i class="nav-icon fa fa-heart"></i>@endif<p>{{trans('lang.favorite_plural')}}</p></a>
    </li>
@endcan

<li class="nav-header">{{trans('lang.app_management')}}</li>

@can('shops.index')
    <li class="nav-item has-treeview {{ (Request::is('shops*') || Request::is('requestedShops*') || Request::is('galleries*') || Request::is('shopReviews*')) && !Request::is('shopsPayouts*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ (Request::is('shops*') || Request::is('requestedShops*') || Request::is('galleries*') || Request::is('shopReviews*')) && !Request::is('shopsPayouts*')? 'active' : '' }}"> @if($icons)
                <i class="nav-icon fa fa-cutlery"></i>@endif
            <p>{{trans('lang.shop_plural')}} <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('shops.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('shops*') ? 'active' : '' }}" href="{!! route('shops.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-cutlery"></i>@endif<p>{{trans('lang.shop_plural')}}</p></a>
                </li>
            @endcan
            @can('galleries.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('galleries*') ? 'active' : '' }}" href="{!! route('galleries.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-image"></i>@endif<p>{{trans('lang.gallery_plural')}}</p></a>
                </li>
            @endcan
            @can('shopReviews.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('shopReviews*') ? 'active' : '' }}" href="{!! route('shopReviews.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-comments"></i>@endif<p>{{trans('lang.shop_review_plural')}}</p></a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

{{-- @can('categories.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('categories*') ? 'active' : '' }}" href="{!! route('categories.index') !!}">@if($icons)
                <i class="nav-icon fa fa-folder"></i>@endif<p>{{trans('lang.category_plural')}}</p></a>
    </li>
@endcan --}}

{{-- @can('colourCategories.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('colourCategories*') ? 'active' : '' }}" href="{!! route('colourCategories.index') !!}">@if($icons)
                <i class="nav-icon fa fa-folder"></i>@endif<p>{{trans('lang.colour_category_plural')}}</p></a>
    </li>
@endcan --}}

{{-- @can('sizeCategories.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('sizeCategories*') ? 'active' : '' }}" href="{!! route('sizeCategories.index') !!}">@if($icons)
                <i class="nav-icon fa fa-folder"></i>@endif<p>{{trans('lang.size_category_plural')}}</p></a>
    </li>
@endcan --}}

{{-- @can('clothesCategories.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('clothesCategories*') ? 'active' : '' }}" href="{!! route('clothesCategories.index') !!}">@if($icons)
                <i class="nav-icon fa fa-folder"></i>@endif<p>{{trans('lang.clothes_category_plural')}}</p></a>
    </li>
@endcan --}}

{{-- @can('shopCategories.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('shopCategories*') ? 'active' : '' }}" href="{!! route('shopCategories.index') !!}">@if($icons)
                <i class="nav-icon fa fa-folder"></i>@endif<p>{{trans('lang.shop_category_plural')}}</p></a>
    </li>
@endcan --}}

@can('categories.index')
    <li class="nav-item has-treeview {{ (Request::is('categories*') || Request::is('colourCategories*') || Request::is('sizeCategories*') ||
        Request::is('clothesCategories*') || Request::is('shopCategories*')) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ (Request::is('categories*') || Request::is('colourCategories*') || Request::is('sizeCategories*') || 
            Request::is('clothesCategories*') || Request::is('shopCategories*')) ? 'active' : '' }}"> @if($icons)
                <i class="nav-icon fa fa-cutlery"></i>@endif
            <p>{{trans('lang.category_plural')}} <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('categories.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('categories*') ? 'active' : '' }}" href="{!! route('categories.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-cutlery"></i>@endif<p>{{trans('lang.category_plural')}}</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('subcategory*') ? 'active' : '' }}" href="{!! route('subcategory.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-arrow-circle-right "></i>@endif<p>SubCategories</p></a>
                </li>
            @endcan
            @can('colourCategories.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('colourCategories*') ? 'active' : '' }}" href="{!! route('colourCategories.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-image"></i>@endif<p>{{trans('lang.colour_category_plural')}}</p></a>
                </li>
            @endcan
            @can('sizeCategories.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sizeCategories*') ? 'active' : '' }}" href="{!! route('sizeCategories.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-image"></i>@endif<p>{{trans('lang.size_category_plural')}}</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('subcategory*') ? 'active' : '' }}" href="{!! route('subsize.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-arrow-circle-right "></i>@endif<p>Sub Size</p></a>
                </li>
            @endcan
            @can('clothesCategories.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('clothesCategories*') ? 'active' : '' }}" href="{!! route('clothesCategories.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-comments"></i>@endif<p>{{trans('lang.clothes_category_plural')}}</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('subcategory*') ? 'active' : '' }}" href="{!! route('clothessubcategory.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-arrow-circle-right "></i>@endif<p>Clothes SubCategories</p></a>
                </li>
            @endcan
            @can('shopCategories.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('shopCategories*') ? 'active' : '' }}" href="{!! route('shopCategories.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-comments"></i>@endif<p>{{trans('lang.shop_category_plural')}}</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('subcategory*') ? 'active' : '' }}" href="{!! route('shopsubcategory.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-arrow-circle-right "></i>@endif<p>Shop subcategory</p></a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

@can('clothes.index')
    <li class="nav-item has-treeview {{ Request::is('clothes*') || Request::is('extra*') || Request::is('clothesReviews*') || Request::is('nutrition*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('clothes*') || Request::is('extra*') || Request::is('clothesReviews*') || Request::is('nutrition*') ? 'active' : '' }}"> @if($icons)
                <i class="nav-icon fa fa-fire"></i>@endif
            <p>{{trans('lang.clothes_plural')}} <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('clothes.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('clothes*') ? 'active' : '' }}" href="{!! route('clothes.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-fire"></i>@endif
                        <p>{{trans('lang.clothes_plural')}}</p></a>
                </li>
            @endcan
            @can('extraGroups.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('extraGroups*') ? 'active' : '' }}" href="{!! route('extraGroups.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-plus-square"></i>@endif<p>{{trans('lang.extra_group_plural')}}</p></a>
                </li>
            @endcan
            @can('extras.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('extras*') ? 'active' : '' }}" href="{!! route('extras.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-plus-circle"></i>@endif<p>{{trans('lang.extra_plural')}}</p></a>
                </li>
            @endcan

            @can('clothesReviews.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('clothesReviews*') ? 'active' : '' }}" href="{!! route('clothesReviews.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-comments"></i>@endif<p>{{trans('lang.clothes_review_plural')}}</p></a>
                </li>
            @endcan


            @can('nutrition.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('nutrition*') ? 'active' : '' }}" href="{!! route('nutrition.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-tasks"></i>@endif<p>{{trans('lang.nutrition_plural')}}</p></a>
                </li>
            @endcan

        </ul>
    </li>
@endcan

@can('orders.index')
    <li class="nav-item has-treeview {{ Request::is('orders*') || Request::is('orderStatuses*') || Request::is('deliveryAddresses*')? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('orders*') || Request::is('orderStatuses*') || Request::is('deliveryAddresses*')? 'active' : '' }}"> @if($icons)
                <i class="nav-icon fa fa-shopping-basket"></i>@endif
            <p>{{trans('lang.order_plural')}} <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">

            @can('orders.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('orders*') ? 'active' : '' }}" href="{!! route('orders.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-shopping-basket"></i>@endif<p>{{trans('lang.order_plural')}}</p></a>
                </li>
            @endcan
            @can('orderStatuses.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('orderStatuses*') ? 'active' : '' }}" href="{!! route('orderStatuses.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-server"></i>@endif<p>{{trans('lang.order_status_plural')}}</p></a>
                </li>
            @endcan

            @can('deliveryAddresses.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('deliveryAddresses*') ? 'active' : '' }}" href="{!! route('deliveryAddresses.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-map"></i>@endif<p>{{trans('lang.delivery_address_plural')}}</p></a>
                </li>
            @endcan

        </ul>
    </li>
@endcan

@can('coupons.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('coupons*') ? 'active' : '' }}" href="{!! route('coupons.index') !!}">@if($icons)<i class="nav-icon fa fa-ticket"></i>@endif<p>{{trans('lang.coupon_plural')}}</p></a>
    </li>
@endcan

@can('offers.index')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('offers*') ? 'active' : '' }}" href="{!! route('offers.index') !!}">@if($icons)
                <i class="nav-icon fa fa-gift"></i>@endif<p>{{trans('lang.offer_plural')}}</p></a>
    </li>
@endcan

@can('faqs.index')
    <li class="nav-item has-treeview {{ Request::is('faqCategories*') || Request::is('faqs*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('faqs*') || Request::is('faqCategories*') ? 'active' : '' }}"> @if($icons)
                <i class="nav-icon fa fa-support"></i>@endif
            <p>{{trans('lang.faq_plural')}} <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @can('faqCategories.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('faqCategories*') ? 'active' : '' }}" href="{!! route('faqCategories.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-folder"></i>@endif<p>{{trans('lang.faq_category_plural')}}</p></a>
                </li>
            @endcan

            @can('faqs.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('faqs*') ? 'active' : '' }}" href="{!! route('faqs.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-question-circle"></i>@endif
                        <p>{{trans('lang.faq_plural')}}</p></a>
                </li>
            @endcan
        </ul>
    </li>
@endcan

<li class="nav-header">{{trans('lang.app_setting')}}</li>
@can('medias')
    <li class="nav-item">
        <a class="nav-link {{ Request::is('medias*') ? 'active' : '' }}" href="{!! url('medias') !!}">@if($icons)<i class="nav-icon fa fa-picture-o"></i>@endif
            <p>{{trans('lang.media_plural')}}</p></a>
    </li>
@endcan

@can('app-settings')
    <li class="nav-item has-treeview {{ Request::is('settings/mobile*') || Request::is('slides*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('settings/mobile*') || Request::is('slides*') ? 'active' : '' }}">
            @if($icons)<i class="nav-icon fa fa-mobile"></i>@endif
            <p>
                {{trans('lang.mobile_menu')}}
                <i class="right fa fa-angle-left"></i>
            </p></a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{!! url('settings/mobile/globals') !!}" class="nav-link {{  Request::is('settings/mobile/globals*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-cog"></i> @endif <p>{{trans('lang.app_setting_globals')}}
                        <span class="right badge badge-danger">New</span></p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/mobile/colors') !!}" class="nav-link {{  Request::is('settings/mobile/colors*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-pencil"></i> @endif <p>{{trans('lang.mobile_colors')}} <span class="right badge badge-danger">New</span>
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/mobile/home') !!}" class="nav-link {{  Request::is('settings/mobile/home*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-home"></i> @endif <p>{{trans('lang.mobile_home')}}
                        <span class="right badge badge-danger">New</span></p>
                </a>
            </li>

            @can('slides.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('slides*') ? 'active' : '' }}" href="{!! route('slides.index') !!}">@if($icons)<i class="nav-icon fa fa-magic"></i>@endif<p>{{trans('lang.slide_plural')}} <span class="right badge badge-danger">New</span></p></a>
                </li>
            @endcan
        </ul>

    </li>
    <li class="nav-item has-treeview {{
    (Request::is('settings*') ||
     Request::is('users*')) && !Request::is('settings/mobile*')
        ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{
        (Request::is('settings*') ||
         Request::is('users*')) && !Request::is('settings/mobile*')
          ? 'active' : '' }}"> @if($icons)<i class="nav-icon fa fa-cogs"></i>@endif
            <p>{{trans('lang.app_setting')}} <i class="right fa fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{!! url('settings/app/globals') !!}" class="nav-link {{  Request::is('settings/app/globals*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-cog"></i> @endif <p>{{trans('lang.app_setting_globals')}}</p>
                </a>
            </li>

            @can('users.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{!! route('users.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-users"></i>@endif
                        <p>{{trans('lang.user_plural')}}</p></a>
                </li>
            @endcan
            @can('permissions.index')
                <li class="nav-item has-treeview {{ Request::is('settings/permissions*') || Request::is('settings/roles*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('settings/permissions*') || Request::is('settings/roles*') ? 'active' : '' }}">
                        @if($icons)<i class="nav-icon fa fa-user-secret"></i>@endif
                        <p>
                            {{trans('lang.permission_menu')}}
                            <i class="right fa fa-angle-left"></i>
                        </p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('settings/permissions') ? 'active' : '' }}" href="{!! route('permissions.index') !!}">
                                @if($icons)<i class="nav-icon fa fa-circle-o"></i>@endif
                                <p>{{trans('lang.permission_table')}}</p>
                            </a>
                        </li>
                        @can('permissions.create')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('settings/permissions/create') ? 'active' : '' }}" href="{!! route('permissions.create') !!}">
                                    @if($icons)<i class="nav-icon fa fa-circle-o"></i>@endif
                                    <p>{{trans('lang.permission_create')}}</p>
                                </a>
                            </li>
                        @endcan
                        @can('roles.index')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('settings/roles') ? 'active' : '' }}" href="{!! route('roles.index') !!}">
                                    @if($icons)<i class="nav-icon fa fa-circle-o"></i>@endif
                                    <p>{{trans('lang.role_table')}}</p>
                                </a>
                            </li>
                        @endcan
                        @can('roles.create')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('settings/roles/create') ? 'active' : '' }}" href="{!! route('roles.create') !!}">
                                    @if($icons)<i class="nav-icon fa fa-circle-o"></i>@endif
                                    <p>{{trans('lang.role_create')}}</p>
                                </a>
                            </li>
                        @endcan
                    </ul>

                </li>
            @endcan

            <li class="nav-item">
                <a class="nav-link {{ Request::is('settings/customFields*') ? 'active' : '' }}" href="{!! route('customFields.index') !!}">@if($icons)
                        <i class="nav-icon fa fa-list"></i>@endif<p>{{trans('lang.custom_field_plural')}}</p></a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/app/localisation') !!}" class="nav-link {{  Request::is('settings/app/localisation*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-language"></i> @endif <p>{{trans('lang.app_setting_localisation')}}</p></a>
            </li>
            <li class="nav-item">
                <a href="{!! url('settings/translation/en') !!}" class="nav-link {{ Request::is('settings/translation*') ? 'active' : '' }}">
                    @if($icons) <i class="nav-icon fa fa-language"></i> @endif <p>{{trans('lang.app_setting_translation')}}</p></a>
            </li>
            @can('currencies.index')
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('settings/currencies*') ? 'active' : '' }}" href="{!! route('currencies.index') !!}">@if($icons)
                            <i class="nav-icon fa fa-dollar"></i>@endif<p>{{trans('lang.currency_plural')}}</p></a>
                </li>
            @endcan

            <li class="nav-item">
                <a href="{!! url('settings/payment/payment') !!}" class="nav-link {{  Request::is('settings/payment*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-credit-card"></i> @endif <p>{{trans('lang.app_setting_payment')}}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/app/social') !!}" class="nav-link {{  Request::is('settings/app/social*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-globe"></i> @endif <p>{{trans('lang.app_setting_social')}}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/app/notifications') !!}" class="nav-link {{  Request::is('settings/app/notifications*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-bell"></i> @endif <p>{{trans('lang.app_setting_notifications')}}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/mail/smtp') !!}" class="nav-link {{ Request::is('settings/mail*') ? 'active' : '' }}">
                    @if($icons)<i class="nav-icon fa fa-envelope"></i> @endif <p>{{trans('lang.app_setting_mail')}}</p>
                </a>
            </li>

        </ul>
    </li>
@endcan

