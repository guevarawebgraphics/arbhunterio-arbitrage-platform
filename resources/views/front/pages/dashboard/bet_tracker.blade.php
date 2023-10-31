@extends('front.layouts.basev2')
@section('content')

<div class="flex">
        <!-- filter -->
    <div class="flex-none w-0 sm:w-14 ">
        @include('front.layouts.sections.sidebar')
    </div>
    <!-- end filter -->

    <div class="flex-1">
        <div class="p-4 sm:ml-64">
            <div class="py-4">
                <div class="mb-4 py-8">
                    <div class="flex flex-col h-24">
                        <h1 class="text-7xl font-extrabold text-white">Bet Tracker</h1>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-y-4">
                <div class="mb-4 grid grid-cols-2 items-center gap-4 lg:mb-0 lg:flex lg:h-12 lg:flex-row">
                    <div class="w-full lg:w-fit">
                        <button class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center bg-[#314457] hover:bg-[#3d546b] text-white active:bg-brand-blue-2 text-sm h-10 px-[1.11rem] w-full lg:w-fit" type="button">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap"
                                >Sync Sportsbooks
                            </div>
                        </div>
                        </button>
                    </div>
                    <div class="col-span-2 w-full lg:w-fit">    
                        <button class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center bg-[#314457] hover:bg-[#3d546b] text-white active:bg-brand-gray-5 text-sm h-10 px-[1.11rem] w-full lg:w-fit" type="button">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                <div class="h-4 w-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                                </div>
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Add Bet</div>
                            </div>
                        </button>
                    </div>
                </div>
                <span class="hidden h-[48px] lg:block"></span>
                <div class="relative">
                    <div class="min-w-0 rounded border border-solid text-left h-10 border-brand-gray-4 my-4 bg-brand-gray-2 flex w-full basis-full lg:w-96 lg:basis-auto">
                        <div class="flex shrink-0 items-center justify-center bg-brand-gray-2 rounded-l w-10 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
                        </div>
                        <input id="bet-search" placeholder="Search in all fields" type="text" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-black focus:ring-0 pr-4 bg-brand-gray-2 placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-r">
                    </div>
                </div>
                <div class="mt-4 flex flex-row flex-wrap items-center justify-end gap-4 lg:ml-4 lg:mt-0">
                    <button class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center bg-[#314457] hover:bg-[#3d546b] text-white active:bg-brand-gray-5 text-sm h-10 px-[1.11rem]" type="button">
                        <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                            <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                                Show Open Bets
                            </div>
                        </div>
                    </button>
                    <button onclick="showFilter();" id="filters-button" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center bg-[#314457] hover:bg-[#3d546b] text-white active:bg-brand-gray-5 text-sm h-10 px-[1.11rem] group" type="button">
                        <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                            <div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.75 12.75h1.5a.75.75 0 000-1.5h-1.5a.75.75 0 000 1.5zM12 6a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 0112 6zM12 18a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 0112 18zM3.75 6.75h1.5a.75.75 0 100-1.5h-1.5a.75.75 0 000 1.5zM5.25 18.75h-1.5a.75.75 0 010-1.5h1.5a.75.75 0 010 1.5zM3 12a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 013 12zM9 3.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5zM12.75 12a2.25 2.25 0 114.5 0 2.25 2.25 0 01-4.5 0zM9 15.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"></path></svg>
                        </div>
                        <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                            <div class="flex flex-row items-center gap-2" data-testid="filters-toggle">
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Filters
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div id="filterContainer" class="hidden mt-6 rounded-md bg-[#142230] shadow mb-4">
                <div class="flex flex-row justify-between p-4">
                    <div class="mb-4 flex flex-row flex-wrap items-center text-white md:mb-0">
                        <h3 class="font-semibold text-xl font-code-next text-white">Filters</h3>
                    </div>
                    <div class="flex w-full flex-row gap-4 md:w-auto">
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
                        <button aria-expanded="false" data-target="statusPopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="percentage-filter">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Status
                                    <span class="text-sm text-inherit ml-1 font-light">(1)</span>
                                </div>
                                <div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </div>
                            </div>
                        </button>
                        <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="statusPopOver" data-headlessui-state="open">
                            <div class="rounded-lg bg-[#25394D] text-brand-gray-7 shadow-lg">
                                <div class="w-72">
                                    <div class="flex flex-row items-center justify-between p-4 text-white">
                                        <span class="text-sm text-inherit font-semibold">0 selected</span>
                                        <div class="flex items-center gap-2">
                                            <button class="min-w-0 max-w-md font-semibold inline-flex transition-all duration-200 ease-in-out items-center text-brand-blue-5 border border-brand-blue-5 bg-[#1D2F41] hover:border-brand-blue-3 hover:text-brand-blue-3 hover:bg-brand-gray active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-8 px-3 rounded" type="button">
                                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        Clear
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="border-b border-slate-500"></div>
                                    <div class="max-h-[400px] overflow-y-auto">
                                        <div class="mt-1 flex flex-col gap-3 p-6">
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Pending
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Won
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Lost
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Refunded
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Half Won
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Half Lost
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Cash out
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Completed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <button aria-expanded="false" data-target="typePopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76k:">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Type
                                    <span class="text-sm text-inherit ml-1 font-light">(All)</span>
                                </div>
                                <div class="h-4 w-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </div>
                            </div>
                        </button>
                        <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="typePopOver" data-headlessui-state="open">
                            <div class="rounded-lg bg-[#25394D] text-brand-gray-7 shadow-lg">
                                <div class="w-72">
                                    <div class="flex flex-row items-center justify-between p-4 text-white">
                                        <span class="text-sm text-inherit font-semibold">0 selected</span>
                                        <div class="flex items-center gap-2">
                                            <button class="min-w-0 max-w-md font-semibold inline-flex transition-all duration-200 ease-in-out items-center text-brand-blue-5 border border-brand-blue-5 bg-[#1D2F41] hover:border-brand-blue-3 hover:text-brand-blue-3 hover:bg-brand-gray active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-8 px-3 rounded" type="button">
                                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        Clear
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="border-b border-slate-500"></div>
                                    <div class="max-h-[400px] overflow-y-auto">
                                        <div class="mt-1 flex flex-col gap-3 p-6">
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Normal
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Low-Hold
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Arbitrage
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Middle
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Positive EV
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Future
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Parlay
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <button aria-expanded="false" data-target="syncedPopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76m:">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Synced
                                    <span class="text-sm text-inherit ml-1 font-light">(All)</span>
                                </div>
                                <div class="h-4 w-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" height="20" class="pb-0.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                </div>
                            </div>
                        </button>
                        <div class="hidden absolute z-50 mt-3 max-h-[500px] opacity-100 translate-y-0 pop-over"  tabindex="-1" id="syncedPopOver" data-headlessui-state="open">
                            <div class="rounded-lg bg-[#25394D] text-brand-gray-7 shadow-lg">
                                <div class="w-72">
                                    <div class="flex flex-row items-center justify-between p-4 text-white">
                                        <span class="text-sm text-inherit font-semibold">0 selected</span>
                                        <div class="flex items-center gap-2">
                                            <button class="min-w-0 max-w-md font-semibold inline-flex transition-all duration-200 ease-in-out items-center text-brand-blue-5 border border-brand-blue-5 bg-[#1D2F41] hover:border-brand-blue-3 hover:text-brand-blue-3 hover:bg-brand-gray active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-8 px-3 rounded" type="button">
                                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                    <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">
                                                        Clear
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="border-b border-slate-500"></div>
                                    <div class="max-h-[400px] overflow-y-auto">
                                        <div class="mt-1 flex flex-col gap-3 p-6">
                                            <div class="form-check">
                                                <label class="flex flex-row items-center text-white text-sm"><input class="mr-2 border-2 border-brand-gray-5 bg-transparent hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-8 focus:checked:!bg-brand-blue-3" type="radio">
                                                    Only Synced Bets
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <button aria-expanded="false" data-target="sportsbookPopOver" class="filter-btn min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center border border-[#4DC2EF] bg-[#25394D] hover:border-brand-blue-3 hover:bg-[#09131E] active:text-brand-blue-2 active:border-brand-blue-2 active:bg-brand-gray text-sm h-10 px-[1.11rem] no-underline disabled:text-brand-gray-4 text-[#86A5B1] hover:text-white" type="button" id="headlessui-popover-button-:r76k:">
                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5 text-left space-between">
                                <div class="min-w-0 overflow-hidden text-ellipsis whitespace-nowrap">Sportsbooks
                                    <span class="text-sm text-inherit ml-1 font-light">(All)</span>
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
                                    <div class="border-b border-slate-500"></div>
                                    <div class="max-h-[400px] overflow-y-auto">
                                        <div class="mt-1 grid gap-5 p-4 sm:gap-3 grid-cols-2">
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="41">
                                                <input type="checkbox" id="41" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">10bet </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="40">
                                                <input type="checkbox" id="40" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">888sport (Canada) </label>
                                            </div>
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
                                    <span class="text-sm text-inherit ml-1 font-light">(All)</span>
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
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="41">
                                                <input type="checkbox" id="41" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                    Baseball 
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="40">
                                                <input type="checkbox" id="40" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                    Aussie Rules
                                                </label>
                                            </div>
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
                                    <span class="text-sm text-inherit ml-1 font-light">(All)
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
                                                <input type="checkbox" id="41" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                    Alertnate Market 
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="40">
                                                <input type="checkbox" id="40" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                    Main Market
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 text-[#68CFF6]" for="40">
                                                <input type="checkbox" id="40" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 h-4 w-4 cursor-pointer appearance-none rounded-sm border-2 border-brand-gray-6 bg-transparent bg-contain bg-center bg-no-repeat align-top transition duration-200 focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 !rounded hover:bg-brand-gray-3 checked:border-brand-blue-3 checked:bg-brand-blue-3 checked:hover:border-brand-blue-3 checked:hover:bg-brand-blue-3 focus:!border-brand-blue-3 focus:ring-brand-blue-3 focus:checked:!bg-brand-blue-3" checked="">
                                                    Player Prop
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
            <div class="grid grid-cols-1">
                <div class="hidden md:flex overflow-x-auto w-full md:">
                    <table class="text-sm text-left text-[#86A5B1] dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Bet Created At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    SPORTBOOK
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    EVENT NAME
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    EVENT START DATE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    MARKET NAME
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BET NAME
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ODDS
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CLV
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    STAKE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    POTENTIAL PAYOUT
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    STATUS
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    BET TYPE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ACTIONS
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-white">
                            <tr class="border-b hover:bg-[#1D2F41]">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    Tue, Oct 3 at 9:57 AM
                                </td>
                                <td class="px-6 py-4">
                                    Mise-o-jeu
                                </td>
                                <td class="px-6 py-4">
                                    Connecticut vs Rice
                                </td>
                                <td class="px-6 py-4">
                                    Sun, Oct 8 at 5:00 AM
                                </td>
                                <td class="px-6 py-4">
                                    Total Points
                                </td>
                                <td class="px-6 py-4">
                                    Under 48.5
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500"> 2.25</span>
                                    
                                </td>
                                <td class="px-6 py-4">
                                    1.89
                                </td>
                                <td class="px-6 py-4">
                                    $84.48
                                </td>
                                <td class="px-6 py-4">
                                    $190.08
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-red-700 text-brand-purple-6 border border-brand-purple font-light text-sm font-semibold">Pending</label></div>
                                </td>
                                <td>
                                    <div class="flex flex-col items-center space-y-1 py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">Arbitrage</label><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">2.95%</label></div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5 justify-center"><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg></div></div></button><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-red-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg></div></div></button><a data-testid="link" target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" href="/game/connecticut-vs-rice-odds--30985-41877-23-40?market=total_points#Under_48point5"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg></div></div></a></div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-[#1D2F41]">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    Tue, Oct 3 at 9:57 AM
                                </td>
                                <td class="px-6 py-4">
                                    Mise-o-jeu
                                </td>
                                <td class="px-6 py-4">
                                    Connecticut vs Rice
                                </td>
                                <td class="px-6 py-4">
                                    Sun, Oct 8 at 5:00 AM
                                </td>
                                <td class="px-6 py-4">
                                    Total Points
                                </td>
                                <td class="px-6 py-4">
                                    Under 48.5
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500"> 2.25</span>
                                    
                                </td>
                                <td class="px-6 py-4">
                                    1.89
                                </td>
                                <td class="px-6 py-4">
                                    $84.48
                                </td>
                                <td class="px-6 py-4">
                                    $190.08
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-red-700 text-brand-purple-6 border border-brand-purple font-light text-sm font-semibold">Pending</label></div>
                                </td>
                                <td>
                                    <div class="flex flex-col items-center space-y-1 py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">Arbitrage</label><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">2.95%</label></div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5 justify-center"><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg></div></div></button><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-red-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg></div></div></button><a data-testid="link" target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" href="/game/connecticut-vs-rice-odds--30985-41877-23-40?market=total_points#Under_48point5"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg></div></div></a></div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-[#1D2F41]">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    Tue, Oct 3 at 9:57 AM
                                </td>
                                <td class="px-6 py-4">
                                    Mise-o-jeu
                                </td>
                                <td class="px-6 py-4">
                                    Connecticut vs Rice
                                </td>
                                <td class="px-6 py-4">
                                    Sun, Oct 8 at 5:00 AM
                                </td>
                                <td class="px-6 py-4">
                                    Total Points
                                </td>
                                <td class="px-6 py-4">
                                    Under 48.5
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500"> 2.25</span>
                                    
                                </td>
                                <td class="px-6 py-4">
                                    1.89
                                </td>
                                <td class="px-6 py-4">
                                    $84.48
                                </td>
                                <td class="px-6 py-4">
                                    $190.08
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-red-700 text-brand-purple-6 border border-brand-purple font-light text-sm font-semibold">Pending</label></div>
                                </td>
                                <td>
                                    <div class="flex flex-col items-center space-y-1 py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">Arbitrage</label><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">2.95%</label></div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5 justify-center"><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg></div></div></button><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-red-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg></div></div></button><a data-testid="link" target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" href="/game/connecticut-vs-rice-odds--30985-41877-23-40?market=total_points#Under_48point5"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg></div></div></a></div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-[#1D2F41]">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    Tue, Oct 3 at 9:57 AM
                                </td>
                                <td class="px-6 py-4">
                                    Mise-o-jeu
                                </td>
                                <td class="px-6 py-4">
                                    Connecticut vs Rice
                                </td>
                                <td class="px-6 py-4">
                                    Sun, Oct 8 at 5:00 AM
                                </td>
                                <td class="px-6 py-4">
                                    Total Points
                                </td>
                                <td class="px-6 py-4">
                                    Under 48.5
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500"> 2.25</span>
                                    
                                </td>
                                <td class="px-6 py-4">
                                    1.89
                                </td>
                                <td class="px-6 py-4">
                                    $84.48
                                </td>
                                <td class="px-6 py-4">
                                    $190.08
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-red-700 text-brand-purple-6 border border-brand-purple font-light text-sm font-semibold">Pending</label></div>
                                </td>
                                <td>
                                    <div class="flex flex-col items-center space-y-1 py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">Arbitrage</label><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">2.95%</label></div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5 justify-center"><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg></div></div></button><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-red-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg></div></div></button><a data-testid="link" target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" href="/game/connecticut-vs-rice-odds--30985-41877-23-40?market=total_points#Under_48point5"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg></div></div></a></div>
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-[#1D2F41]">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    Tue, Oct 3 at 9:57 AM
                                </td>
                                <td class="px-6 py-4">
                                    Mise-o-jeu
                                </td>
                                <td class="px-6 py-4">
                                    Connecticut vs Rice
                                </td>
                                <td class="px-6 py-4">
                                    Sun, Oct 8 at 5:00 AM
                                </td>
                                <td class="px-6 py-4">
                                    Total Points
                                </td>
                                <td class="px-6 py-4">
                                    Under 48.5
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500"> 2.25</span>
                                    
                                </td>
                                <td class="px-6 py-4">
                                    1.89
                                </td>
                                <td class="px-6 py-4">
                                    $84.48
                                </td>
                                <td class="px-6 py-4">
                                    $190.08
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center justify-center py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-red-700 text-brand-purple-6 border border-brand-purple font-light text-sm font-semibold">Pending</label></div>
                                </td>
                                <td>
                                    <div class="flex flex-col items-center space-y-1 py-2"><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">Arbitrage</label><label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">2.95%</label></div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2.5 justify-center"><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg></div></div></button><button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-red-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg></div></div></button><a data-testid="link" target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" href="/game/connecticut-vs-rice-odds--30985-41877-23-40?market=total_points#Under_48point5"><div class="flex min-w-0 flex-1 items-center justify-center gap-1.5"><div class="h-4 w-4"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg></div></div></a></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="block md:hidden text-sm font-normal my-4 text-white">
                    <li class="w-full overflow-hidden rounded border border-brand-gray-4 bg-[#1D2F41] pt-4 text-sm text-brand-gray-9 shadow">
                        <header class="px-4">
                            <section class="flex">
                                <div class="flex flex-1 flex-col space-y-2">
                                    <div class="flex flex-1 justify-between space-x-5">
                                            <div class="flex flex-row items-center">
                                                <label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-red-700 text-brand-red-7 border border-brand-red mr-2 font-light text-sm font-semibold">
                                                    Lost
                                                </label>
                                                <div class="flex flex-row flex-wrap gap-1">
                                                    <label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">
                                                        Arbitrage
                                                    </label>
                                                    <label class="inline-flex min-h-[22px] items-center rounded-full px-3 bg-[#005C80] text-brand-blue-6 border border-brand-blue-7 max-w-fit font-light text-center text-sm font-semibold">
                                                        2.95%
                                                    </label>
                                                </div>
                                            </div>
                                        <div class="flex flex-row items-center space-x-2">
                                            <button class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none mb-1.5" type="button">
                                                <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                    <div class="h-4 w-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path></svg>
                                                    </div>
                                                </div>
                                            </button>
                                            <div class="form-check">
                                                <label class="form-check-label ml-6 inline-block cursor-pointer select-none text-sm leading-5 !text-brand-gray-7 text-that-needs-wrapping" for="bets-list-select-21732848">
                                                    <input type="checkbox" id="bets-list-select-21732848" class="form-check-input float-left ml-[-1.5rem] mt-0.5 mr-2 appearance-none border-brand-gray-6 bg-contain bg-center bg-no-repeat align-top transition duration-200 checked:border-brand-blue checked:bg-brand-blue focus:outline-none checked:focus:outline-none checked:focus:bg-brand-blue checked:focus:ring-brand-blue hover:bg-brand-blue-1 checked:hover:bg-brand-blue-1 checked:focus:hover:bg-brand-blue-1 checked:focus:hover:ring-brand-blue-1 h-5 w-5 cursor-pointer rounded-sm border bg-white outline-0">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <p class="text-sm text-inherit pt-3 font-semibold">
                                <p class="text-base text-">
                                    Connecticut vs Rice
                                </p>
                            </p>
                        </header>
                        <section class="px-4 pt-2">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="flex flex-col">
                                    <span class="text-sm mb-1.5 leading-none text-gray-400">
                                        Stake
                                    </span>
                                    <span class="text-sm text-inherit">
                                        $84.48
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm mb-1.5 leading-none text-gray-400">
                                        Potential payout
                                    </span>
                                    <span class="text-sm text-inherit">
                                        $190.08
                                    </span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm mb-1.5 leading-none text-gray-400">
                                        Odds CLV
                                    </span>
                                    <span class="text-sm text-inherit flex">
                                        <div role="button" tabindex="-1" class="">
                                            <span class="text-sm text-green-400">
                                                2.25
                                            </span>
                                        </div>
                                        <span class="mx-1">/</span>
                                        <div role="button" tabindex="-1" class="">
                                            1.88
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </section>
                        <div class="px-4 py-4">
                            <div class="mt-6">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="flex flex-col">
                                        <p class="text-sm mb-1.5 leading-none text-gray-400">
                                            Sportsbook
                                        </p>
                                        <p class="text-sm text-inherit">
                                            Mise-o-jeu
                                        </p>
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-sm mb-1.5 leading-none text-gray-400">
                                            Market name
                                        </p>
                                        <p class="text-sm text-inherit">
                                                Total Points
                                        </p>
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-sm mb-1.5 leading-none text-gray-400">
                                            Bet name
                                        </p>
                                        <p class="text-sm text-inherit">
                                            Under 48.5
                                        </p>
                                    </div>
                                    <div class="col-span-2 flex flex-col space-y-1 font-normal leading-4">
                                        <p class="text-sm text-inherit">
                                            <span class="text-sm text-gray-400">
                                                Created time: 
                                            </span>
                                            Tue, Oct 3 at 9:57 AM
                                        </p>
                                        <p class="text-sm text-inherit">
                                            <span class="text-sm text-gray-400">Event start: </span>
                                            Sun, Oct 8 at 5:00 AM
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button">
                                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                <div class="h-4 w-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-gray-9 hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                                                </div>
                                            </div>
                                        </button>
                                        <button target="_blank" class="min-w-0 max-w-md font-semibold inline-flex rounded-md transition-all duration-200 ease-in-out items-center text-brand-blue-6 hover:text-brand-blue-3 active:text-brand-blue-2 underline underline-offset-4 text-sm h-8 px-3 shadow-none" type="button">
                                            <div class="flex min-w-0 flex-1 items-center justify-center gap-1.5">
                                                <div class="h-4 w-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="text-brand-red-6"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-script')

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
    
@endsection
