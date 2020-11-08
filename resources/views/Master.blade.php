<!DOCTYPE html>
<html lang="<?php echo Config::get('app.locale'); ?>">

<head>
    <meta charset="UTF-8" />
    <title>{{ config('dofus.title') }}@if (isset($page_name)) - {!! $page_name !!}@endif</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="{!! config('dofus.description') !!}" />
    @if (isset($og))
    {!! $og->renderTags() !!}
    @else
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ URL::asset('imgs/cover.png') }}" />
    <meta property="og:description" content="{!! config('dofus.description') !!}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:site_name" content="{{ config('dofus.title') }} - @if (isset($page_name)){!! $page_name !!}@else{{ config('dofus.subtitle') }}@endif" />
    @endif
    <link rel="alternate" type="application/rss+xml" title="News RSS" href="{{ URL::to('news.rss') }}" />
    <link rel="shortcut icon" type="image/png" href="{{ URL::asset('imgs/azote_simple.png') }}"/>
    <link rel="canonical" href="{{ Request::url() }}" />
    {!! Html::style('css/common.css') !!}
    {!! Html::style('css/toastr.min.css') !!}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
	<!--<script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" ></script>-->
			
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>	-->
   <script type="text/javascript" src="/js/custom.js" ></script>
	
    @yield('header')
    {!! Html::script('js/admin/toastr.min.js') !!}
    {!! Html::script('js/common.js') !!}
    @if (config('dofus.theme.animated'))
    {!! Html::style('imgs/carousel/'.config('dofus.theme.background').'/style.css') !!}
    @else
    <style type="text/css">
        body {
            background: url('{{ URL::asset('imgs/carousel/common/'.config('dofus.theme.background').'.jpg') }}')  center top no-repeat;
            background-color: {{ config('dofus.theme.color') }};
        }
	
}
/* .ak-connect-links .menu-lang{
     display: none;
} */

    </style>
    @endif
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-82860248-1', 'auto');
      ga('send', 'pageview');
    </script>
	<?php $cuRRlocal = Config::get('app.locale'); ?>
</head>

<?php 

	if(!(is_null(LaravelLocalization::getLocalizedURL('pt'))))
	{
	$linkPT = url(LaravelLocalization::getLocalizedURL('pt'));
	}
	else
	{
		$linkPT = '/pt/';
	}
		if(!(is_null(LaravelLocalization::getLocalizedURL('es'))))
	{
	$linkES = url(LaravelLocalization::getLocalizedURL('es'));
	}
	else
	{
		$linkES = '/es/';
	}
		if(!(is_null(LaravelLocalization::getLocalizedURL('fr'))))
	{
		$linkFR = url(LaravelLocalization::getLocalizedURL('fr'));
	}
	else
	{
		$linkFR = '/fr/';
	}
		if(!(is_null(LaravelLocalization::getLocalizedURL('en'))))
	{
		$linkEN = url(LaravelLocalization::getLocalizedURL('en'));
	}
	else
	{
		$linkEN = '/en/';
	}

		
		
