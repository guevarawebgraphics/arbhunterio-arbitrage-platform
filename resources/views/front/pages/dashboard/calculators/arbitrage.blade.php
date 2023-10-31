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
                    <h1 class="text-5xl font-extrabold text-white">Arbitrage & Hedge Bet Calculator</h1>
                    <div class="mx-auto my-4">
                        <div class="page-offset-x mx-auto w-full lg:max-w-page text-white">
                            <ul class="no-scrollbar flex gap-4 flex-wrap" role="tablist">
                                <li role="tab">
                                    <a aria-current="page" class="bg-[#374A5C] border border-brand-gray-6 text-brand-gray-9 hover:bg-brand-gray-3 block p-2 px-3 rounded-[2.5rem] text-sm" href="{{route('calculator.arbitrage')}}">Arbitrage Calculator</a>
                                </li>
                                <li role="tab">
                                    <a class="bg-transparent border border-brand-gray-4 text-brand-gray-9 hover:bg-brand-gray-2 block p-2 px-3 rounded-[2.5rem] text-sm" href="{{route('calculator.bet_conversion')}}">Bonus Bet Converter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center w-full">
                <div class="grid md:w-96 w-full">
                        <div class="card py-6 px-4 sm:p-6 rounded-lg border h-fit my-auto">
                            <div class="space-y-6">
                                <div class="grid grid-flow-col grid-cols-[minmax(0,max-content)_1fr_1fr] items-start gap-3 grid-rows-[repeat(3,minmax(0,max-content))]">
                                    <span class="text-white self-center text-sm leading-4 font-medium">Odds</span>
                                    <span class="text-white self-center text-sm leading-4 font-medium">Stake</span>
                                    <span class="text-white self-center text-sm leading-4 font-medium">Payout</span>
                                    <div class="w-full">
                                        <div>
                                            <div class="relative">
                                                <div class="rounded border border-solid text-left h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full  min-w-[80px]">
                                                    <input step="0.1" name="homeOdds" placeholder="2.2" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center focus:ring-0 pl-4 pr-4 bg-brand-gray-2 placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-l rounded-r" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div>
                                            <div class="relative">
                                                <div class="min-w-0 rounded border border-solid text-left dark h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full dark">
                                                    <div class="flex shrink-0 items-center justify-center bg-brand-gray-2 rounded-l w-10 text-brand-gray-6">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                    <input placeholder="100" name="homeStake" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center focus:ring-0 pr-4 bg-brand-gray-2  placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-r dark min-w-[50px]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div class="relative">
                                            <div class="min-w-0 rounded border border-solid text-left h-10 bg-brand-gray-1 flex w-full">
                                                <div class="flex shrink-0 items-center justify-center bg-brand-gray-2 rounded-l w-10 text-brand-gray-6 !bg-brand-gray-3 text-brand-gray-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                                </div>
                                                <input type="text" disabled="" class="all-unset text-sm w-0 min-w-0 flex-1 items-center focus:ring-0 pr-4 bg-brand-gray-3 text-brand-gray-5 placeholder-brand-gray-7 dark:placeholder-brand-gray-6 rounded-r" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div>
                                            <div class="relative">
                                                <div class="rounded border border-solid text-left dark h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full dark min-w-[80px]">
                                                    <input step="0.1" name="awayOdds" placeholder="2.2" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center focus:ring-0 pl-4 pr-4 bg-brand-gray-2 placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-l rounded-r dark" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div>
                                            <div class="relative">
                                                <div class="min-w-0 rounded border border-solid text-left dark h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full dark">
                                                    <div class="flex shrink-0 items-center justify-center bg-brand-gray-2 rounded-l w-10 text-brand-gray-6">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                        <input placeholder="100" name="awayStake" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-centerfocus:ring-0 pr-4 bg-brand-gray-2 placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-r dark min-w-[50px]" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div class="relative">
                                            <div class="min-w-0 rounded border border-solid text-left h-10 bg-brand-gray-1 flex w-full">
                                                <div class="flex shrink-0 items-center justify-center bg-brand-gray-2 rounded-l w-10 text-brand-gray-6 !bg-brand-gray-3 text-brand-gray-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                                </div>
                                                <input type="text" disabled="" class="all-unset text-sm w-0 min-w-0 flex-1 items-center focus:ring-0 pr-4 bg-brand-gray-3 text-brand-gray-5 placeholder-brand-gray-7 dark:placeholder-brand-gray-6 rounded-r" value="0.00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end items-end gap-y-2.5 gap-x-6 w-full">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm text-white text-brand-gray-6">Total Stake</p>
                                        <p class="text-sm text-white font-semibold leading-6">$0.00</p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm text-white text-brand-gray-6">Total Payout</p>
                                        <p class="text-sm text-white font-semibold leading-6">$0.00</p>
                                    </div>
                                    <div class="flex flex-col gap-1 border-l pl-6">
                                        <p class="text-sm text-white text-brand-gray-6">Profit (0.00%)</p>
                                        <p class="text-sm text-white font-semibold leading-6">$0.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                </div>
            </div>
            <article class="bg-[#142230] card py-6 px-4 sm:p-6 my-4 text-white">
                <h2 class="font-semibold text-2xl pb-4 my-2">How to Use an Arbitrage &amp; Hedge Bet Calculator</h2>
                <p class="text-sm text-white whitespace-pre-line my-2">Hedge bet calculators are critical in sports betting, as they show you how to reduce risk or guarantee a risk free profit (e.g. arbitrage).<p>
                <p class="text-sm text-white whitespace-pre-line my-2">Arbitrage betting, or hedging a bet for a profit, is a risk-free approach to betting that guarantees a profit. It involves placing proportional bets on every possible outcome of an event (with different bookmakers) so regardless of what happens, you will make a profit. A sports betting arbitrage calculator, or hedge bet calculator, shows you how to hedge a bet for a profit and lock in a risk free return. You can read more about arbitrage betting in the linked blog post above, which contains an example of a profitable hedge bet. Arbitrage exists because bookmakers set their odds independently; in other words, the odds on Fanduel are not the same as the odds on DraftKings. When these odds get "out of sync," arbitrage can exist, which allows you to hedge your bets for a profit.</p>
                <p class="text-sm text-white whitespace-pre-line my-2">If you enter the Odds for any two-way market in the hedge bet calculator to the left, it will work out if there is an arbitrage opportunity and tell you how much you need to stake in order to guarantee a profit. You input how much money you are willing to wager on one side, and we show you exactly how much you need to bet on the other side to keep your profit constant. It doesn't matter whether you are betting $50 or $500, our arbitrage calculator will show you exactly how much money you will earn with each arbitrage opportunity.</p>
            </article>
        </div>
    </div>
</div>
    
@endsection