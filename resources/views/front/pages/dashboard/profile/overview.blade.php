<div class="row settings-card">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header">
                {{-- <span class="ml-3 text-white text-sm font-bold">Overview</span> --}}
                <span class="self-center text-2xl font-black whitespace-nowrap text-white">Overview</span>
                <p class="text-gray-400 text-sm my-4">Update your personal information</p>
            </div>
            
            <div class="row">
                <form>
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
                                required
                            >
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
                    <div class="grid gap-6 mb-6 md:grid-cols-2 mb-3">
                        <div class="p-3">
                            <span class="text-gray-600"><b>Enable Push Notifications</b> (sent through the <br>OddsJam mobile app)</span>
                        </div>
                        <div class="p-3">
                            <button 
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
                    <hr>
                </form>

            </div>
        </div>
    </div>
</div>