?>
<body class="@yield('background')">
<style>
  .open .menu-lang{ 
     position: fixed !important ;
}
</style>
    <header >
        <div class="ak-idbar">
            <div class="ak-idbar-content">
                <div class="ak-idbar-left">
                    <div class="ak-brand" data-set="ak-brand">
                        <a class="navbar-brand" href="{{ URL::route('home') }}"></a>
                    </div>
                    <a class="ak-support" href="{{ URL::route('support')}}"><?php echo trans('app.181');?></a>
                    @if (!Auth::guest() && Auth::user()->isAdmin())
                    <a class="ak-admin" href="{{ URL::route('admin.dashboard') }}" target="_blank"><?php echo trans('app.182');?></a>
                    @endif
					
                </div>
				<input type="hidden" name="_token" id="csrf_token" value="{{csrf_token()}}">
                <div class="ak-idbar-right">
					<!-- Voir document texte pour les langues /menu  -->
				  <div class="ak-idbar-right">
                    @if (Auth::guest())
                    <div class="ak-nav-not-logged">
                        <div class="ak-connect-links ">
						
                            <a href="{{ URL::route('login') }}" class="login ak-modal-trigger">
                                <span><?php echo trans('app.183');?></span>
                                <img class="img-responsive" src="{{ URL::asset('imgs/avatar/default.png') }}" alt="Avatar">
                            </a>
                            <a href="{{ URL::route('register') }}" class="register"><?php echo trans('app.184');?></a>

                          
                                <a class="btn btn-secondary dropdown-toggle register btn-group " href="#" role="button" 
                                id="yo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="/imgs/<?php echo ( ($cuRRlocal == 'pt') ?  'pt' :  (  ($cuRRlocal == 'es') ?  'es' : (($cuRRlocal == 'fr') ?  'fr' : 'en') ) ) ?>.png" width="22px" height="22px"> 
                                {{-- (a ? b : c) ? d : e` or `a ? b : (c ? d : e) --}}
                                </a>
                               <div class="dropdown-menu  menu-lang "  aria-labelledby="yo" style=" 
                               top: 31px;
                               flex-direction: column;
                               display: flex;
                               background-color: black;
                               min-width: 40px;
                               right: 98px;
                               left: auto;
                               text-align: center;">
                                <a href="<?php echo $linkPT; ?>" <?php echo ($cuRRlocal == 'pt' ?  "style='background-color: #48beff !important' ": '') ?>hreflang="pt" class="ak-flag-br"><img src="/imgs/pt.png" width="22px" height="22px">  </a>
                                <a href="<?php echo $linkFR; ?>"  <?php echo ($cuRRlocal == 'fr' ?  "style='background-color: #48beff !important' ": '') ?> hreflang="fr" class="ak-flag-fr"><img src="/imgs/fr.png" width="22px" height="22px"></a>    
                                <a href="<?php echo $linkES; ?>" <?php echo ($cuRRlocal == 'es' ?  "style='background-color: #48beff !important' ": '') ?> hreflang="es" class="ak-flag-es"><img src="/imgs/es.png" width="22px" height="22px"></a>   
                                <a href="<?php echo $linkEN; ?>" <?php echo ($cuRRlocal == 'en' ?  "style='background-color: #48beff !important' ": '') ?> hreflang="en" class="ak-flag-en"><img src="/imgs/en.png" width="22px" height="22px"></a>   
                                 
                                </div>
                            
                     
                        </div>
                    </div>
				 
                    @else
                     
                      <!--  <a class="ak-nav-notifications ak-button-modal">
                            <span class="label label-danger">0</span>
                        </a>-->
                        <div class="ak-button-modal ak-nav-logged">
                            <a class="ak-logged-account" href="{{ URL::route('profile') }}">
                                <span class="ak-nickname">{{ Auth::user()->pseudo }}</span>
                                <span class="avatar">
                                    <img src="{{ URL::asset(Auth::user()->avatar()) }}" alt="Avatar">
                                </span>
                            </a>
                        </div>

                    @endif
					</div>
					
<!-- -->					<div class="ak-nav-not-logged">

						<div class="ak-connect-links">
{{--                     --}}
</div> <!-- -->
					</div>
				
                </div>
            </div>
        </div>

        <nav class="navbar navbar-default" data-role="ak_navbar">
            <div class="navbar-container">
