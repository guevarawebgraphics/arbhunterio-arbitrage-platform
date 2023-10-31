<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="{!! $seo_meta['description'] !!}">
    <meta name="author" content="{!! $seo_meta['author'] !!}">
    <meta name="robots" content="{!! $seo_meta['robots'] !!}">
    <meta name="keywords" content="{!! $seo_meta['keywords'] !!}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{!! $seo_meta['title'] !!}">
    <meta property="og:description" content="{!! $seo_meta['description'] !!}">
    <meta property="og:url" content="{!! url('') !!}">
    <meta property="og:site_name" content="{!! $seo_meta['name'] !!}">
    <title>{!! $seo_meta['title'] !!}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900;0,6..12,1000;1,6..12,1000&display=swap" rel="stylesheet">
    
    
    <link href="{{asset('public/css/app.css')}}" rel="stylesheet">
    <script src="{{ asset('public/js/bundle.js') }}"></script>
    <style>       
        body{
            background-color: #09131E;
        }
    </style>
    @livewireStyles
</head>
<body class="font-body">
    <nav class="bg-white border-gray-200 ">
        <div class="flex flex-wrap items-center justify-between mx-auto h-16 px-8 p-3 border-b border-slate-500 bg-[#09131E]">
            <a href="https://flowbite.com/" class="flex items-center">
                <span class="self-center text-2xl font-black whitespace-nowrap uppercase text-white">Oddsjam</span>
            </a>
        <div class="flex items-center md:order-2">
            <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="{{asset('public/assets/img/user.jpeg')}}" alt="user photo">
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 mr-20" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">Bonnie Green</span>
                    <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Earnings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
              </svg>
          </button>
        </div>
            <div class="items-center justify-between hidden w-full md:w-auto md:order-1 z-40" id="navbar-user">
                <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 bg-[#142230] md:bg-+parent md:hidden md:space-x-8 md:mt-0 md:border-0 ">
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white" aria-current="page">Arbitrage</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white">Bet Tracker</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white">Calculators</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white">Sportsbook</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-white">Account Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div>
        @yield('content')
    </div>

    <script src="{{asset('public/js/jquery-1.12.4.min.js')}}"></script>
    {{Html::script('public/bsbmd/plugins/momentjs/moment.js')}}
    <script src="{{asset('public/assets/js/flowbite.min.js')}}"></script>
    <script src="{{asset('public/assets/js/switch.js')}}"></script>
    
    @yield('extra-script')

    @livewireScripts

    <script>
        Echo.channel('odds-updates')
        .listen('NewOddsReceived', (event) => {
            console.log(event);
        });
    </script>

</body>
</html>