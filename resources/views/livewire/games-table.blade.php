<div>
    <table class="w-full text-sm text-left text-[#86A5B1] dark:text-gray-400" id="arbitrage-table">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
            <tr>
                <th scope="col" class="p-4">
                </th>
                <th scope="col" class="px-6 py-3">
                    Percent
                </th>
                <th scope="col" class="px-6 py-3">
                    Event Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Event
                </th>
                 {{-- <th scope="col" class="px-6 py-3">
                    Status
                </th> --}}
                <th scope="col" class="px-6 py-3">
                    Market
                </th>
                <th scope="col" class="px-6 py-3">
                    Bets
                </th>
                <th scope="col" class="px-6 py-3">
                    Books
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="text-white" id="arbitrage_body">
            {{-- how do you sort this to desc. Please note that the profit_percentage is not  a field from database and also this is paginated array ($games) --}}
            @forelse($games ?? [] as $field)
            
                <tr class="border-b hover:bg-[#1D2F41]" id="table--row-{!! str_slug($field->bet_type) !!}-{!! str_slug($field->uid) !!}">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <span wire:loading class="placeholder-content">&nbsp;</span>
                            <span wire:loading.remove>
                                <button data-modal-target="calculatorModal" data-modal-toggle="calculatorModal" class="bg-transparent outline-none" type="button" data-id="{!! $field->uid !!}">
                                    <svg width="19" height="19" class="h-5 w-5 text-brand-purple" viewBox="0 0 14 20" fill="#B386D6" xmlns="http://www.w3.org/2000/svg"><path d="M1.39645 0.736376C0.961223 0.830673 0.685581 0.975748 0.428075 1.25139C0.239478 1.45449 0.141553 1.62495 0.058135 1.90785C0.00735898 2.08919 0.000105268 2.84721 0.000105268 9.99937C0.000105268 18.5769 -0.0107753 18.0329 0.188702 18.4282C0.355537 18.7582 0.798014 19.11 1.17883 19.2152C1.45085 19.2914 12.549 19.2914 12.821 19.2152C13.2019 19.11 13.6443 18.7582 13.8112 18.4282C14.0107 18.0329 13.9998 18.5769 13.9998 9.99937C13.9998 1.42548 14.0107 1.96588 13.8112 1.57418C13.6552 1.26227 13.249 0.924971 12.8827 0.794405C12.7268 0.740002 12.2371 0.732748 7.09061 0.729122C4.00053 0.725494 1.43634 0.729122 1.39645 0.736376ZM11.6423 3.51818C11.7112 3.54356 11.8019 3.6161 11.8491 3.68501C11.9288 3.8047 11.9325 3.83008 11.9325 4.74768C11.9325 5.57098 11.9252 5.70517 11.8708 5.79584C11.7366 6.02071 12.0159 6.00983 7.07248 6.00983C2.12907 6.00983 2.40834 6.02071 2.27415 5.79584C2.21974 5.70517 2.21249 5.57098 2.21249 4.74768C2.21249 3.83008 2.21612 3.8047 2.29591 3.68501C2.34306 3.6161 2.43373 3.54356 2.50264 3.51818C2.68398 3.45652 11.461 3.45652 11.6423 3.51818ZM3.9026 8.13517C4.1311 8.302 4.15286 8.36728 4.16374 8.89318C4.17462 9.31752 4.16737 9.39731 4.10208 9.54239C3.97514 9.82891 3.9026 9.8543 3.1192 9.8543C2.36844 9.8543 2.28865 9.83253 2.13995 9.59316C2.07104 9.48436 2.06741 9.4227 2.07467 8.92219C2.08555 8.30925 2.11094 8.24397 2.35756 8.10615C2.47 8.04449 2.55341 8.04087 3.14459 8.04812C3.74302 8.059 3.81193 8.06625 3.9026 8.13517ZM7.76158 8.1134C8.00095 8.23672 8.05173 8.38179 8.05173 8.95483C8.05173 9.50249 8.01184 9.62943 7.80148 9.77088C7.68542 9.85067 7.64552 9.8543 6.99994 9.8543C6.35436 9.8543 6.31447 9.85067 6.19841 9.77088C5.98805 9.62943 5.94815 9.50249 5.94815 8.95483C5.94815 8.38904 5.99893 8.23672 6.23105 8.11703C6.35073 8.05175 6.44141 8.04449 6.99269 8.04087C7.55122 8.04087 7.63464 8.04812 7.76158 8.1134ZM11.6423 8.10978C11.8889 8.24034 11.9143 8.30925 11.9252 8.92219C11.9325 9.4227 11.9288 9.48436 11.8599 9.59316C11.7112 9.83253 11.6314 9.8543 10.8807 9.8543C10.2714 9.8543 10.1988 9.84704 10.09 9.78176C9.89055 9.65845 9.82889 9.47348 9.82889 8.95846C9.82889 8.49422 9.85428 8.36728 9.98485 8.22584C10.1335 8.06625 10.2424 8.04449 10.8988 8.04087C11.432 8.04087 11.5335 8.05175 11.6423 8.10978ZM3.90986 11.6315C4.12384 11.762 4.17825 11.9542 4.16374 12.52C4.15286 13.0568 4.12747 13.1221 3.88084 13.2889C3.76841 13.3687 3.72489 13.3723 3.12283 13.3723C2.41922 13.3723 2.31041 13.347 2.16171 13.1439C2.0928 13.0532 2.08555 12.9806 2.07467 12.491C2.06741 11.9905 2.07104 11.9289 2.13995 11.8201C2.28865 11.5807 2.36844 11.5589 3.1192 11.5589C3.72852 11.5589 3.80105 11.5662 3.90986 11.6315ZM7.80148 11.6423C8.01184 11.7838 8.05173 11.9107 8.05173 12.4656C8.05173 12.9045 8.04085 12.9698 7.96831 13.0967C7.82687 13.3433 7.72894 13.3723 6.99994 13.3723C6.27094 13.3723 6.17302 13.3433 6.03157 13.0967C5.95903 12.9698 5.94815 12.9045 5.94815 12.4656C5.94815 11.9107 5.98805 11.7838 6.19841 11.6423C6.31447 11.5625 6.35436 11.5589 6.99994 11.5589C7.64552 11.5589 7.68542 11.5625 7.80148 11.6423ZM11.6713 11.6315C11.9071 11.7765 11.9361 11.8745 11.9252 12.491C11.9143 12.9806 11.9071 13.0532 11.8382 13.1439C11.6895 13.347 11.5807 13.3723 10.8771 13.3723C10.275 13.3723 10.2315 13.3687 10.119 13.2889C9.87241 13.1221 9.84702 13.0568 9.83614 12.52C9.82526 12.0957 9.83252 12.0159 9.8978 11.8708C10.0247 11.5843 10.0973 11.5589 10.8807 11.5589C11.4864 11.5589 11.5625 11.5662 11.6713 11.6315ZM3.9026 15.135C4.1311 15.3055 4.15286 15.3635 4.16374 15.9075C4.17825 16.4878 4.1456 16.6039 3.93162 16.7671L3.79743 16.8723H3.12283C2.38658 16.8723 2.31767 16.8578 2.15809 16.6438C2.0928 16.5567 2.08555 16.4806 2.07467 16.0018C2.06379 15.3635 2.09643 15.2619 2.36119 15.1205C2.51352 15.0407 2.54979 15.0371 3.16273 15.048C3.74302 15.0588 3.81193 15.0661 3.9026 15.135ZM11.6423 15.1241C11.9035 15.2619 11.9361 15.3635 11.9252 16.0018C11.9143 16.6003 11.8926 16.6655 11.6605 16.807C11.5589 16.8686 11.4102 16.8723 8.93306 16.8723C6.34711 16.8723 6.31447 16.8723 6.21654 16.7961C5.99167 16.6293 5.96629 16.5604 5.95541 16.0671C5.94815 15.8168 5.95178 15.5557 5.96629 15.4868C5.9953 15.3309 6.17664 15.1241 6.32535 15.0806C6.387 15.0625 7.55848 15.0443 8.96207 15.0443L11.4864 15.0407L11.6423 15.1241Z" fill="#    B386D6"></path></svg>
                                </button>
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span wire:loading class="placeholder-content">&nbsp;</span>
                        <span wire:loading.remove>{!! $field->profit_percentage !!}%</span>
                    </td>
                    <td class="px-6 py-4">
                        <span wire:loading class="placeholder-content">&nbsp;</span>
                        <span wire:loading.remove>{!! formatEventDate($field->start_date) !!}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span wire:loading class="placeholder-content">&nbsp;</span>
                        <span wire:loading.remove>
                            {!! formatEvent($field) !!}
                        </span>
                    </td>
                    {{-- <td class="px-6 py-4">
                        <span wire:loading class="placeholder-content">&nbsp;</span>
                        <span wire:loading.remove>
                            @if($field->is_live == 1 && (  $field->is_hidden == 1 || $field->is_hidden == 0 ) )
                                <span class="text-inherit hidden rounded-full py-0.5 px-2.5 text-xs leading-4 dark:bg-brand-blue dark:text-brand-gray-1 md:inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M3.25 4A2.25 2.25 0 001 6.25v7.5A2.25 2.25 0 003.25 16h7.5A2.25 2.25 0 0013 13.75v-7.5A2.25 2.25 0 0010.75 4h-7.5zM19 4.75a.75.75 0 00-1.28-.53l-3 3a.75.75 0 00-.22.53v4.5c0 .199.079.39.22.53l3 3a.75.75 0 001.28-.53V4.75z" />
                                    </svg> LIVE
                                </span>
                            @elseif($field->is_live == 0 && $field->is_hidden == 0)
                                <span class="text-inherit hidden rounded-full py-0.5 px-2.5 text-xs leading-4 dark:bg-brand-blue dark:text-brand-gray-1 md:inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                    <path d="M1 13.75V7.182L9.818 16H3.25A2.25 2.25 0 011 13.75zM13 6.25v6.568L4.182 4h6.568A2.25 2.25 0 0113 6.25zM19 4.75a.75.75 0 00-1.28-.53l-3 3a.75.75 0 00-.22.53v4.5c0 .199.079.39.22.53l3 3a.75.75 0 001.28-.53V4.75zM2.28 4.22a.75.75 0 00-1.06 1.06l10.5 10.5a.75.75 0 101.06-1.06L2.28 4.22z" />
                                    </svg>PRE-MATCH
                                </span>
                            @elseif($field->is_live == 0 && $field->is_hidden == 1)
                                
                            @endif
                        </span>
                         
                    </td> --}}
                    <td class="px-6 py-4">
                        <span wire:loading class="placeholder-content">&nbsp;</span>
                        <span wire:loading.remove>{!!$field->bet_type !!}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span>
                                <span wire:loading class="placeholder-content">&nbsp;</span>
                                <span wire:loading.remove>{!! $field->selection_line_a !!}</span>
                            </span>
                            <span>
                                <span wire:loading class="placeholder-content">&nbsp;</span>
                                <span wire:loading.remove>{!! $field->selection_line_b !!}</span>
                            </span>
                        </div>
                    </td>
                        <td class="px-6 py-4">
                        <div class="flex flex-col">
                            
                                <div class="flex flex-row items-center gap-2">
                                    <span>
                                        <span wire:loading class="placeholder-content">&nbsp;</span>
                                        <span wire:loading.remove>{!! $field->best_odds_a !!}</span>
                                    </span>
                                    <span wire:loading class="placeholder-content">&nbsp;</span>
                                     <span wire:loading.remove>
                                        {!! $field->sportsbook_a !!}
                                    </span>
                                </div>
                                <div class="flex flex-row items-center gap-2">
                                    <span>
                                        <span wire:loading class="placeholder-content">&nbsp;</span>
                                        <span wire:loading.remove>{!! $field->best_odds_b !!}</span>
                                    </span>
                                    <span wire:loading class="placeholder-content">&nbsp;</span>
                                    <span wire:loading.remove>
                                        {!! $field->sportsbook_b !!}
                                    </span>
                                </div>
                            
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($field->uid)
                        <span wire:loading class="placeholder-content">&nbsp;</span>
                        <span wire:loading.remove>
                            <button class="btn--view-modal"
                             id="btn--view-modal-{!! str_slug($field->bet_type) !!}-{!! str_slug($field->uid) !!}" 
                             data-slug="btn--view-modal-{!! str_slug($field->bet_type) !!}-{!! str_slug($field->uid) !!}" data-modal-target="viewModal" data-modal-toggle="viewModal" class="outline-none text-white" type="button" data-bet_type="{!! $field->bet_type !!}" data-id="{!! $field->uid !!}">
                                <svg class="w-6 h-6 text-gray-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                    <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"></path>
                                </svg>
                            </button>

                            <button class="btn--hidden-bet"
                             id="btn--hidden-bet-{!! str_slug($field->bet_type) !!}-{!! str_slug($field->uid) !!}"  data-is_hidden="{{$field->is_hidden == 1 ? 0 : 1 }}"
                             data-slug="btn--hidden-bet-{!! str_slug($field->bet_type) !!}-{!! str_slug($field->uid) !!}" class="outline-none text-white" type="button" data-bet_type="{!! $field->bet_type !!}" data-id="{!! $field->uid !!}">
                                
                                @if($field->is_hidden == 1 )
                                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                @else   
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                @endif

                                <script>
                                    console.log("{{$field->is_hidden}}");
                                </script>

                            </button>


                        </span>
                        @endif
                    </td>
                </tr>

            @empty

                <tr class="border-b hover:bg-[#1D2F41]">
                    <td colspan="9" class="text-center py-4">No record found</td>
                </tr>

            @endforelse

        </tbody>
    </table>
    <!-- Livewire pagination links -->
    @if( !empty(  $games ) )
        <!-- Livewire pagination links -->
        <div wire:loading.remove>
            {{ $games->render() }}
        </div>
    @endif

</div>

<script>

    document.getElementById("pre-match").innerHTML = "{{$pre_match_count}}";
    document.getElementById("live-count").innerHTML = "{{$live_count}}";
    document.getElementById("hidden-count").innerHTML = "{{$hidden_count}}";

</script>

<script>

    document.addEventListener('livewire:load', function () {
        window.livewire.on('updateCounts', (preMatchCount, liveCount, hiddenCount) => {
            document.getElementById("pre-match").innerHTML = preMatchCount;
            document.getElementById("live-count").innerHTML = liveCount;
            document.getElementById("hidden-count").innerHTML = hiddenCount;
        });
    });

</script>