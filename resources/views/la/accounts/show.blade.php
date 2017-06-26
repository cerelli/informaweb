@extends('la.layouts.app')

@section('htmlheader_title')
    {{ __('Account View')}}
@endsection


@section('main-content')
<div id="page-content" class="profile2">
    <div class="bg-primary clearfix">
        <div class="col-md-12">
            <h4 class="name">{{  ($account->title_id > 0)  ? $account->title->description : ''  }}  {{ $account->name1 }} {{ $account->name2 }}</h4>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-3">
                    <!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
                    <div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
                </div>
                <div class="col-md-9">
                    <div class="row stats">
                        <div class="col-md-12" style="background:white">@la_display($module, 'account_account_type','',0)</div>
                        <div class="col-md-4"><i class="fa fa-facebook"></i> 234</div>
                        <div class="col-md-4"><i class="fa fa-twitter"></i> 12</div>
                        <div class="col-md-4"><i class="fa fa-instagram"></i> 89</div>
                    </div>
                    <p class="desc">Test Description in one line</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dats1"><div class="label2">{{ ($account->is_person == 0) ? 'Società' : 'Persona' }}</div></div>

            <div class="dats1"><i class="fa fa-envelope-o"></i> superadmin@gmail.com</div>
            <div class="dats1"><i class="fa fa-map-marker"></i> Pune, India</div>
        </div>
        <div class="col-md-4">
            <!--
            <div class="teamview">
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user1-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user2-160x160.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user3-128x128.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user4-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user5-128x128.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user6-128x128.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user7-128x128.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user8-128x128.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user5-128x128.jpg') }}" alt=""></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user6-128x128.jpg') }}" alt=""><i class="status-online"></i></a>
                <a class="face" data-toggle="tooltip" data-placement="top" title="John Doe"><img src="{{ asset('la-assets/img/user7-128x128.jpg') }}" alt=""></a>
            </div>
            -->
            <div class="dats1 pb">
                <div class="clearfix">
                    <span class="pull-left">Task #1</span>
                    <small class="pull-right">20%</small>
                </div>
                <div class="progress progress-xs active">
                    <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">20% Complete</span>
                    </div>
                </div>
            </div>
            <div class="dats1 pb">
                <div class="clearfix">
                    <span class="pull-left">Task #2</span>
                    <small class="pull-right">90%</small>
                </div>
                <div class="progress progress-xs active">
                    <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 90%" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">90% Complete</span>
                    </div>
                </div>
            </div>
            <div class="dats1 pb">
                <div class="clearfix">
                    <span class="pull-left">Task #3</span>
                    <small class="pull-right">60%</small>
                </div>
                <div class="progress progress-xs active">
                    <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: 60%" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">60% Complete</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 actions">
            @la_access("Accounts", "edit")
                @if ( $account->hasAccess($account->id,'edit', Auth::user()->id) == 1)
                    <a href="{{ url(config('laraadmin.adminRoute') . '/accounts/'.$account->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
                @endif
            @endla_access

            @la_access("Accounts", "delete")
                @if ( $account->hasAccess($account->id,'delete', Auth::user()->id) == 1)

                    {{ Form::open(['route' => [config('laraadmin.adminRoute') . '.accounts.destroy', $account->id], 'method' => 'delete', 'style'=>'display:inline']) }}
                        <button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
                    {{ Form::close() }}
                @endif
            @endla_access
        </div>
    </div>

    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
        <li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/accounts') }}" data-toggle="tooltip" data-placement="right" title="Back to Accounts"><i class="fa fa-chevron-left"></i></a></li>
        <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> {{ __('General Info') }}</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#tab-contacts" data-target="#tab-contacts"><i class="fa fa-user"></i>{{ __('Contacts') }}</a></li>
        <li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>{{ __('Timeline') }}</a></li>
        @role(['SUPER_ADMIN','NORMAL_ADMIN'])
            <li class=""><a role="tab" data-toggle="tab" href="#tab-access_rights" data-target="#tab-access_rights"><i class="fa fa-key"></i>{{ __('Access Rights') }}</a></li>
        @endrole
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active fade in" id="tab-info">
            <div class="tab-content">
                <div class="panel infolist">
                    <div class="panel-default panel-heading">
                        <h4>{{ __('General Info') }}</h4>
                    </div>
                    <div class="panel-body">
                        {{-- @la_display($module, 'title_id') --}}
						{{-- @la_display($module, 'is_person') --}}
						{{-- @la_display($module, 'name1') --}}
						{{-- @la_display($module, 'name2') --}}
						@la_display($module, 'notes')
						{{-- @la_display($module, 'account_account_type') --}}
                        @la_display($module, 'vat_number')
                        @la_display($module, 'fiscal_code')
                        @la_display($module, 'is_blocked')
                        @la_display($module, 'block_alert_message')

                    </div>
                </div>
            </div>
        </div>
        @include('la.accounts.tabs.contacts')
        @include('la.accounts.tabs.timeline')
        @include('la.accounts.tabs.access_rights')
    </div>
    </div>
    </div>
</div>
@endsection