<div class="ak-navbar-left">
                    <a class="ak-brand" href="{{ URL::route('home') }}"><?php echo config('dofus.title');?></a>
                </div>
                <a class="ak-main-logo" href="{{ URL::route('home') }}"></a>

                <div class="navbar-header">
                    <a class="burger-btn" href="javascript:void(0)"><span></span></a>
                </div>

                <div class="navbar-collapse navbar-ex1-collapse collapse">
                    <ul class="nav navbar-nav">
                        <span class="ak-navbar-left-part">
                            <li class="lvl0 dropdown sep">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?php echo config('dofus.title');?> <b class="caret"></b></a>
                                 <!--<ul class="dropdown-menu dropdown-menu-right" role="menu">-->
								<ul class="dropdown-menu" role="menu">
                                    <li class="lvl1">
                                        <ul>
                                            <li class="lvl2"><a href="{{ URL::route('posts') }}"><?php echo trans('app.185');?></a></li>
                                            <li class="lvl2"><a href="{{ URL::route('servers') }}"><?php echo trans('app.186');?></a></li>
                                            <li class="lvl2"><a href="{{ URL::route('ladder.general', [config('dofus.default_server_ladder'),trans('app.651')]) }}"><?php echo trans('app.187');?></a></li>
                                            <li class="lvl2"><a href="{{ URL::route('lottery.index') }}"><?php echo trans('app.188');?></a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                           
                             
                            <li class="lvl0 sep"><a href="{{ URL::route('register') }}"><?php echo trans('app.189');?></a></li>
                            <!--<li class="lvl0 sep"><a href="{{ URL::route('achatPoints') }}"><?php echo trans('app.190');?></a></li>-->
							<li class="lvl0 dropdown sep">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><?php echo trans('app.190');?> <b class="caret"></b></a>
                                <!--<ul class="dropdown-menu dropdown-menu-right" role="menu">-->
								<ul class="dropdown-menu" role="menu">
                                    <li class="lvl1">
                                        <ul>
                                            <li class="lvl2"><a href="{{ URL::route('shop.payment.country') }}"><?php echo trans('app.225');?></a></li>
                                            <li class="lvl2"><a href="{{ URL::route('shop.payment.confirmogr') }}"><?php echo trans('app.457');?></a></li>                                            
                                            <li class="lvl2"><a href="{{ URL::route('shop.payment.palier', [trans('app.511'),trans('app.512')]) }}"><?php echo trans('app.458');?></a></li>
                                        </ul>
                                    </li>
									<li class="lvl2">
                                        <ul>
                                            <li class="lvl2"><a href="{{ URL::route('gameaccount.shop') }}"><?php echo trans('app.226');?></a></li>                                           
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </span>
                        <li class="lvl0 ak-menu-brand">
                            <a class="navbar-brand" href="{{ URL::route('home') }}"></a>
                        </li>
                        <span class="ak-navbar-right-part">
                            <li class="lvl0 sep"><a href="{{ URL::route('vote.index') }}"><?php echo trans('app.191');?></a></li>
                            <li class="lvl0 sep"><a href="{{ config('dofus.social.forum') }}" target="_blank"><?php echo trans('app.192');?></a></li>
                            <li class="lvl0 sep"><a href="{{ URL::route('support')}}"><?php echo trans('app.193');?></a></li>
                        </span>
                    </ul>

                </div>
				
				
				<div class="ak-navbar-right">
				 @if (Auth::guest())
                    <div class="ak-nav-not-logged">
                        <div class="ak-connect-links">
						
                            <a href="{{ URL::route('login') }}" class="login ak-modal-trigger">
                                <span><?php echo trans('app.183');?></span>
                                <img class="img-responsive" src="{{ URL::asset('imgs/avatar/default.png') }}" alt="Avatar">
                            </a>
                            <a href="{{ URL::route('register') }}" class="register"><?php echo trans('app.184');?></a>
                            
                        </div>
                    </div>
				
                    @else
                     
                       <!-- <a class="ak-nav-notifications ak-button-modal">
                            <span class="label label-danger">0</span>
                        </a>-->
                        <div class="ak-button-modal ak-nav-logged">
                            <a class="ak-logged-account" href="{{ URL::route('profile') }}">
                                <span class="ak-nickname">{{ Auth::user()->pseudo }}</span>
                                <span class="avatar">
                                    <img src="{{ URL::asset(Auth::user()->avatar()) }}" alt="Avatar">
                                </span>
                            </a>
                        </div>

                    
                    @endif 
                   
                   <!-- <script type="application/json">{"target":".ak-box-logged"}</script>-->
                </div>
            </div>
        </nav>

        <!-- Keep in order largest -> lowest device resolution -->
        <div class="largedesktop device-profile visible-lg" data-deviceprofile="largedesktop"></div>
        <div class="desktop device-profile visible-md" data-deviceprofile="desktop"></div>
        <div class="tablet device-profile visible-sm" data-deviceprofile="tablet"></div>
        <div class="mobile device-profile visible-xs" data-deviceprofile="mobile"></div>
    </header>

  <!--  <div class="ak-beta"></div> -->

    @yield('page')
