<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <div class="workspace-header d-flex align-items-center justify-content-between">
                <div class="workspace-button d-flex align-items-center">
                    <span class="workspace-badge mr-2">MW</span>
                    <span class="workspace-name">{{ __('My Workspace') }}</span>
                </div>
                <button class="avatar-btn" type="button"><span class="avatar-circle"></span></button>
            </div>
        </div>
        <div class="sidebar-search">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="tim-icons icon-zoom-split"></i></span>
                </div>
                <input type="text" class="form-control" placeholder="Search" />
            </div>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-components"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
              <li class="nav-group show">
                <a data-toggle="collapse" href="#analysis" aria-expanded="true">
                    <span><i class="tim-icons icon-zoom-split text-secondary"></i> <span class="ml-2">{{ __('Analysis') }}</span></span>
                    <img src="{{ asset('black/icons/chevron.svg') }}" alt="chevron" class="caret-svg" />
                </a>
                <div class="collapse show" id="analysis">
                    <ul class="nav pl-4">
                        <li><a href="#"><i class="tim-icons icon-single-02"></i><p>{{ __('User Analysis') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-paper"></i><p>{{ __('Content Analysis') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-notes"></i><p>{{ __('Survey Report') }}</p></a></li>
                    </ul>
                </div>
            </li>

                <li class="nav-group">
                <a data-toggle="collapse" href="#management" aria-expanded="false">
                    <span><i class="tim-icons icon-settings text-secondary"></i> <span class="ml-2">{{ __('Management') }}</span></span>
                    <img src="{{ asset('black/icons/chevron.svg') }}" alt="chevron" class="caret-svg" />
                </a>
                <div class="collapse" id="management">
                    <ul class="nav pl-4">
                        <li><a href="#"><i class="tim-icons icon-cloud-upload-94"></i><p>{{ __('Content Upload') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-components"></i><p>{{ __('Content Management') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-tag"></i><p>{{ __('Category & Tags') }}</p></a></li>
                    </ul>
                </div>
            </li>

               <li class="nav-group">
                <a data-toggle="collapse" href="#affiliate" aria-expanded="false">
                    <span><i class="tim-icons icon-gift-2 text-secondary"></i> <span class="ml-2">{{ __('Affiliate') }}</span></span>
                    <img src="{{ asset('black/icons/chevron.svg') }}" alt="chevron" class="caret-svg" />
                </a>
                <div class="collapse" id="affiliate">
                    <ul class="nav pl-4">
                        <li><a href="#"><i class="tim-icons icon-chart-bar-32"></i><p>{{ __('Analytics') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-bullet-list-67"></i><p>{{ __('Campaign') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-badge"></i><p>{{ __('Affiliate') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-coins"></i><p>{{ __('Sales & Commissions') }}</p></a></li>
                        <li><a href="#"><i class="tim-icons icon-settings-gear-63"></i><p>{{ __('Setting') }}</p></a></li>
                    </ul>
                </div>
            </li>

                    <li><a href="#"><i class="tim-icons icon-key-25"></i><p>{{ __('API Management') }}</p></a></li>

             <li><a href="#"><i class="tim-icons icon-simple-add"></i><p>{{ __('Invite people') }}</p></a></li>
            <li><a href="#"><i class="tim-icons icon-support-17"></i><p>{{ __('Help & Support') }}</p></a></li>

            <li class="sidebar-divider"></li>
            <li>
                <div class="sidebar-pill">{{ __('App version 3.1') }}</div>
            </li>
            <li>
                <div class="notice-card">
                    <div class="notice-card-header">
                        <span>{{ __('Import Issues') }}</span>
                        <button type="button" class="close" aria-label="Close">×</button>
                    </div>
                    <div class="notice-card-body text-secondary">
                        {{ __('Use our Migration Assistant to copy issues from another service.') }}
                    </div>
                    <div class="notice-card-footer">
                        <a href="#" class="text-accent">{{ __('Try Now') }} →</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
