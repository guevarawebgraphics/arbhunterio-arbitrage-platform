<div class="row settings-card mb-3">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                <span class="self-center text-2xl font-black whitespace-nowrap text-white">Overview</span>
                <p class="text-gray-400 text-sm my-4">Update your personal information</p>
            </div>
            
            <div class="row">
                @if ($message = Session::get('success'))
                  <div id="alert-3" class="flex items-center p-4 mb-4 text-white rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium">
                        {!! $message !!}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                      <span class="sr-only">Close</span>
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                    </button>
                  </div>
                @endif
                <form method="post" action="{{ route('settings.update_profile') }}">
                    @csrf
                    <input type="hidden" name="view" value="overview">
                    <div class="grid gap-6 mb-6 md:grid-cols-2 mb-3">
                        <div class="p-3">
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 text-white">First name</label>
                            <input 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="text" 
                                name="first_name"
                                id="first_name" 
                                placeholder="John" 
                                value="{{ Request::old('first_name') ?? auth()->user()->first_name }}"
                                required
                            >
                        </div>
                        <div class="p-3">
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 text-white">Last name</label>
                            <input 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="text" 
                                name="last_name"
                                id="last_name" 
                                placeholder="Doe" 
                                value="{{ Request::old('first_name') ?? auth()->user()->last_name }}"
                                required
                            >
                        </div>
                        <div class="p-3">
                            <label for="email_address" class="block mb-2 text-sm font-medium text-gray-900 text-white">Email address</label>
                            <input 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="email" 
                                name="email"
                                id="email_address" 
                                placeholder=""
                                value="{{ Request::old('email') ?? auth()->user()->email }}"
                                disabled
                                data-tooltip-target="email_tooltip" data-tooltip-placement="bottom"
                            >
                            <div id="email_tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Please message us if you would like to change your email address
                            </div>
                        </div>  
                        <div class="p-3">
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 text-white">Phone number (optional)</label>
                            <input 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                type="tel"
                                name="phone" 
                                id="phone"
                                placeholder="123-45-678"
                                pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                                value="{{ Request::old('phone') ?? auth()->user()->phone }}"
                            >
                        </div>
                        <div class="p-3">
                            <label for="state" class="block mb-2 text-sm font-medium text-gray-900 text-white">State</label>
                            <select id="state" name="state" style="width: 100%;" required>
                                <option value="Alabama">Alabama</option>
                                <option value="Alaska">Alaska</option>
                                <option value="Arizona">Arizona</option>
                                <option value="Arkansas">Arkansas</option>
                                <option value="California">California</option>
                                <option value="Colorado">Colorado</option>
                                <option value="Connecticut">Connecticut</option>
                                <option value="Delaware">Delaware</option>
                                <option value="District Of Columbia">District Of Columbia</option>
                                <option value="Florida">Florida</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Idaho">Idaho</option>
                                <option value="Illinois">Illinois</option>
                                <option value="Indiana">Indiana</option>
                                <option value="Iowa">Iowa</option>
                                <option value="Kansas">Kansas</option>
                                <option value="Kentucky">Kentucky</option>
                                <option value="Louisiana">Louisiana</option>
                                <option value="Maine">Maine</option>
                                <option value="Maryland">Maryland</option>
                                <option value="Massachusetts">Massachusetts</option>
                                <option value="Michigan">Michigan</option>
                                <option value="Minnesota">Minnesota</option>
                                <option value="Mississippi">Mississippi</option>
                                <option value="Missouri">Missouri</option>
                                <option value="Montana">Montana</option>
                                <option value="Nebraska">Nebraska</option>
                                <option value="Nevada">Nevada</option>
                                <option value="New Hampshire">New Hampshire</option>
                                <option value="New Jersey">New Jersey</option>
                                <option value="New Mexico">New Mexico</option>
                                <option value="New York">New York</option>
                                <option value="North Carolina">North Carolina</option>
                                <option value="North Dakota">North Dakota</option>
                                <option value="Ohio">Ohio</option>
                                <option value="Oklahoma">Oklahoma</option>
                                <option value="Oregon">Oregon</option>
                                <option value="Pennsylvania">Pennsylvania</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Rhode Island">Rhode Island</option>
                                <option value="South Carolina">South Carolina</option>
                                <option value="South Dakota">South Dakota</option>
                                <option value="Tennessee">Tennessee</option>
                                <option value="Texas">Texas</option>
                                <option value="Utah">Utah</option>
                                <option value="Vermont">Vermont</option>
                                <option value="Virginia">Virginia</option>
                                <option value="Washington">Washington</option>
                                <option value="West Virginia">West Virginia</option>
                                <option value="Wisconsis">Wisconsis</option>
                                <option value="Australia">Australia</option>
                                <option value="Canada (Alberta)">Canada (Alberta)</option>
                                <option value="Canada (British Columbia)">Canada (British Columbia)</option>
                                <option value="Canada (Manitoba)">Canada (Manitoba)</option>
                                <option value="Canada (New Brunswick)">Canada (New Brunswick)</option>
                                <option value="Canada (Newfoundland and Labrador)">Canada (Newfoundland and Labrador)</option>
                                <option value="Canada (Nova Scotia)">Canada (Nova Scotia)</option>
                                <option value="Canada (Ontario)">Canada (Ontario)</option>
                                <option value="Canada (Prince Edward Island)">Canada (Prince Edward Island)</option>
                                <option value="Canada (Quebec)">Canada (Quebec)</option>
                                <option value="Canada (Saskatchewan)">Canada (Saskatchewan)</option>
                                <option value="Canada (Yukon)">Canada (Yukon)</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Germany">Germany</option>
                                <option value="France">France</option>
                                <option value="Norway">Norway</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Russia">Russia</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Spain">Spain</option>
                                <option value="Other European Country">Other European Country</option>
                            </select>
                        </div>
                        <div class="p-3">
                            <label for="odds_format" class="block mb-2 text-sm font-medium text-gray-900 text-white">Odds format</label>
                            <select id="odds_format" name="odds_format" style="width: 100%;" required>
                                <option value="Decimal">Decimal</option>
                                <option value="American">American</option>
                                <option value="Fractional">Fractional</option>
                                <option value="Probability">Probability</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="grid gap-6 mb-6 md:grid-cols-2 mb-3" data-tooltip-target="push_notification_tooltip" data-tooltip-placement="bottom" style="cursor: not-allowed;">
                        <div class="p-3">
                            <span class="text-gray-600"><b>Enable Push Notifications</b> (sent through the <br>OddsJam mobile app)</span>
                        </div>
                        <div class="p-3">
                            <button 
                                name="enable_push_notification"
                                disabled="" 
                                class="bg-brand-gray-4 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out cursor-not-allowed" 
                                id="headlessui-switch-:R2dsqlf76:"
                                 role="switch" 
                                 type="button" 
                                 tabindex="0" 
                                 aria-checked="false" 
                                 data-headlessui-state="" 
                                 aria-labelledby="headlessui-label-:R1dsqlf76:"
                            >
                                 <span aria-hidden="true" class="translate-x-0 bg-white inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                    <div id="push_notification_tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Download our new mobile app to receive faster notifications
                    </div>
                    <hr class="mb-3">
                    <div class="text-right">
                        <a 
                            href="{{ route('settings.overview') }}"
                            class="text-white border border-gray-300 bg-gray-500 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
                        >
                            Cancel
                    </a>
                        <button 
                            type="submit" 
                            class="text-gray saveChangesBtn hover:bg-blue-500 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        >
                            Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<div class="row settings-card">
    <span class="text-white">
        Download the <b>OddsJam App</b>, and get push<br>
        notifications <b>directly to your phone.</b>
    </span>
</div>