<a class="ak-backtotop" href="javascript:void(0);" style=""></a>
    <footer style = 'padding : 12.2rem 0'>
        <div class="ak-footer-content">
            <div class="row ak-block1">
                <div class="col-md-9 ak-block-links">
                    <div class="col-md-6 clearfix">
                        <div class="col-xs-6">
                            <div class="ak-list">
                                <div>
                                    <span class="ak-link-title">{{ config('dofus.title') }}</span>
                                </div>
                                <a href="{{ URL::route('posts') }}"><?php echo trans('app.194');?></a>
                                <a href="{{ URL::route('download') }}"><?php echo trans('app.195');?></a>
                                <a href="{{ URL::route('register') }}"><?php echo trans('app.196');?></a>
                                <a href="{{ URL::route('password-lost') }}"><?php echo trans('app.197');?></a>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="ak-list">
                                <div>
                                    <span class="ak-link-title"><?php echo trans('app.198');?></span>
                                </div>
                                <a href="{{ URL::route('servers') }}"><?php echo trans('app.199');?></a>
                                <a href="{{ URL::route('lottery.index') }}"><?php echo trans('app.200');?></a>
                                <a href="{{ URL::route('ladder.general', [config('dofus.default_server_ladder'),trans('app.651')]) }}"><?php echo trans('app.201');?></a>
                                <a href="{{ URL::route('vote.index') }}"><?php echo trans('app.202');?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 clearfix">
                        <!--<div class="col-xs-6">
                            <div class="ak-list">
                                <div>
                                    <span class="ak-link-title"><?php echo trans('app.203');?></span>
                                </div>
                                <a href="{{ URL::to('pvp/fights') }}"><?php echo trans('app.204');?></a>
                                <a href="{{ URL::to('pvp/champions') }}"><?php echo trans('app.205');?></a>
                                <a href="{{ URL::to('pvp/result') }}"><?php echo trans('app.206');?></a>
                                <a href="{{ URL::to('pvp/reward') }}"><?php echo trans('app.207');?></a>
                            </div>
                        </div>-->
                        <div class="col-xs-6">
                            <div class="ak-list">
                                <div>
                                    <span class="ak-link-title"><?php echo trans('app.208');?></span>
                                </div>
                                <a href="{{ URL::route('support')}}"><?php echo trans('app.209');?></a>
                                <a href="{{ config('dofus.social.forum') }}"><?php echo trans('app.210');?></a>
                                <a href=""><?php echo trans('app.211');?></a>
                                <a href=""><?php echo trans('app.212');?></a>
                            </div>
                        </div>
						     <div class="col-xs-6">
                            <div class="ak-list">
                                <div>
                                    <span class="ak-link-title"><?php echo trans('app.444');?></span>
                                </div>
                                <a href="<?php echo $linkPT; ?>"><?php echo trans('app.445');?></a>
                                <a href="<?php echo $linkFR; ?>"><?php echo trans('app.446');?></a>
                                <a href="<?php echo $linkES; ?>"><?php echo trans('app.447');?></a>
                                <a href="<?php echo $linkEN; ?>"><?php echo trans('app.448');?></a>
								<a href="<?php echo $linkPT; ?>"><?php echo trans('app.449');?></a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3 ak-block-download">
                    <a href="{{ URL::route('download') }}" class="btn btn-primary btn-lg"><?php echo trans('app.213');?></a>
                    <a class="ak-problem" href="{{ URL::route('support')}}"><?php echo trans('app.214');?></a>
                    <div class="ak-social-network">
                        <a href="{{ config('dofus.social.facebook') }}" class="fb" target="_blank"></a>
                        <a href="{{ config('dofus.social.twitter') }}" class="tw" target="_blank"></a>
                        <a href="{{ config('dofus.social.youtube') }}" class="yo" target="_blank"></a>
                    </div>
                </div>
            </div>
            <div class="row ak_legal">
                <div id="col-md-12">
                    <div class="ak-legal">
                        <div class="row">
                            <div class="col-sm-1">
                                <a href="" class="ak-logo-azote"></a>
                            </div>
                            <div class="col-sm-8">
                                <p>&copy; {{ date('Y') }} <a href="">{{ config('dofus.title') }}</a>. <?php echo trans('app.215');?><a href="{{ URL::to('cgu') }}" target="_blank"><?php echo trans('app.216');?></a> - <a href="{{ URL::to('privacy') }}"target="_blank"><?php echo trans('app.217');?></a> - <a href="{{ URL::to('cgv') }}" target="_blank"><?php echo trans('app.218');?>e</a> - <a href="{{ URL::to('legal') }}" target="_blank"><?php echo trans('app.219');?></a></p>
                            </div>
                            <div class="col-sm-3"><span class="prevention"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    @if (Session::has('popup'))
    {? $popup = Session::get('popup') ?}
    @endif

    @if (isset($popup))
    @include('popup.' . $popup)
    @endif

    @if (Session::has('notify'))
    {{ Toastr::add(Session::get('notify')['type'], str_replace("'", "\\'", Session::get('notify')['message'])) }}
    {!! Toastr::render() !!}
    @endif

    @if (!Auth::guest() && !Auth::user()->isStaff() && config('dofus.tawk.id'))
        <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/{{ config('dofus.tawk.id') }}/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
                Tawk_API = Tawk_API || {};
                Tawk_API.visitor = {
                    name  : '{{ Auth::user()->pseudo }} - {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}',
                    email : '{{ Auth::user()->email }}',
                    hash  : '{{ hash_hmac('sha256', Auth::user()->email, config('dofus.tawk.api') ) }}'
                };
            })();
        </script>
        @yield('scriptlogged')
    @endif

    @yield('bottom')
	
	 {!! Html::script('js/common3.js') !!}
    <script type="text/javascript">
        var $ = require('jquery');

        $('.ui-dialog-titlebar-close').hide();

        setTimeout(function() {
            $('.ui-dialog-titlebar-close').fadeIn();
        }, 3000);

        $('.ui-dialog-titlebar-close').on('click', function() {
            $('.ui-dialog').fadeOut();
        });
    </script>
</body>
</html>
