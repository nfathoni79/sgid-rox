<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fish"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SG.id</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <x-nav-item
        :active="request()->routeIs('home.*')"
        :href="route('home.index')"
        icon="fas fa-fw fa-tachometer-alt"
        text="Dashboard"/>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Entry
    </div>

    <!-- Nav Item - Outlets -->
    <x-nav-item
        :active="request()->routeIs('outlets.*')"
        :href="route('outlets.index')"
        icon="fas fa-fw fa-store"
        text="Outlets"/>

    <!-- Nav Item - Products -->
    <x-nav-item
        :active="request()->routeIs('products.*')"
        :href="route('products.index')"
        icon="fas fa-fw fa-fish"
        text="Products"/>

    <!-- Nav Item - Orders -->
    <x-nav-item
        :active="request()->routeIs('orders.*')"
        :href="route('orders.index')"
        icon="fas fa-fw fa-redo"
        text="Orders"/>

    <!-- Nav Item - Product Orders -->
    <x-nav-item
        :active="request()->routeIs('product-orders.*')"
        :href="route('product-orders.index')"
        icon="fas fa-fw fa-fish"
        text="Product Orders"/>

    <!-- Nav Item - New Orders -->
    <x-nav-item
        :active="request()->routeIs('new-orders.*')"
        :href="route('new-orders.index')"
        icon="fas fa-fw fa-redo"
        text="New Orders"/>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card">
        <img class="sidebar-card-illustration mb-2" src="{{ asset('img/undraw_rocket.svg') }}" alt="">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div>

</ul>
<!-- End of Sidebar -->
