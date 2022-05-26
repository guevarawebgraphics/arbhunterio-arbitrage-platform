@extends('front.layouts.base')
@section('content')
<section class="page page--dashboard">
    <div id="dashboard">
        <section class="dashboard default-content">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.pages.dashboard.sections.nav')
                    </div>
                    <div class="col-md-9">
                        <div class="dashboard__content">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Address</h2>
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success">
                                            <p>{!! $message !!}</p>
                                        </div>
                                    @endif
                                    <div class="addressess">
                                        {{  Form::open([
                                            'method' => 'PUT',
                                            'id' => 'edit-address',
                                            'route' => ['address.update', auth()->user()->id],
                                            'class' => ''
                                            ])
                                        }}
                                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="billing_id" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->id : '' }}">
                                            <input type="hidden" name="shipping_id" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->id : '' }}">
                                            {{-- Billing Address --}}
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <h4>Billing Address</h4>
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_first_name') ? ' has-error' : '' }}">
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" id="billing_first_name" name="billing_first_name" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->first_name : '' }}">
                                                    @if ($errors->has('billing_first_name'))
                                                        <span id="billing_first_name-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_first_name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_last_name') ? ' has-error' : '' }}">
                                                    <label for="lastName">Last Name</label>
                                                    <input type="text" id="billing_last_name" name="billing_last_name" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->last_name : '' }}">
                                                    @if ($errors->has('billing_last_name'))
                                                        <span id="billing_last_name-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_last_name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_email') ? ' has-error' : '' }}">
                                                    <label for="emailAdress">Email Address</label>
                                                    <input type="text" id="billing_email" name="billing_email" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->email : '' }}">
                                                    @if ($errors->has('billing_email'))
                                                        <span id="billing_email-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_phone') ? ' has-error' : '' }}">
                                                    <label for="phoneNumber">Phone</label>
                                                    <input type="text" id="billing_phone" name="billing_phone" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->phone : '' }}">
                                                    @if ($errors->has('billing_phone'))
                                                        <span id="billing_phone-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_phone') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_address') ? ' has-error' : '' }}">
                                                    <label for="address1">Address 1</label>
                                                    <input type="text" id="billing_address" name="billing_address" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->address : '' }}">
                                                    @if ($errors->has('billing_address'))
                                                        <span id="billing_address-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_address') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="address2">Address 2</label>
                                                    <input type="text" id="billing_address_2" name="billing_address_2" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->address_2 : '' }}">
                                                    @if ($errors->has('billing_address_2'))
                                                        <span id="billing_address_2-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_address_2') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_country') ? ' has-error' : '' }}">
                                                    <div>
                                                        <label class="control-label" for="billing_country">Country</label>
                                                        <select name="billing_country" id="billing_country"
                                                                class="billing-country-select form-control form-control"
                                                                data-placeholder="Choose country.."
                                                                >
                                                            @if (!empty($countries))
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country->name }}"
                                                                            data-country-id="{{ $country->id }}"
                                                                            data-country-code="{{ $country->code }}"
                                                                            data-country-name="{{ $country->name }}"
                                                                            data-is-default="{{ $country->is_default }}"
                                                                            data-states="{{ json_encode($country->states()->get()) }}"
                                                                            {{ !empty(auth()->user()->billing_address) ?
                                                                                (auth()->user()->billing_address->country == $country->name ? 'selected' : '')
                                                                            : ($country->is_default == 1 ? 'selected' : '') }}
                                                                    >{{ $country->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @if ($errors->has('billing_country'))
                                                            <span id="billing_country-error" class="help-block animation-slideDown">
                                                                {{ $errors->first('billing_country') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_city') ? ' has-error' : '' }}">
                                                    <label for="city">City</label>
                                                    <input type="text" id="billing_city" name="billing_city" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->city : '' }}">
                                                    @if ($errors->has('billing_city'))
                                                        <span id="billing_city-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_city') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_state') ? ' has-error' : '' }}">
                                                    <div>
                                                        <label class="control-label" for="billing_state">State</label>
                                                        <select name="billing_state" id="billing_state"
                                                                class="billing-state-select form-control"
                                                                data-placeholder="Choose state.."
                                                                data-old-value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->state : '' }}">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('billing_zip') ? ' has-error' : '' }}">
                                                    <label for="zipcode">Zipcode</label>
                                                    <input type="text" id="billing_zip" name="billing_zip" class="form-control" value="{{ !empty(auth()->user()->billing_address) ? auth()->user()->billing_address->zip : '' }}">
                                                    @if ($errors->has('billing_zip'))
                                                        <span id="billing_zip-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('billing_zip') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Shipping Address --}}
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <h4>Shipping Address</h4>
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_first_name') ? ' has-error' : '' }}">
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" id="shipping_first_name" name="shipping_first_name" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->first_name : '' }}">
                                                    @if ($errors->has('shipping_first_name'))
                                                        <span id="shipping_first_name-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_first_name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_last_name') ? ' has-error' : '' }}">
                                                    <label for="lastName">Last Name</label>
                                                    <input type="text" id="shipping_last_name" name="shipping_last_name" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->last_name : '' }}">
                                                    @if ($errors->has('shipping_last_name'))
                                                        <span id="shipping_last_name-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_last_name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_email') ? ' has-error' : '' }}">
                                                    <label for="emailAdress">Email Address</label>
                                                    <input type="text" id="shipping_email" name="shipping_email" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->email : '' }}">
                                                    @if ($errors->has('shipping_email'))
                                                        <span id="shipping_email-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_phone') ? ' has-error' : '' }}">
                                                    <label for="phoneNumber">Phone</label>
                                                    <input type="text" id="shipping_phone" name="shipping_phone" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->phone : '' }}">
                                                    @if ($errors->has('shipping_phone'))
                                                        <span id="shipping_phone-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_phone') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_address') ? ' has-error' : '' }}">
                                                    <label for="address1">Address 1</label>
                                                    <input type="text" id="shipping_address" name="shipping_address" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->address : '' }}">
                                                    @if ($errors->has('shipping_address'))
                                                        <span id="shipping_address-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_address') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="address2">Address 2</label>
                                                    <input type="text" id="shipping_address_2" name="shipping_address_2" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->address_2 : '' }}">
                                                    @if ($errors->has('shipping_address_2'))
                                                        <span id="shipping_address_2-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_address_2') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_country') ? ' has-error' : '' }}">
                                                    <div>
                                                        <label class="control-label" for="shipping_country">Country</label>
                                                        <select name="shipping_country" id="shipping_country"
                                                                class="shipping-country-select form-control form-control"
                                                                data-placeholder="Choose country..">
                                                            @if (!empty($countries))
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country->name }}"
                                                                            data-country-id="{{ $country->id }}"
                                                                            data-country-code="{{ $country->code }}"
                                                                            data-country-name="{{ $country->name }}"
                                                                            data-is-default="{{ $country->is_default }}"
                                                                            data-states="{{ json_encode($country->states()->get()) }}"
                                                                            {{ !empty(auth()->user()->shipping_address) ?
                                                                                (auth()->user()->shipping_address->country == $country->name ? 'selected' : '')
                                                                            : ($country->is_default == 1 ? 'selected' : '') }}
                                                                    >{{ $country->name }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @if ($errors->has('shipping_country'))
                                                            <span id="shipping_country-error" class="help-block animation-slideDown">
                                                                {{ $errors->first('shipping_country') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_city') ? ' has-error' : '' }}">
                                                    <label for="city">City</label>
                                                    <input type="text" id="shipping_city" name="shipping_city" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->city : '' }}">
                                                    @if ($errors->has('shipping_city'))
                                                        <span id="shipping_city-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_city') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_state') ? ' has-error' : '' }}">
                                                    <div>
                                                        <label class="control-label" for="shipping_state">State</label>
                                                        <select name="shipping_state" id="shipping_state"
                                                                class="shipping-state-select form-control"
                                                                data-placeholder="Choose state.."
                                                                data-old-value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->state : '' }}">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 form-group{{ $errors->has('shipping_zip') ? ' has-error' : '' }}">
                                                    <label for="zipcode">Zipcode</label>
                                                    <input type="text" id="shipping_zip" name="shipping_zip" class="form-control" value="{{ !empty(auth()->user()->shipping_address) ? auth()->user()->shipping_address->zip : '' }}">
                                                    @if ($errors->has('shipping_zip'))
                                                        <span id="shipping_zip-error" class="help-block animation-slideDown">
                                                            {{ $errors->first('shipping_zip') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/libraries/front_address.js') }}"></script>
@endpush