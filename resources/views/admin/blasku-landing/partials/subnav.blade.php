<div class="mb-6 flex flex-wrap gap-2">
    <a
        href="{{ route('admin.blasku-landing.overview') }}"
        class="subnav-link {{ request()->routeIs('admin.blasku-landing.overview') ? 'subnav-link-active' : '' }}"
    >
        Ringkasan
    </a>
    <a
        href="{{ route('admin.blasku-landing.pricing.index') }}"
        class="subnav-link {{ request()->routeIs('admin.blasku-landing.pricing.*') || request()->routeIs('admin.blasku-landing.pricing-plans.*') ? 'subnav-link-active' : '' }}"
    >
        Pricing
    </a>
    <a
        href="{{ route('admin.blasku-landing.installer.index') }}"
        class="subnav-link {{ request()->routeIs('admin.blasku-landing.installer.*') ? 'subnav-link-active' : '' }}"
    >
        Installer
    </a>
    <a
        href="{{ route('admin.blasku-landing.trial.index') }}"
        class="subnav-link {{ request()->routeIs('admin.blasku-landing.trial.*') ? 'subnav-link-active' : '' }}"
    >
        Trial
    </a>
    <a
        href="{{ route('admin.blasku-landing.contact.index') }}"
        class="subnav-link {{ request()->routeIs('admin.blasku-landing.contact.*') ? 'subnav-link-active' : '' }}"
    >
        Contact
    </a>
</div>
