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
                    <h1 class="text-5xl font-extrabold text-white">Bet Conversion Calculator</h1>
                    <div class="mx-auto my-4">
                        <div class="page-offset-x mx-auto w-full lg:max-w-page text-white">
                            <ul class="no-scrollbar flex gap-4 flex-wrap" role="tablist">
                                <li role="tab">
                                    <a aria-current="page" class="border border-brand-gray-6 text-brand-gray-9 hover:bg-brand-gray-3 block p-2 px-3 rounded-[2.5rem] text-sm" href="{{route('calculator.arbitrage')}}">Arbitrage Calculator</a>
                                </li>
                                <li role="tab">
                                    <a class="bg-[#374A5C] border border-brand-gray-4 text-brand-gray-9 hover:bg-brand-gray-2 block p-2 px-3 rounded-[2.5rem] text-sm" href="{{route('calculator.bet_conversion')}}">Bonus Bet Converter</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-center w-full">
                <div class="grid md:w-96 w-full">
                     <div class="card py-6 px-4 sm:p-6 rounded-lg border h-fit my-auto">
                        <div class="grid gap-y-2 gap-x-4 xl:gap-x-12 mx-auto">
                            <div class="grid items-center calculator:text-end gap-y-2 gap-x-3 font-medium calculator:grid-cols-[max-content_minmax(0,1fr)] calculator:gap-y-4 text-brand-gray-7">
                                <span class="text-sm text-white font-medium">Free Play Amount</span>
                                <div class="w-full">
                                    <div>
                                        <div class="relative">
                                            <div class="min-w-0 rounded border border-solid text-left dark h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full dark">
                                                <div class="flex shrink-0 items-center justify-center bg-brand-gray-2 rounded-l w-10 text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" height="20"><path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z"></path><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd"></path></svg>
                                                </div>
                                                <input placeholder="100" name="freePlayAmount" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-white focus:ring-0 pr-4 bg-brand-gray-2 text-white placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-r dark min-w-[50px]" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-white font-medium">Free Play Line</p>
                                </div>
                                <div class="w-full">
                                    <div>
                                        <div class="relative">
                                            <div class="rounded border border-solid text-left dark h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full dark min-w-[80px]">
                                                <input step="0.1" name="freePlayLine" placeholder="2.2" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-white focus:ring-0 pl-4 pr-4 bg-brand-gray-2 text-white placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-l rounded-r dark" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-white font-medium">Hedge Line</p>
                                </div>
                                <div class="w-full">
                                    <div>
                                        <div class="relative">
                                            <div class="rounded border border-solid text-left dark h-10 border-brand-gray-4 bg-brand-gray-2 flex w-full dark min-w-[80px]">
                                                <input step="0.1" name="hedgeLine" placeholder="2.2" type="number" class="all-unset text-sm w-0 min-w-0 flex-1 items-center text-white focus:ring-0 pl-4 pr-4 bg-brand-gray-2 text-white placeholder-brand-gray-6 focus-within:border-brand-blue-8 rounded-l rounded-r dark" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div>
                                </div>
                                <div class="flex justify-end items-start gap-y-2.5 gap-x-6 w-full">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm text-white">Hedge Bet</p>
                                        <p class="text-sm text-white font-semibold leading-6">$0.00</p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <p class="text-sm text-white">$ Profit</p>
                                        <p class="text-sm text-white font-semibold leading-6">$0.00</p>
                                    </div>
                                    <div class="flex flex-col gap-1 pl-6 border-l">
                                        <p class="text-sm text-white">% Profit</p>
                                        <p class="text-sm text-white font-semibold leading-6">50.00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                </div>
            </div>
            <article class="bg-[#142230] card py-6 px-4 sm:p-6 my-4 text-white">
                <h2 class="font-semibold text-2xl pb-4 my-2">How to Use a Bet Conversion</h2>
                <p class="text-sm text-white whitespace-pre-line my-2">A free bet calculator (e.g. free play calculator), or free bet conversion calculator, determines the rate at which you can turn a free bet into cash. As part of many promotions and sign-up bonuses, US and Canadian sportsbooks offer "free bets," or freeplays. Free bets are different from cash because, if your wager wins, you do not get back your initial stake. Learn more about Free Bets in this article, What is a Free Bet? Learning how to use a free bet calculator will enable you to convert your free bets into cash at the highest possible rate with no risk.<p>
                <p class="text-sm text-white whitespace-pre-line my-2">As an example, imagine you have a $100 free bet on BetMGM. On the Free Bet Conversion Tool you see an opportunity on the Over/Under 50.5 in the New England Patriots vs Jacksonville Jaguars. If you place that $100 free bet on the Over 50.5 at +300 odds you could use this calculator to calculate the size of the hedge bet to make at a different sportsbook to lock in a guaranteed profit. In this case, you would need to place a $220 bet on the Under 50.5 at -275. No matter the outcome you would net $80 (Free bet wins = $300 minus $220 hedge bet = $80, hedge bet winds = $80).</p>
                <p class="text-sm text-white whitespace-pre-line my-2">Most sports bettors aim to get free bet conversion percentages over 70%. This means that for a $100 free bet, you will be able to earn $70 cash risk-free.</p>
            </article>
        </div>
    </div>
</div>
    
@endsection