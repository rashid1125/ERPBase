<?php
use App\Models\CommonFunctions;
use App\Models\MainnavModule;
use App\Models\SubmainnavModule;
use App\Models\AsideBar;
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= URL('user/dashboard') ?>" class="brand-link">
        <img src="{{ asset('assets/img/dm.png') }}" alt="Digitalmanager" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">DigitalManager</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Session::get('uname') ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact nav-legacy"
                data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                {{-- We are creating mainnav mudole --}}

                <?php $MainnavModules = MainnavModule::all(); ?>
                <!-- getting three tree  -->
                @if (count($MainnavModules) > 0)
                    @foreach ($MainnavModules as $MainnavModule)
                        @if ((int) $MainnavModule->is_visible == 1)
                            <?php $MainnavModule_display = ''; ?>
                            @if ((int) $MainnavModule->display == 0)
                                <?php $MainnavModule_display = 'd-none'; ?>
                            @endif
                            @if (CommonFunctions::_getValidRoleGroupUserPermissions('reports', $MainnavModule->module_rights))
                                <!-- validate rights of mainnav module -->
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon {{ $MainnavModule->module_icon }}"></i>
                                        <p>
                                            {{ $MainnavModule->module_name }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php $SubMainnavModules = SubmainnavModule::where('module_id', $MainnavModule->module_id)->get(); ?>
                                        <!-- getting sub tree  -->
                                        @if (count($SubMainnavModules) > 0)
                                            @foreach ($SubMainnavModules as $SubMainnavModule)
                                                @if ((int) $SubMainnavModule->is_visible == 1)
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link">
                                                            <i
                                                                class="nav-icon {{ $SubMainnavModule->sub_module_icon }}"></i>
                                                            <p>
                                                                {{ $SubMainnavModule->sub_module_name }}
                                                                <i class="right fas fa-angle-left"></i>
                                                            </p>
                                                        </a>
                                                        <ul class="nav nav-treeview">
                                                            <?php $AsideBarsData = AsideBar::_getMainnavLinks($MainnavModule->module_id, $SubMainnavModule->sub_module_id); ?>
                                                            @if (count($AsideBarsData) > 0)
                                                                @foreach ($AsideBarsData as $AsideBarData)
                                                                    @if ((int) $AsideBarData->is_visible == 1)
                                                                        {{-- voucher links and validate with given rights in rolegroups --}}
                                                                        @if ($AsideBarData->vr_type == 'vouchers')
                                                                            @if (!empty($AsideBarData->vr_post_method) && getPostingMethod($AsideBarData->vr_post_method))
                                                                                @if (CommonFunctions::_getValidRoleGroupUserPermissions('vouchers', $AsideBarData->vr_rights))
                                                                                    <li
                                                                                        class="nav-item voucher {{ $AsideBarData->vr_rights }}">
                                                                                        <a href="{{ url($AsideBarData->slug) }}"
                                                                                            class="nav-link">
                                                                                            <i
                                                                                                class="fas fa-plus nav-icon"></i>
                                                                                            <p>{{ $AsideBarData->vr_title }}
                                                                                            </p>
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endif


                                                                            @if (empty($AsideBarData->vr_post_method))
                                                                                @if (CommonFunctions::_getValidRoleGroupUserPermissions('vouchers', $AsideBarData->vr_rights))
                                                                                    <li
                                                                                        class="nav-item voucher {{ $AsideBarData->vr_rights }}">
                                                                                        <a href="{{ url($AsideBarData->slug) }}"
                                                                                            class="nav-link">
                                                                                            <i
                                                                                                class="fas fa-plus nav-icon"></i>
                                                                                            <p>{{ $AsideBarData->vr_title }}
                                                                                            </p>
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        {{-- end voucher links and validate with given rights in rolegroups --}}


                                                                        {{-- reports links and validate with given rights in rolegroups --}}
                                                                        @if ($AsideBarData->vr_type == 'reports')
                                                                            @if (!empty($AsideBarData->vr_post_method) && getPostingMethod($AsideBarData->vr_post_method))
                                                                                @if (CommonFunctions::_getValidRoleGroupUserPermissions('reports', $AsideBarData->vr_rights))
                                                                                    <li
                                                                                        class="nav-item report {{ $AsideBarData->vr_rights }}">
                                                                                        <a href="{{ url($AsideBarData->slug) }}"
                                                                                            class="nav-link">
                                                                                            <i
                                                                                                class="fas fa-plus nav-icon"></i>
                                                                                            <p>{{ $AsideBarData->vr_title }}
                                                                                            </p>
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endif


                                                                            @if (empty($AsideBarData->vr_post_method) && (int) $AsideBarData->is_tax == 0)
                                                                                @if (CommonFunctions::_getValidRoleGroupUserPermissions('reports', $AsideBarData->vr_rights))
                                                                                    <li
                                                                                        class="nav-item report {{ $AsideBarData->vr_rights }}">
                                                                                        <a href="{{ url($AsideBarData->slug) }}"
                                                                                            class="nav-link">
                                                                                            <i
                                                                                                class="fas fa-plus nav-icon"></i>
                                                                                            <p>{{ $AsideBarData->vr_title }}
                                                                                            </p>
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endif


                                                                            @if (empty($AsideBarData->is_tax == 1) && Session::get('tax') == 0)
                                                                                @if (CommonFunctions::_getValidRoleGroupUserPermissions('reports', $AsideBarData->vr_rights))
                                                                                    <li
                                                                                        class="nav-item report {{ $AsideBarData->vr_rights }}">
                                                                                        <a href="{{ url($AsideBarData->slug) }}"
                                                                                            class="nav-link">
                                                                                            <i
                                                                                                class="fas fa-plus nav-icon"></i>
                                                                                            <p>{{ $AsideBarData->vr_title }}
                                                                                            </p>
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        {{-- end reports links and validate with given rights in rolegroups --}}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
