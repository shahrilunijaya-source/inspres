<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Auth\OfficerLogin::class)
            ->brandName('INPReS')
            ->brandLogo(fn () => new HtmlString(
                '<span class="ip-brand-row">'
                . '<img src="' . asset('img/logo_jata.png') . '" alt="Jata Negara" class="ip-brand-jata">'
                . '<img src="' . asset('img/logo_jpn.png') . '" alt="JPN" class="ip-brand-jpn">'
                . '<span class="ip-brand-text">INPReS</span>'
                . '</span>'
            ))
            ->brandLogoHeight('3.4rem')
            ->favicon(asset('img/logo_jpn.png'))
            ->colors([
                'primary' => Color::Blue,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::ScreenTwoExtraLarge)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\InternalModulesWidget::class,
                AccountWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make('Operasi Permohonan')->collapsible(),
                NavigationGroup::make('Pelaporan & Pengurusan')->collapsible(),
                NavigationGroup::make('Modul Penguatkuasaan')->collapsible(),
                NavigationGroup::make('Pengurusan Sistem')->collapsible(),
                NavigationGroup::make('Sokongan')->collapsible(),
            ])
            ->navigationItems($this->buildModuleNavigation())
            ->renderHook(PanelsRenderHook::HEAD_END, fn () => new HtmlString($this->panelHeadStyles()))
            ->renderHook(PanelsRenderHook::BODY_END, fn () => new HtmlString($this->panelBodyScripts()))
            ->renderHook(PanelsRenderHook::GLOBAL_SEARCH_BEFORE, function () {
                return new HtmlString(<<<'HTML'
                    <form action="/admin/applications" method="GET" class="ip-topbar-search" role="search">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ip-search-icon"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 3.42 9.806l3.137 3.137a.75.75 0 1 0 1.06-1.06l-3.137-3.137A5.5 5.5 0 0 0 9 3.5ZM5 9a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/></svg>
                        <input type="search" name="tableSearch" placeholder="Cari permohonan, no. KP, modul..." class="ip-search-input"/>
                        <kbd class="ip-search-kbd">⌘K</kbd>
                    </form>
                HTML);
            })
            ->renderHook(PanelsRenderHook::USER_MENU_BEFORE, function () {
                $u = auth()->user();
                if (!$u) return '';
                $name = e($u->name);
                $role = e($u->roleLabel());
                $date = now()->translatedFormat('l, d F Y');
                $unread = 3; // mock notification count
                return new HtmlString(<<<HTML
                    <button type="button" class="ip-bell" title="3 notifikasi baharu" onclick="alert('Notifikasi: 3 permohonan baharu memerlukan perhatian.')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.083 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.92 32.92 0 0 0 3.256-.508.75.75 0 0 0 .515-1.083A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6ZM8.05 14.943a33.54 33.54 0 0 0 3.9 0 2 2 0 0 1-3.9 0Z" clip-rule="evenodd"/></svg>
                        <span class="ip-bell-dot">{$unread}</span>
                    </button>
                    <div class="ip-topbar-welcome">
                        <span class="ip-tw-greet">Selamat datang,</span>
                        <strong class="ip-tw-name">{$name}</strong>
                        <span class="ip-tw-sep">·</span>
                        <span class="ip-tw-role">{$role}</span>
                        <span class="ip-tw-sep">·</span>
                        <span class="ip-tw-date">{$date}</span>
                    </div>
                HTML);
            })
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    /**
     * @return array<NavigationItem>
     */
    protected function buildModuleNavigation(): array
    {
        $isAdmin = fn () => auth()->user()?->role === 'admin';
        $isSupervisorPlus = fn () => in_array(auth()->user()?->role, ['supervisor', 'admin'], true);
        $allInternal = fn () => in_array(auth()->user()?->role, ['officer', 'supervisor', 'admin'], true);

        return [
            // === Operasi Permohonan ===
            NavigationItem::make('Document Review')
                ->group('Operasi Permohonan')
                ->icon(Heroicon::OutlinedDocumentMagnifyingGlass)
                ->url(fn () => url('/admin/applications?tableFilters[status][value]=doc_review'))
                ->visible($allInternal)
                ->sort(2),
            NavigationItem::make('Officer Review')
                ->group('Operasi Permohonan')
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->url(fn () => url('/admin/applications?tableFilters[status][value]=officer_review'))
                ->visible($allInternal)
                ->sort(3),
            NavigationItem::make('Sijil & Dokumen')
                ->group('Operasi Permohonan')
                ->icon(Heroicon::OutlinedDocumentText)
                ->badge('Aktif', 'success')
                ->url(fn () => url('/admin/applications?tableFilters[status][value]=cert_generated'))
                ->visible($allInternal)
                ->sort(4),

            // === Pelaporan & Pengurusan ===
            NavigationItem::make('Heatmap Modul')
                ->group('Pelaporan & Pengurusan')
                ->icon(Heroicon::OutlinedSquares2x2)
                ->url(fn () => url('/admin/management-dashboard'))
                ->visible($allInternal)
                ->sort(1),
            NavigationItem::make('Statistik Cawangan')
                ->group('Pelaporan & Pengurusan')
                ->icon(Heroicon::OutlinedBuildingOffice2)
                ->url('#')
                ->visible($isSupervisorPlus)
                ->sort(2),
            NavigationItem::make('KPI Eksekutif')
                ->group('Pelaporan & Pengurusan')
                ->icon(Heroicon::OutlinedChartBar)
                ->url('#')
                ->visible($isSupervisorPlus)
                ->sort(3),

            // === Modul Penguatkuasaan ===
            NavigationItem::make('Siasatan')
                ->group('Modul Penguatkuasaan')
                ->icon(Heroicon::OutlinedMagnifyingGlass)
                ->url('#')
                ->visible($allInternal)
                ->sort(1),
            NavigationItem::make('Senarai Hitam')
                ->group('Modul Penguatkuasaan')
                ->icon(Heroicon::OutlinedExclamationTriangle)
                ->url('#')
                ->visible($isSupervisorPlus)
                ->sort(2),
            NavigationItem::make('Kutipan Hasil')
                ->group('Modul Penguatkuasaan')
                ->icon(Heroicon::OutlinedBanknotes)
                ->badge('Separa', 'warning')
                ->url(fn () => url('/admin/kutipan-hasil'))
                ->visible($allInternal)
                ->sort(3),
            NavigationItem::make('ABIS Biometrik')
                ->group('Modul Penguatkuasaan')
                ->icon(Heroicon::OutlinedFingerPrint)
                ->url('#')
                ->visible($allInternal)
                ->sort(4),
            NavigationItem::make('Aduan ICT & Kaunter')
                ->group('Modul Penguatkuasaan')
                ->icon(Heroicon::OutlinedPhone)
                ->url('#')
                ->visible($allInternal)
                ->sort(5),

            // === Pengurusan Sistem ===
            NavigationItem::make('Pengurusan ID & IAM')
                ->group('Pengurusan Sistem')
                ->icon(Heroicon::OutlinedKey)
                ->badge('Separa', 'warning')
                ->url(fn () => url('/admin/pengurusan-id'))
                ->visible($isAdmin)
                ->sort(1),
            NavigationItem::make('MDM')
                ->group('Pengurusan Sistem')
                ->icon(Heroicon::OutlinedCircleStack)
                ->url('#')
                ->visible($isAdmin)
                ->sort(2),
            NavigationItem::make('Data Warehouse')
                ->group('Pengurusan Sistem')
                ->icon(Heroicon::OutlinedChartPie)
                ->url('#')
                ->visible($isSupervisorPlus)
                ->sort(3),
            NavigationItem::make('Perkongsian Maklumat')
                ->group('Pengurusan Sistem')
                ->icon(Heroicon::OutlinedArrowsRightLeft)
                ->url('#')
                ->visible($isSupervisorPlus)
                ->sort(4),

            // === Sokongan ===
            NavigationItem::make('Walkthrough Demo')
                ->group('Sokongan')
                ->url(fn () => url('/demo/walkthrough'), shouldOpenInNewTab: true)
                ->icon(Heroicon::OutlinedPresentationChartBar)
                ->sort(99),
        ];
    }

    protected function panelHeadStyles(): string
    {
        return <<<'HTML'
        <style>
            /* === INPReS sidebar scheme — Charcoal Pro === */
            .fi-sidebar,
            .fi-sidebar-nav,
            .fi-main-sidebar { background: #0f172a !important; border-right: 1px solid rgba(255,255,255,0.06) !important; }
            .fi-sidebar-header-ctn,
            .fi-sidebar-header { display: none !important; }

            /* Brand: Jata + JPN logos + INPReS text inline */
            .fi-sidebar-header-logo-ctn, .fi-sidebar-header-logo-ctn a { display: inline-flex !important; align-items: center !important; gap: 10px !important; overflow: visible !important; width: auto !important; }
            .ip-brand-row { display: inline-flex !important; align-items: center !important; gap: 10px !important; }
            .ip-brand-jata { height: 3.6rem !important; width: auto !important; flex-shrink: 0; }
            .ip-brand-jpn { height: 3.0rem !important; width: auto !important; flex-shrink: 0; }
            .ip-brand-text { font-weight: 800 !important; font-size: 22px !important; color: #0b1e3f !important; letter-spacing: 0.6px !important; display: inline-block !important; visibility: visible !important; white-space: nowrap !important; padding-left: 12px; border-left: 1px solid rgba(11,30,63,0.18); margin-left: 2px; }

            /* Topbar welcome (right side) */
            .ip-topbar-welcome { display: inline-flex; align-items: center; gap: 8px; padding: 6px 14px; background: var(--accent-bg, #eff6ff); border-radius: 999px; font-size: 13px; color: var(--navy, #0b1e3f); margin: 0 12px 0 8px; }
            .ip-tw-greet { color: #64748d; }
            .ip-tw-name { color: var(--navy, #0b1e3f); font-weight: 600; }
            .ip-tw-role { color: var(--accent, #1d4ed8); font-weight: 700; }
            .ip-tw-sep { opacity: 0.4; color: #94a3b8; }
            .ip-tw-date { color: #64748d; }
            @media (max-width: 1100px) { .ip-tw-date { display: none; } .ip-tw-sep:nth-of-type(2) { display: none; } }
            @media (max-width: 900px) { .ip-topbar-welcome { display: none; } }

            /* Topbar search bar */
            .ip-topbar-search { display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; background: #f1f5f9; border: 1px solid var(--border, #e5edf5); border-radius: 999px; min-width: 320px; max-width: 420px; transition: all 150ms; }
            .ip-topbar-search:focus-within { background: #fff; border-color: var(--accent, #1d4ed8); box-shadow: 0 0 0 3px rgba(29,78,216,0.12); }
            .ip-search-icon { width: 16px; height: 16px; color: #94a3b8; flex-shrink: 0; }
            .ip-search-input { flex: 1; border: none; background: transparent; outline: none; font-size: 13.5px; font-family: inherit; color: var(--navy, #0b1e3f); min-width: 0; }
            .ip-search-input::placeholder { color: #9aabbc; }
            .ip-search-kbd { font-family: 'JetBrains Mono', monospace; font-size: 10.5px; background: #fff; border: 1px solid var(--border, #e5edf5); border-bottom-width: 2px; padding: 1px 6px; border-radius: 4px; color: #64748d; flex-shrink: 0; }
            @media (max-width: 1280px) { .ip-topbar-search { min-width: 240px; } }
            @media (max-width: 900px) { .ip-topbar-search { display: none; } }

            /* Notification bell */
            .ip-bell { position: relative; display: inline-flex; align-items: center; justify-content: center; width: 38px; height: 38px; border-radius: 999px; background: #f1f5f9; border: 1px solid var(--border, #e5edf5); color: var(--slate, #64748d); cursor: pointer; transition: all 150ms; flex-shrink: 0; }
            .ip-bell:hover { background: var(--accent-bg, #eff6ff); color: var(--accent, #1d4ed8); border-color: var(--accent, #1d4ed8); }
            .ip-bell svg { width: 18px; height: 18px; }
            .ip-bell-dot { position: absolute; top: -4px; right: -4px; min-width: 18px; height: 18px; padding: 0 5px; background: var(--red, #dc2626); color: #fff; border-radius: 999px; font-size: 10.5px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; border: 2px solid #fff; }

            /* Group labels — Jata gold */
            .fi-sidebar-group { margin: 8px 0 4px !important; padding: 0 8px !important; }
            .fi-sidebar-group-label, .fi-sidebar-group-button-label {
                color: #FFCC00 !important;
                font-weight: 800 !important;
                letter-spacing: 1px !important;
                font-size: 11.5px !important;
                text-transform: uppercase !important;
            }
            .fi-sidebar-group-button { padding: 10px 12px !important; color: #FFCC00 !important; }
            .fi-sidebar-group-button:hover { background: rgba(255,255,255,0.08) !important; border-radius: 6px !important; }
            .fi-sidebar-group-collapse-btn, .fi-sidebar-group-collapse-btn svg { color: rgba(255,255,255,0.7) !important; }

            /* Nav items — white text on cobalt */
            .fi-sidebar-item-btn,
            .fi-sidebar-item-btn .fi-sidebar-item-label {
                color: #ffffff !important;
            }
            .fi-sidebar-item-btn {
                border-radius: 8px !important;
                font-weight: 600 !important;
                font-size: 14px !important;
                padding: 10px 14px !important;
                margin: 2px 0 !important;
                transition: all 150ms !important;
            }
            .fi-sidebar-item-label { color: #ffffff !important; font-weight: 600 !important; font-size: 14px !important; }
            .fi-sidebar-item-btn .fi-icon, .fi-sidebar-item-btn svg {
                color: #94a3b8 !important;
                width: 20px !important;
                height: 20px !important;
            }
            .fi-sidebar-item-btn:hover {
                background: rgba(255,255,255,0.08) !important;
                color: #FFCC00 !important;
            }
            .fi-sidebar-item-btn:hover .fi-sidebar-item-label { color: #FFCC00 !important; }
            .fi-sidebar-item-btn:hover .fi-icon, .fi-sidebar-item-btn:hover svg { color: #FFCC00 !important; }

            /* Active item — royal blue + gold stripe */
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
                background: #2563eb !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                box-shadow: inset 4px 0 0 #FFCC00, 0 4px 14px rgba(37,99,235,0.30) !important;
            }
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-sidebar-item-label {
                color: #ffffff !important;
                font-weight: 700 !important;
            }
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-icon,
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn svg { color: #FFCC00 !important; }

            /* Inactive (href="#") — dim white */
            .fi-sidebar-item-btn[href$="#"], .fi-sidebar-item-btn[href="#"] { opacity: 0.50 !important; cursor: not-allowed !important; }
            .fi-sidebar-item-btn[href$="#"]:hover { opacity: 0.70 !important; background: rgba(255,255,255,0.06) !important; }
            .fi-sidebar-item-btn[href$="#"]:hover .fi-sidebar-item-label { color: rgba(255,255,255,0.85) !important; }
            .fi-sidebar-item-btn[href$="#"]:hover .fi-icon { color: rgba(255,255,255,0.7) !important; }

            /* Sidebar header buttons (white bg) */
            .fi-sidebar-header button { color: #475569 !important; }
            .fi-sidebar-header button:hover { background: #eff6ff !important; color: #1d4ed8 !important; }
            /* Sidebar nav buttons (cobalt bg) */
            .fi-sidebar-close-btn, .fi-sidebar-collapse-btn { color: #ffffff !important; }
            .fi-sidebar-close-btn:hover, .fi-sidebar-collapse-btn:hover { background: rgba(255,255,255,0.10) !important; color: #FFCC00 !important; }

            .fi-topbar .fi-sidebar-collapse-btn,
            .fi-topbar .fi-sidebar-open-btn { color: #1f2937 !important; }

            /* === Page typography (smaller, tighter) === */
            .fi-header-heading,
            .fi-page h1.fi-header-heading,
            h1.fi-header-heading {
                font-size: 22px !important;
                font-weight: 700 !important;
                line-height: 1.25 !important;
                letter-spacing: -0.2px !important;
            }
            .fi-header-subheading,
            .fi-page .fi-header-subheading {
                font-size: 13px !important;
                color: #64748b !important;
                margin-top: 4px !important;
            }
            .fi-breadcrumbs, .fi-breadcrumbs-item, .fi-breadcrumbs a {
                font-size: 11.5px !important;
                letter-spacing: 0.2px !important;
            }
            .fi-page-header { padding-bottom: 14px !important; }

            /* Body content shrink */
            .fi-main, .fi-page-content { font-size: 13.5px !important; }
            .fi-section-content, .fi-section-content p, .fi-section-content li { font-size: 13.5px !important; }

            /* Tables */
            .fi-ta-table { font-size: 13px !important; }
            .fi-ta-header-cell-label, .fi-ta-header-cell { font-size: 11px !important; letter-spacing: 0.4px !important; }
            .fi-ta-cell { padding: 10px 14px !important; }
            .fi-ta-text-item-label { font-size: 13px !important; }

            /* Form labels */
            .fi-fo-field-wrp-label, .fi-fo-field-wrp-label * { font-size: 12px !important; }

            /* Inline section title */
            .fi-section-header-heading { font-size: 14.5px !important; font-weight: 600 !important; }

            /* Scrollbar on cobalt */
            .fi-sidebar::-webkit-scrollbar { width: 8px; }
            .fi-sidebar::-webkit-scrollbar-track { background: transparent; }
            .fi-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.18); border-radius: 4px; }
            .fi-sidebar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.35); }

            /* === Sidebar nav badges (Aktif / Separa / Akan Datang) === */
            /* Reset universal-color rule for badges so they keep their own bg/text */
            .fi-sidebar-item-btn .fi-badge {
                padding: 2px 9px !important;
                border-radius: 6px !important;
                font-size: 10.5px !important;
                font-weight: 800 !important;
                letter-spacing: 0.5px !important;
                text-transform: uppercase;
                box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
                line-height: 1.4;
            }
            .fi-sidebar-item-btn .fi-badge .fi-badge-label { font-weight: 800 !important; }

            /* Aktif (success/green) */
            .fi-sidebar-item-btn .fi-badge.fi-color-success,
            .fi-sidebar-item-btn .fi-badge[class*="fi-color-success"] {
                background: #22c55e !important;
                color: #052e16 !important;
            }
            .fi-sidebar-item-btn .fi-badge.fi-color-success *,
            .fi-sidebar-item-btn .fi-badge[class*="fi-color-success"] * { color: #052e16 !important; background: transparent !important; }

            /* Separa (warning/amber) */
            .fi-sidebar-item-btn .fi-badge.fi-color-warning,
            .fi-sidebar-item-btn .fi-badge[class*="fi-color-warning"] {
                background: #fbbf24 !important;
                color: #451a03 !important;
            }
            .fi-sidebar-item-btn .fi-badge.fi-color-warning *,
            .fi-sidebar-item-btn .fi-badge[class*="fi-color-warning"] * { color: #451a03 !important; background: transparent !important; }

            /* Akan Datang / gray */
            .fi-sidebar-item-btn .fi-badge.fi-color-gray,
            .fi-sidebar-item-btn .fi-badge[class*="fi-color-gray"] {
                background: rgba(255,255,255,0.16) !important;
                color: rgba(255,255,255,0.85) !important;
            }
            .fi-sidebar-item-btn .fi-badge.fi-color-gray *,
            .fi-sidebar-item-btn .fi-badge[class*="fi-color-gray"] * { color: rgba(255,255,255,0.85) !important; background: transparent !important; }

            /* Active item: keep badge readable on blue bg */
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-badge.fi-color-success { background: #dcfce7 !important; color: #166534 !important; }
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-badge.fi-color-success * { color: #166534 !important; }
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-badge.fi-color-warning { background: #fef3c7 !important; color: #92400e !important; }
            .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-badge.fi-color-warning * { color: #92400e !important; }
        </style>
        HTML;
    }

    protected function panelBodyScripts(): string
    {
        return <<<'HTML'
        <script>
        (function () {
            function injectBrand() {
                var anchor = document.querySelector('.fi-sidebar-header-logo-ctn a') ||
                             document.querySelector('.fi-sidebar-header-logo-ctn');
                if (!anchor) return false;
                anchor.style.display = 'inline-flex';
                anchor.style.alignItems = 'center';
                anchor.style.gap = '10px';
                return true;
            }

            function applyTooltips() {
                document.querySelectorAll('.fi-sidebar-nav a[href$="#"], .fi-sidebar-item-btn[href$="#"]').forEach(function (el) {
                    el.setAttribute('title', 'Modul ini tidak termasuk dalam prototaip semasa');
                    el.addEventListener('click', function (e) { e.preventDefault(); });
                });
            }

            function run() { injectBrand(); applyTooltips(); }
            if (document.readyState !== 'loading') run();
            else document.addEventListener('DOMContentLoaded', run);

            // Filament uses Livewire; sidebar may re-render. Observe.
            var obs = new MutationObserver(run);
            obs.observe(document.documentElement, { childList: true, subtree: true });
        })();
        </script>
        HTML;
    }
}
