@extends('front.layouts.basev2')
@section('content')

<style>
    #pagination-listings .active {
        background-color: #09131e;
        color:#fff;
    }
    table.dataTable tbody tr {
        background-color: transparent !important;
    }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
        color:#fff !important;
    }
        /* Base styles for the pagination container */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        justify-content: center; /* Center the pagination */
    }


</style>

<div class="flex">

    <!-- filter -->
    <div class="flex-none w-0 sm:w-14 ">
        @include('front.layouts.sections.sidebar')
    </div>
    <!-- end filter -->

    <div class="flex-1">
        <div class="p-4 sm:ml-64">
            <!-- head section -->
            <div class="py-4">
                <div class="mb-4 py-8">
                    <div class="flex flex-col h-24">
                        <h1 class="text-7xl font-extrabold text-white">Arbitrage</h1>
                        <p class="text-white text-sm my-4">Make risk-free profits betting both sides of a bet</p>
                        <div class="whitespace-nowrap">
                            <div class="page-offset-x mx-auto w-full lg:max-w-page">
                                <ul class="no-scrollbar flex gap-4 flex-wrap" role="tablist">
                                    <li role="tab">
                                        <a aria-current="page" class="bg-brand-gray-4 border border-gray-500 text-white hover:bg-brand-gray-3 block p-2 px-3 rounded-[2.5rem] text-sm {{ !isset($_GET['is_live']) &&  !isset($_GET['is_hidden']) ? 'active' : '' }}" href="{{url('/dashboard')}}">
                                            Pre-match
                                            <span class="text-inherit hidden rounded-full py-0.5 px-2.5 text-xs leading-4 dark:bg-brand-blue dark:text-brand-gray-1 md:inline-block" id="pre-match">--</span>
                                        </a>
                                    </li>
                                    <li role="tab">
                                        <a class="bg-transparent border border-gray-500 text-white hover:bg-brand-gray-2 block p-2 px-3 rounded-[2.5rem] text-sm {{ isset($_GET['is_live']) && $_GET['is_live'] == 1 ? 'active' : '' }}" href="{{url('/dashboard?is_live=1')}}">
                                            Live (in-play)
                                            <span class="text-inherit hidden rounded-full py-0.5 px-2.5 text-xs leading-4 dark:bg-brand-blue dark:text-brand-gray-1 md:inline-block" id="live-count">--</span>
                                        </a>
                                    </li>
                                    <li role="tab">
                                        <a class="bg-transparent border border-gray-500 hover:bg-brand-gray-2 block p-2 px-3 rounded-[2.5rem] text-sm text-white {{ isset($_GET['is_hidden']) && $_GET['is_hidden'] == 1 ? 'active' : '' }}" href="{{url('/dashboard?is_hidden=1')}}">
                                            Hidden Bets
                                            <span class="text-inherit hidden rounded-full py-0.5 px-2.5 text-xs leading-4 dark:bg-brand-blue dark:text-brand-gray-1 md:inline-block" id="hidden-count">--</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end head secton -->

            <!-- calculator modal -->
            <div id="calculatorModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full ">
                    <div class="relative bg-[#09131E] rounded-lg shadow dark:bg-gray-700 text-white">
                        <div class="flex p-4">
                            <div class="flex flex-col">
                                <h3 class="text-xl font-semibold">
                                    FC Porto vs FC Barcelona
                                </h3>
                                <span>Team Total Corners</span>
                            </div>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="calculatorModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="flex text-sm my-2">
                                <div class="flex w-14 h-14 items-center">
                                  Books
                                </div>
                                <div class="flex-initial w-48">
                                    <div class="flex flex-col text-center items-center justify-center">
                                        <span class="font-bold">Tennessee Titans -3.5</span>
                                        <img class="rounded" width="24"  src="{{asset('public/assets/img/tipico.webp')}}" alt="">
                                    </div>
        
                                    
                                </div>
                                <div class="flex-initial w-48">
                                    <div class="flex flex-col text-center items-center justify-center">
                                            <span class="font-bold">Indianapolis Colts +3.5</span>
                                            <img class="rounded" width="24"  src="{{asset('public/assets/img/tipico.webp')}}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="flex text-sm gap-2">
                                <div class="flex w-14 h-14 items-center">
                                  Odds
                                </div>
                                <div class="flex-initial w-48">
                                    <input type="number" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="163">
                                </div>
                                <div class="flex-initial w-48">
                                    <input type="number" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="162">
                                </div>
                            </div>
                            <div class="flex text-sm gap-2">
                                <div class="flex w-14 h-14 items-center">
                                  Stake
                                </div>
                                <div class="flex-initial w-48">
                                    <input type="number" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="100">
                                </div>
                                <div class="flex-initial w-48">
                                    <input type="number" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="100">
                                </div>
                            </div>
                            <div class="flex text-sm gap-2">
                                <div class="flex w-14 h-14 items-center">
                                  Payout
                                </div>
                                <div class="flex-initial w-48">
                                    <div class="relative">
                                        <div class="min-w-0 rounded border outline-none text-left h-10 flex w-full">
                                            <div class="flex shrink-0 items-center justify-center  rounded-l w-10 text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                            </div>
                                                <input type="text" disabled="" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-black focus:ring-0 pr-4 bg-brand-gray-3 text-brand-gray-5 placeholder-brand-gray-7 dark:placeholder-brand-gray-6 rounded-r" value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-initial w-48">
                                    <div class="relative">
                                        <div class="min-w-0 rounded border outline-none text-left h-10 flex w-full">
                                            <div class="flex shrink-0 items-center justify-center  rounded-l w-10 text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                            </div>
                                                <input type="text" disabled="" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-black focus:ring-0 pr-4 bg-brand-gray-3 text-brand-gray-5 placeholder-brand-gray-7 dark:placeholder-brand-gray-6 rounded-r" value="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end items-end gap-y-2 5 gap-x-6 w-full">
                                <div class="flex flex-col gap-1">
                                    <p class="text-[#86A5B1] font-bold">Total Stake</p>
                                    <p class="font-bold">$100</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="text-[#86A5B1] font-bold">Total Payout</p>
                                    <p class="font-bold">$100</p>
                                </div>
                                <div class="flex flex-col gap-1 border-l border-slate-500 pl-6">
                                    <p class="text-[#86A5B1] font-bold">Profit</p>
                                    <p class="font-bold">$100</p>
                                </div>
                            </div>
                        </div>
        
                        <div class="flex justify-end px-6 pb-4 space-x-2">
                            <button data-modal-hide="defaultModal" type="button" class="font-bold text-white p-2 rounded bg-red-500 hover:text-black hover:bg-white">Add to Bet Tracker</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end calculator modal -->


            <!-- calculator modal -->
            <div id="viewModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                 {{-- w-full max-w-lg  --}}
                <div class="relative max-h-full ">
                    <div class="relative bg-[#09131E] rounded-lg shadow dark:bg-gray-700 text-white">
                        <div class="flex p-4">
                            <div class="flex flex-col">
                                <h3 class="text-xl font-semibold" id="viewModal-title">
                                    FC Porto vs FC Barcelona
                                </h3>
                                <span id="viewModal-market">Team Total Corners</span>
                            </div>
                            <button type="button" class="closeViewModal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="viewModal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>

                        <div id="head-line">

                        </div>
                        <div class="grid grid-rows-2 grid-flow-col gap-4">
                            <div class="row-span-2">
                                <div class="p-6">
                                    <table>
                                        <tbody id="view-modal-body-over">
                                            <tr>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                            </div>
                            <div class="row-span-2">
                                 <div class="p-6">
                                    <table>
                                        <tbody id="view-modal-body-under">
                                            <tr>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>
                
                            </div>
                        </div>

                        
                        

                    </div>
                </div>
            </div>
            <!-- end calculator modal -->
            
            
            <!-- filter section -->
            <section id="filter-section">
                <div class="flex items-center justify-end gap-4 flex-wrap my-5">
                    <a data-testid="link" id="settings-button" class="min-w-0 max-w-md font-semibold inline-flex rounded-md bg-[#314457] hover:bg-[#3d546b] transition-all duration-200 ease-in-out items-center text-white active:bg-brand-gray-5 text-sm h-10 px-[1.11rem]" href="#">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 01-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 016.126 3.537zM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 010 .75l-1.732 3.001c-.229.396-.76.498-1.067.16A5.231 5.231 0 016.75 12c0-1.362.519-2.603 1.37-3.536zM10.878 17.13c-.447-.097-.623-.608-.394-1.003l1.733-3.003a.75.75 0 01.65-.375h3.465c.457 0 .81.408.672.843a5.252 5.252 0 01-6.126 3.538z"></path><path fill-rule="evenodd" d="M21 12.75a.75.75 0 000-1.5h-.783a8.22 8.22 0 00-.237-1.357l.734-.267a.75.75 0 10-.513-1.41l-.735.268a8.24 8.24 0 00-.689-1.191l.6-.504a.75.75 0 10-.964-1.149l-.6.504a8.3 8.3 0 00-1.054-.885l.391-.678a.75.75 0 10-1.299-.75l-.39.677a8.188 8.188 0 00-1.295-.471l.136-.77a.75.75 0 00-1.477-.26l-.136.77a8.364 8.364 0 00-1.377 0l-.136-.77a.75.75 0 10-1.477.26l.136.77c-.448.121-.88.28-1.294.47l-.39-.676a.75.75 0 00-1.3.75l.392.678a8.29 8.29 0 00-1.054.885l-.6-.504a.75.75 0 00-.965 1.149l.6.503a8.243 8.243 0 00-.689 1.192L3.8 8.217a.75.75 0 10-.513 1.41l.735.267a8.222 8.222 0 00-.238 1.355h-.783a.75.75 0 000 1.5h.783c.042.464.122.917.238 1.356l-.735.268a.75.75 0 10.513 1.41l.735-.268c.197.417.428.816.69 1.192l-.6.504a.75.75 0 10.963 1.149l.601-.505c.326.323.679.62 1.054.885l-.392.68a.75.75 0 101.3.75l.39-.679c.414.192.847.35 1.294.471l-.136.771a.75.75 0 101.477.26l.137-.772a8.376 8.376 0 001.376 0l.136.773a.75.75 0 101.477-.26l-.136-.772a8.19 8.19 0 001.294-.47l.391.677a.75.75 0 101.3-.75l-.393-.679a8.282 8.282 0 001.054-.885l.601.504a.75.75 0 10.964-1.15l-.6-.503a8.24 8.24 0 00.69-1.191l.735.268a.75.75 0 10.512-1.41l-.734-.268c.115-.438.195-.892.237-1.356h.784zm-2.657-3.06a6.744 6.744 0 00-1.19-2.053 6.784 6.784 0 00-1.82-1.51A6.704 6.704 0 0012 5.25a6.801 6.801 0 00-1.225.111 6.7 6.7 0 00-2.15.792 6.784 6.784 0 00-2.952 3.489.758.758 0 01-.036.099A6.74 6.74 0 005.251 12a6.739 6.739 0 003.355 5.835l.01.006.01.005a6.706 6.706 0 002.203.802c.007 0 .014.002.021.004a6.792 6.792 0 002.301 0l.022-.004a6.707 6.707 0 002.228-.816 6.781 6.781 0 001.762-1.483l.009-.01.009-.012a6.744 6.744 0 001.18-2.064c.253-.708.39-1.47.39-2.264a6.74 6.74 0 00-.408-2.308z" clip-rule="evenodd"></path></svg>
                            </div>
                            <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Settings</div>
                        </div>
                    </a>
                    <button data-testid="betting-tools-refresh" id="refresh-button" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-white bg-[#314457] hover:bg-[#3d546b] active:bg-brand-gray-5 text-sm h-10 px-[1.11rem]" type="button">
                        <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                            <div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0112.548-3.364l1.903 1.903h-3.183a.75.75 0 100 1.5h4.992a.75.75 0 00.75-.75V4.356a.75.75 0 00-1.5 0v3.18l-1.9-1.9A9 9 0 003.306 9.67a.75.75 0 101.45.388zm15.408 3.352a.75.75 0 00-.919.53 7.5 7.5 0 01-12.548 3.364l-1.902-1.903h3.183a.75.75 0 000-1.5H2.984a.75.75 0 00-.75.75v4.992a.75.75 0 001.5 0v-3.18l1.9 1.9a9 9 0 0015.059-4.035.75.75 0 00-.53-.918z" clip-rule="evenodd"></path></svg>
                            </div>
                            <a class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap" href="{{url('/dashboard')}}">Refresh</a>
                        </div>
                    </button>
                    <div role="button" tabindex="-1" class="">
                        <button id="playButton" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-white bg-[#314457] hover:bg-[#3d546b] active:bg-brand-gray-5 text-sm h-10 px-[1.11rem]" type="button">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                <div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap" id="playButtonText">Play</div>
                            </div>
                        </button>
                    </div>
                    <button onclick="showFilter();" id="filters-button" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-white bg-[#314457] hover:bg-[#3d546b] active:bg-brand-gray-5 text-sm h-10 px-[1.11rem] group" type="button">
                        <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                            <div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.75 12.75h1.5a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5zM12 6a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 0112 6zM12 18a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 0112 18zM3.75 6.75h1.5a.75.75 0 100-1.5h-1.5a.75.75 0 000 1.5zM5.25 18.75h-1.5a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5zM3 12a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 013 12zM9 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zM12.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0zM9 15.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path></svg>
                            </div>
                            <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                                <div class="flex flex-row items-center gap-2" data-testid="filters-toggle">
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Filters</div>
                                    <div class="h-6 w-[1.5px] bg-white opacity-75 duration-200"></div>
                                        <span class="text-base text-inherit">2</span>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
                <div id="filterContainer" class="hidden mt-6 rounded-md bg-[#142230] shadow mb-4">
                    <div class="flex flex-row justify-between p-4">
                        <div class="mb-4 flex flex-row flex-wrap items-center text-white md:mb-0">
                            <h3 class="font-semibold text-xl font-code-next text-white">Filters</h3>
                            <span class="text-base ml-2 text-white">(2 selected)</span>
                        </div>
                        <div class="flex w-full flex-row gap-4 md:w-auto">
                            <button id="save-filters" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-white bg-[#314457] hover:bg-[#3d546b] active:bg-brand-gray-5 text-sm h-10 px-[1.11rem] w-full md:w-auto" type="button">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                    <div class="h-4 w-4 -ml-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"></path></svg>
                                    </div>
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Save Filter</div>
                                </div>
                            </button>
                            <button class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-white bg-[#314457] hover:bg-[#3d546b] active:bg-brand-gray-5 text-sm h-10 px-[1.11rem] w-full md:w-auto" type="button">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                    <div class="h-4 w-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Clear All</div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="border-b border-gray-500">
                    </div>
                    <div class="flex flex-row flex-wrap gap-4 p-4">
                        <div class="relative">
                            <button aria-expanded="false" data-target="percentagePopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="percentage-filter">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Percentage
                                        <span class="text-xs text-inherit ml-1 font-light">(1)</span>
                                    </div>
                                    <div class="h-4 w-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                        </svg>
                                    </div>
                                </div>
                            </button>
                            <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over" id="percentagePopOver" tabindex="-1" >
                                <div class="rounded-lg border border-gray-500  bg-[#25394D] text-white shadow-lg">
                                    <div class="w-72">
                                        <div class="flex flex-row items-center justify-between p-4">
                                            <span class="text-sm text-inherit font-semibold">1 selected</span>
                                            <button class="btn--clear-profit min-w-0 max-w-md font-semibold inline-flex transition-all duration-200 ease-in-out items-center text-brand-blue-5 border border-brand-blue-5 bg-[#1D2F41] hover:border-brand-blue-3 hover:text-brand-blue-3 hover:bg-brand-gray active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-xs h-8 px-3 rounded" type="button">
                                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Clear
    
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="border-b border-slate-500"></div>
                                        <div class="mt-1 flex flex-col gap-3 p-6">
                                            <label for="min">Minimum Percentage
                                                <div class="relative">
                                                    <div class="min-w-0 rounded border border-solid text-left dark h-10 border-[#1D2F41] bg-[#1D2F41] flex w-full dark">
                                                        <input name="value" id="minimum_profit_percentage" placeholder="1.5" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-white focus:ring-0 pl-4 bg-[#1D2F41] placeholder-gray-500 focus-within:border-slate-500 rounded-l border-none" value="">
                                                        <div class="flex shrink-0 items-center justify-center bg-[#1D2F41] rounded-r w-10 text-brand-gray-6">
                                                            <svg width="12" height="12" viewBox="-2 -2 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.24456 9.09091V8.55398C5.24456 8.18277 5.32079 7.84304 5.47326 7.5348C5.62903 7.22325 5.85441 6.97467 6.14939 6.78906C6.44769 6.60014 6.80896 6.50568 7.2332 6.50568C7.66407 6.50568 8.02534 6.60014 8.31701 6.78906C8.60867 6.97467 8.82908 7.22325 8.97823 7.5348C9.12737 7.84304 9.20195 8.18277 9.20195 8.55398V9.09091C9.20195 9.46212 9.12572 9.8035 8.97326 10.1151C8.82411 10.4233 8.60204 10.6719 8.30706 10.8608C8.0154 11.0464 7.65744 11.1392 7.2332 11.1392C6.80233 11.1392 6.4394 11.0464 6.14442 10.8608C5.84944 10.6719 5.62572 10.4233 5.47326 10.1151C5.32079 9.8035 5.24456 9.46212 5.24456 9.09091ZM6.25877 8.55398V9.09091C6.25877 9.39915 6.33168 9.6759 6.47752 9.92116C6.62335 10.1631 6.87524 10.2841 7.2332 10.2841C7.58121 10.2841 7.82648 10.1631 7.96899 9.92116C8.11483 9.6759 8.18774 9.39915 8.18774 9.09091V8.55398C8.18774 8.24574 8.11814 7.97064 7.97894 7.72869C7.83973 7.48343 7.59115 7.3608 7.2332 7.3608C6.88519 7.3608 6.63495 7.48343 6.48249 7.72869C6.33334 7.97064 6.25877 8.24574 6.25877 8.55398ZM0.17354 3.2642V2.72727C0.17354 2.35606 0.249771 2.01634 0.402233 1.7081C0.558009 1.39654 0.783388 1.14796 1.07837 0.962358C1.37666 0.773437 1.73793 0.678977 2.16218 0.678977C2.59305 0.678977 2.95432 0.773437 3.24598 0.962358C3.53765 1.14796 3.75806 1.39654 3.9072 1.7081C4.05635 2.01634 4.13093 2.35606 4.13093 2.72727V3.2642C4.13093 3.63542 4.0547 3.9768 3.90223 4.28835C3.75309 4.59659 3.53102 4.84517 3.23604 5.03409C2.94437 5.2197 2.58642 5.3125 2.16218 5.3125C1.7313 5.3125 1.36838 5.2197 1.0734 5.03409C0.778417 4.84517 0.554695 4.59659 0.402233 4.28835C0.249771 3.9768 0.17354 3.63542 0.17354 3.2642ZM1.18774 2.72727V3.2642C1.18774 3.57244 1.26066 3.8492 1.40649 4.09446C1.55233 4.33641 1.80422 4.45739 2.16218 4.45739C2.51019 4.45739 2.75545 4.33641 2.89797 4.09446C3.0438 3.8492 3.11672 3.57244 3.11672 3.2642V2.72727C3.11672 2.41903 3.04712 2.14394 2.90791 1.90199C2.76871 1.65672 2.52013 1.53409 2.16218 1.53409C1.81416 1.53409 1.56393 1.65672 1.41147 1.90199C1.26232 2.14394 1.18774 2.41903 1.18774 2.72727ZM0.551381 11L7.55138 0.818182H8.6849L1.6849 11H0.551381Z" fill="currentColor"></path></svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                            <label for="max">Maximum Percentage<div class="relative">
                                                <div class="min-w-0 rounded border border-solid text-left dark h-10 border-[#1D2F41] bg-[#1D2F41] flex w-full dark">
                                                    <input name="value" placeholder="10" id="maximum_profit_percentage" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-white focus:ring-0 pl-4 bg-[#1D2F41] placeholder-gray-500 focus-within:border-slate-500  rounded-l border-none" value="">
                                                    <div class="flex shrink-0 items-center justify-center bg-[#1D2F41] rounded-r w-10 text-brand-gray-6">
                                                        <svg width="12" height="12" viewBox="-2 -2 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.24456 9.09091V8.55398C5.24456 8.18277 5.32079 7.84304 5.47326 7.5348C5.62903 7.22325 5.85441 6.97467 6.14939 6.78906C6.44769 6.60014 6.80896 6.50568 7.2332 6.50568C7.66407 6.50568 8.02534 6.60014 8.31701 6.78906C8.60867 6.97467 8.82908 7.22325 8.97823 7.5348C9.12737 7.84304 9.20195 8.18277 9.20195 8.55398V9.09091C9.20195 9.46212 9.12572 9.8035 8.97326 10.1151C8.82411 10.4233 8.60204 10.6719 8.30706 10.8608C8.0154 11.0464 7.65744 11.1392 7.2332 11.1392C6.80233 11.1392 6.4394 11.0464 6.14442 10.8608C5.84944 10.6719 5.62572 10.4233 5.47326 10.1151C5.32079 9.8035 5.24456 9.46212 5.24456 9.09091ZM6.25877 8.55398V9.09091C6.25877 9.39915 6.33168 9.6759 6.47752 9.92116C6.62335 10.1631 6.87524 10.2841 7.2332 10.2841C7.58121 10.2841 7.82648 10.1631 7.96899 9.92116C8.11483 9.6759 8.18774 9.39915 8.18774 9.09091V8.55398C8.18774 8.24574 8.11814 7.97064 7.97894 7.72869C7.83973 7.48343 7.59115 7.3608 7.2332 7.3608C6.88519 7.3608 6.63495 7.48343 6.48249 7.72869C6.33334 7.97064 6.25877 8.24574 6.25877 8.55398ZM0.17354 3.2642V2.72727C0.17354 2.35606 0.249771 2.01634 0.402233 1.7081C0.558009 1.39654 0.783388 1.14796 1.07837 0.962358C1.37666 0.773437 1.73793 0.678977 2.16218 0.678977C2.59305 0.678977 2.95432 0.773437 3.24598 0.962358C3.53765 1.14796 3.75806 1.39654 3.9072 1.7081C4.05635 2.01634 4.13093 2.35606 4.13093 2.72727V3.2642C4.13093 3.63542 4.0547 3.9768 3.90223 4.28835C3.75309 4.59659 3.53102 4.84517 3.23604 5.03409C2.94437 5.2197 2.58642 5.3125 2.16218 5.3125C1.7313 5.3125 1.36838 5.2197 1.0734 5.03409C0.778417 4.84517 0.554695 4.59659 0.402233 4.28835C0.249771 3.9768 0.17354 3.63542 0.17354 3.2642ZM1.18774 2.72727V3.2642C1.18774 3.57244 1.26066 3.8492 1.40649 4.09446C1.55233 4.33641 1.80422 4.45739 2.16218 4.45739C2.51019 4.45739 2.75545 4.33641 2.89797 4.09446C3.0438 3.8492 3.11672 3.57244 3.11672 3.2642V2.72727C3.11672 2.41903 3.04712 2.14394 2.90791 1.90199C2.76871 1.65672 2.52013 1.53409 2.16218 1.53409C1.81416 1.53409 1.56393 1.65672 1.41147 1.90199C1.26232 2.14394 1.18774 2.41903 1.18774 2.72727ZM0.551381 11L7.55138 0.818182H8.6849L1.6849 11H0.551381Z" fill="currentColor"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <button aria-expanded="false" data-target="sportsbookPopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76k:">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Sportsbooks
                                        <span class="text-xs text-inherit ml-1 font-light">(All)</span>
                                    </div>
                                    <div class="h-4 w-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="sportsbookPopOver" data-headlessui-state="open">
                                <div class="rounded-lg border border-brand-gray-4  bg-[#25394D] text-brand-gray-7 shadow-lg">
                                    <div class="w-72 md:w-96">
                                        <div class="flex flex-row items-center justify-between p-4 text-white">
                                            <span class="text-sm text-inherit font-semibold">209 selected</span>
                                            <div class="flex items-center gap-2">
                                                <span class="ml-3 text-sm font-medium text-gray-500 dark:text-gray-300">Select All</span>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer  dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="border-b border-slate-500">
                                            
                                        </div>
                                        <div class="max-h-[400px] overflow-y-auto">
                                            <div class="mt-1 grid gap-5 p-4 sm:gap-3 grid-cols-2">

                                                 @if( !empty( getSportsBook() ) )
                                                    @foreach( getSportsBook() as $field )
                                                        <div class="form-check">
                                                            <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="sportsbook-{{$field->id}}">
                                                            <input type="checkbox" id="sportsbook-{{$field->id}}" name="sportsbook[]" value="{{$field->name}}" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">{{$field->name}} </label>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <button aria-expanded="false" data-target="allSportsPopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76m:">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Sport
                                        <span class="text-xs text-inherit ml-1 font-light">(All)</span>
                                    </div>
                                    <div class="h-4 w-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="allSportsPopOver" data-headlessui-state="open">
                                <div class="rounded-lg border border-brand-gray-4  bg-[#25394D] text-brand-gray-7 shadow-lg">
                                    <div class="w-72">
                                        <div class="flex flex-row items-center justify-between p-4 text-white">
                                            <span class="text-sm text-inherit font-semibold">209 selected</span>
                                            <div class="flex items-center gap-2">
                                            <span class="ml-3 text-sm font-medium text-gray-500 dark:text-gray-300">Select All</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="" class="sr-only peer" checked>
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer  dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                            </label>
                                            </div>
                                        </div>
                                        <div class="border-b border-slate-500">
                                        </div>
                                        <div class="max-h-[400px] overflow-y-auto">
                                            <div class="mt-1 grid gap-5 p-4 sm:gap-3 grid-cols-2">
                                                
                                                @if( !empty( getSports() ) )

                                                    @php 
                                                        $counter = 0;
                                                    @endphp

                                                    @foreach( getSports() as $val )
                                                        <div class="form-check">
                                                            <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="sports-{{$counter}}">
                                                            <input type="checkbox" name="sports[]" id="sports-{{$counter}}" value="{{$val}}" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                                {{ ucfirst($val) }} 
                                                            </label>
                                                        </div>
                                                        @php 
                                                            $counter++;
                                                        @endphp
                                                    @endforeach

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <button aria-expanded="false" data-target="marketPopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76q:">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Market
                                        <span class="text-xs text-inherit ml-1 font-light">(All)
                                            </span>
                                    </div>
                                    <div class="h-4 w-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="marketPopOver" data-headlessui-state="open">
                                <div class="rounded-lg border border-brand-gray-4  bg-[#25394D] text-brand-gray-7 shadow-lg">
                                    <div class="w-72">
                                        <div class="flex flex-row items-center justify-between p-4 text-white">
                                            <span class="text-sm text-inherit font-semibold">3 selected</span>
                                            <div class="flex items-center gap-2">
                                                <span class="ml-3 text-sm font-medium text-gray-500 dark:text-gray-300">Select All</span>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer  dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                    
                                                </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="border-b border-slate-500"></div>
                                        <div class="max-h-[400px] overflow-y-auto">
                                            <div class="mt-1 grid gap-5 p-4 sm:gap-3 grid-cols-1">

                                               
                                                <div class="form-check">
                                                    <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="41">
                                                    <input type="checkbox" name="market[]" value="Alternate Market" id="market-1" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                        Alternate Market 
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="40">
                                                    <input type="checkbox" name="market[]" value="Main Market" id="market-2" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                        Main Market
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="40">
                                                    <input type="checkbox" name="market[]" value="Player Prop" id="market-3" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                        Player Prop
                                                    </label>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative">
                            <button aria-expanded="false" data-target="daterangePopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76s:">
                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Date Range
                                        <span class="text-xs text-inherit ml-1 font-light">(All)</span>
                                    </div>
                                    <div class="h-4 w-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </div>
                                </div>
                            </button>
                            <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="daterangePopOver" data-headlessui-state="open">
                                <div class="rounded-lg border border-brand-gray-4  bg-[#25394D] text-brand-gray-7 shadow-lg">
                                    <div class="w-72">
                                        <div class="flex flex-row items-center justify-between p-4 text-white">
                                            <span class="text-sm text-inherit font-semibold">0 selected</span>
                                            <div class="flex items-center gap-2">
                                                <span class="ml-3 text-sm font-medium text-gray-500 dark:text-gray-300">Select All</span>
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" value="" class="sr-only peer" checked>
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer  dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                                    
                                                </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="border-b border-slate-500"></div>
                                        <div class="max-h-[400px] overflow-y-auto">
                                            <div class="mt-1 flex flex-col gap-3 p-6">
                                                <div class="form-check">
                                                    <label class="flex flex-row items-center text-white">
                                                        <input name="date_time[]" value="1" class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 
                                                        checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 
                                                        focus:checked:!bg-brand-blue-3" type="radio">
                                                        Today
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="flex flex-row items-center text-white">
                                                    <input name="date_time[]" value="2" class="mr-2 border-2 border-brand-gray-5 
                                                        bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 
                                                        focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                        Next 24 hours
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- end filter section -->

            <!-- table -->
            <div class="relative hidden md:block">

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <livewire:games-table />
                </div>

            </div>
            <!-- end table-->

            <!-- mobile view table -->
            <div class="block md:hidden">
                <div class="relative bg-[#1D2F41] rounded text-white my-2">

                        <div class="absolute flex w-full justify-between px-2">
                            <div class="flex flex-row items-center pt-2">
                                <span class="relative text-inherit h-fit w-fit">
                                    <div class="flex items-center gap-2.5">
                                        <button  id="calculator-icon-button" data-modal-target="calculatorModal" data-modal-toggle="calculatorModal" class="bg-transparent outline-none" class="hover:opacity-80 sm:p-1 xl:p-2.5">
                                            <svg width="19" height="19" class="h-5 w-5 text-purple-500" viewBox="0 0 14 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M1.39645 0.736376C0.961223 0.830673 0.685581 0.975748 0.428075 1.25139C0.239478 1.45449 0.141553 1.62495 0.058135 1.90785C0.00735898 2.08919 0.000105268 2.84721 0.000105268 9.99937C0.000105268 18.5769 -0.0107753 18.0329 0.188702 18.4282C0.355537 18.7582 0.798014 19.11 1.17883 19.2152C1.45085 19.2914 12.549 19.2914 12.821 19.2152C13.2019 19.11 13.6443 18.7582 13.8112 18.4282C14.0107 18.0329 13.9998 18.5769 13.9998 9.99937C13.9998 1.42548 14.0107 1.96588 13.8112 1.57418C13.6552 1.26227 13.249 0.924971 12.8827 0.794405C12.7268 0.740002 12.2371 0.732748 7.09061 0.729122C4.00053 0.725494 1.43634 0.729122 1.39645 0.736376ZM11.6423 3.51818C11.7112 3.54356 11.8019 3.6161 11.8491 3.68501C11.9288 3.8047 11.9325 3.83008 11.9325 4.74768C11.9325 5.57098 11.9252 5.70517 11.8708 5.79584C11.7366 6.02071 12.0159 6.00983 7.07248 6.00983C2.12907 6.00983 2.40834 6.02071 2.27415 5.79584C2.21974 5.70517 2.21249 5.57098 2.21249 4.74768C2.21249 3.83008 2.21612 3.8047 2.29591 3.68501C2.34306 3.6161 2.43373 3.54356 2.50264 3.51818C2.68398 3.45652 11.461 3.45652 11.6423 3.51818ZM3.9026 8.13517C4.1311 8.302 4.15286 8.36728 4.16374 8.89318C4.17462 9.31752 4.16737 9.39731 4.10208 9.54239C3.97514 9.82891 3.9026 9.8543 3.1192 9.8543C2.36844 9.8543 2.28865 9.83253 2.13995 9.59316C2.07104 9.48436 2.06741 9.4227 2.07467 8.92219C2.08555 8.30925 2.11094 8.24397 2.35756 8.10615C2.47 8.04449 2.55341 8.04087 3.14459 8.04812C3.74302 8.059 3.81193 8.06625 3.9026 8.13517ZM7.76158 8.1134C8.00095 8.23672 8.05173 8.38179 8.05173 8.95483C8.05173 9.50249 8.01184 9.62943 7.80148 9.77088C7.68542 9.85067 7.64552 9.8543 6.99994 9.8543C6.35436 9.8543 6.31447 9.85067 6.19841 9.77088C5.98805 9.62943 5.94815 9.50249 5.94815 8.95483C5.94815 8.38904 5.99893 8.23672 6.23105 8.11703C6.35073 8.05175 6.44141 8.04449 6.99269 8.04087C7.55122 8.04087 7.63464 8.04812 7.76158 8.1134ZM11.6423 8.10978C11.8889 8.24034 11.9143 8.30925 11.9252 8.92219C11.9325 9.4227 11.9288 9.48436 11.8599 9.59316C11.7112 9.83253 11.6314 9.8543 10.8807 9.8543C10.2714 9.8543 10.1988 9.84704 10.09 9.78176C9.89055 9.65845 9.82889 9.47348 9.82889 8.95846C9.82889 8.49422 9.85428 8.36728 9.98485 8.22584C10.1335 8.06625 10.2424 8.04449 10.8988 8.04087C11.432 8.04087 11.5335 8.05175 11.6423 8.10978ZM3.90986 11.6315C4.12384 11.762 4.17825 11.9542 4.16374 12.52C4.15286 13.0568 4.12747 13.1221 3.88084 13.2889C3.76841 13.3687 3.72489 13.3723 3.12283 13.3723C2.41922 13.3723 2.31041 13.347 2.16171 13.1439C2.0928 13.0532 2.08555 12.9806 2.07467 12.491C2.06741 11.9905 2.07104 11.9289 2.13995 11.8201C2.28865 11.5807 2.36844 11.5589 3.1192 11.5589C3.72852 11.5589 3.80105 11.5662 3.90986 11.6315ZM7.80148 11.6423C8.01184 11.7838 8.05173 11.9107 8.05173 12.4656C8.05173 12.9045 8.04085 12.9698 7.96831 13.0967C7.82687 13.3433 7.72894 13.3723 6.99994 13.3723C6.27094 13.3723 6.17302 13.3433 6.03157 13.0967C5.95903 12.9698 5.94815 12.9045 5.94815 12.4656C5.94815 11.9107 5.98805 11.7838 6.19841 11.6423C6.31447 11.5625 6.35436 11.5589 6.99994 11.5589C7.64552 11.5589 7.68542 11.5625 7.80148 11.6423ZM11.6713 11.6315C11.9071 11.7765 11.9361 11.8745 11.9252 12.491C11.9143 12.9806 11.9071 13.0532 11.8382 13.1439C11.6895 13.347 11.5807 13.3723 10.8771 13.3723C10.275 13.3723 10.2315 13.3687 10.119 13.2889C9.87241 13.1221 9.84702 13.0568 9.83614 12.52C9.82526 12.0957 9.83252 12.0159 9.8978 11.8708C10.0247 11.5843 10.0973 11.5589 10.8807 11.5589C11.4864 11.5589 11.5625 11.5662 11.6713 11.6315ZM3.9026 15.135C4.1311 15.3055 4.15286 15.3635 4.16374 15.9075C4.17825 16.4878 4.1456 16.6039 3.93162 16.7671L3.79743 16.8723H3.12283C2.38658 16.8723 2.31767 16.8578 2.15809 16.6438C2.0928 16.5567 2.08555 16.4806 2.07467 16.0018C2.06379 15.3635 2.09643 15.2619 2.36119 15.1205C2.51352 15.0407 2.54979 15.0371 3.16273 15.048C3.74302 15.0588 3.81193 15.0661 3.9026 15.135ZM11.6423 15.1241C11.9035 15.2619 11.9361 15.3635 11.9252 16.0018C11.9143 16.6003 11.8926 16.6655 11.6605 16.807C11.5589 16.8686 11.4102 16.8723 8.93306 16.8723C6.34711 16.8723 6.31447 16.8723 6.21654 16.7961C5.99167 16.6293 5.96629 16.5604 5.95541 16.0671C5.94815 15.8168 5.95178 15.5557 5.96629 15.4868C5.9953 15.3309 6.17664 15.1241 6.32535 15.0806C6.387 15.0625 7.55848 15.0443 8.96207 15.0443L11.4864 15.0407L11.6423 15.1241Z" fill="currentColor"></path></svg>
                                        </button>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center justify-center pt-1">
                            <p class="font-prompt text-xl">0.15%</p>
                            <label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-green-500 border border-green-500 ml-2 text-sm font-semibold">$1.88</label>
                        </div>
                        <div class="border-b">
                            <div class="py-2 text-center">
                                <p class="text-sm font-semibold text-white">Toronto Blue Jays 
                                    <span class="text-xs text-brand-gray-7">vs</span> Minnesota Twins</p>
                            </div>
                        </div>
                        <div class="border-b py-1">
                            <div class="text-center">
                                <p class="text-sm text-brand-gray-7">Wed Oct 4, 4:30am</p>
                            </div>
                            <div class="text-center">
                                <p class= "text-sm text-brand-gray-7">Baseball, ML
                                    B</p>
                                <div class="text-center">
                                    <p class= "text-sm text-blue-500">Player Stolen Bases</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 border-b">
                            <div class="flex justify-center">
                                <div class="py-1 text-center">
                                    <p class= "text-xs font-bold text-gray-400">BET 1</p>
                                    <p class= "text-sm font-bold text-white">$1063</p>
                                </div>
                            </div>
                            <div class="flex justify-center border-l">
                                <div class="py-1 text-center">
                                    <p class= "text-xs font-medium text-gray-400">BET 2</p>
                                    <p class= "text-sm font-bold text-white">$150</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 border-b">
                            <div class="flex flex-col justify-center px-1 py-1 text-sm text-white">
                                <div class="pb-1 text-center">
                                    <p class= " text-sm text-white">Royce Lewis Under 0.5</p>
                                    <p class= "text-sm font-bold text-white">-700</p>
                                </div>
                                <div class="mb-1 flex justify-center">
                                    <div class="grid grid-flow-col gap-1 overflow-auto">
                                        <div role="button" tabindex="-1" class="cursor-default w-[25px] h-[25px]">
                                            <div class="overflow-hidden rounded" style="height: 25px; width: 25px;">
                                                <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: 25px; height: 25px; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative;">
                                                    <img src="{{asset('public/assets/img/tipico.webp')}}" alt="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col justify-center border-l px-1 py-1">
                                <div class="pb-1 text-center">
                                    <p class="text-sm text-white">Royce Lewis Over 0.5</p>
                                    <p class="text-sm font-bold text-white">+710</p>
                                </div>
                                <div class="mb-1 flex justify-center">
                                    <div class="grid grid-flow-col gap-1 overflow-auto">
                                        <div role="button" tabindex="-1" class="cursor-default w-[25px] h-[25px]">
                                            <div class="overflow-hidden rounded" style="height: 25px; width: 25px;">
                                                <span style="box-sizing: border-box; display: inline-block; overflow: hidden; width: 25px; height: 25px; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative;">
                                                   <img src="{{asset('public/assets/img/tipico.webp')}}" alt="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-center py-2">
                                <button class="ml-auto flex items-center justify-center pr-2 text-brand-gray-7">
                                    <p class="mr-1 text-xs font-semibold text-brand-gray-7">All Sportsbooks</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="h-3 w-3 text-brand-gray-7"><path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z" clip-rule="evenodd"></path></svg>
                                </button>
                                <div class="ml-auto">
                                    <button class="h-full" type="button" aria-expanded="false" id="headlessui-popover-button-:rq7:"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-6 text-[#86A5B1] hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>  

            <!-- end mobile view table -->
        </div>
    </div>
</div>
@endsection


@section('extra-script')
{{Html::style('public/css/jquery.dataTables.min.css')}}
{{Html::script('public/js/jquery.dataTables.min.js')}}
<script>

        function showFilter(){
            const filter = document.getElementById("filterContainer");

            if(filter.classList.contains('hidden')){
                filter.classList.remove('hidden');
            }else{
                filter.classList.add('hidden');
            };

        }

        const popupButtons = document.querySelectorAll('.filter-btn');
        const popups = document.querySelectorAll('.pop-over');

        popupButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const targetPopupId = button.getAttribute('data-target');
                const targetPopup = document.getElementById(targetPopupId);

                popups.forEach(otherPopup => {
                    if (otherPopup !== targetPopup) {
                        otherPopup.classList.add('hidden');
                    }
                });

                targetPopup.classList.toggle('hidden');
                event.stopPropagation();
            });
        });

        document.addEventListener('click', (event) => {
            popups.forEach(popup => {
                if (!popup.contains(event.target)) {
                    popup.classList.add('hidden');
                }
            });
        });



</script>

<script>
    var sBaseURI = '{{ url('/') }}';
    var loading_image = "{{url('public/images/loading2.gif')}}";
    var sports_book = {!! json_encode(getSportsBook()) !!};
    var pageID = {!! isset($_GET['page']) ? $_GET['page'] : 1 !!};
    var baseURI = "{{url('/')}}";

    var is_live = {{ $_GET['is_live'] ?? 0 }};
    var is_hidden = {{ $_GET['is_hidden'] ?? 0 }};
</script>

{{Html::script('public/js/bjcdl/libraries/dashboard.js')}}

@endsection