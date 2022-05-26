@extends('front.layouts.base')

@section('content')

    <section class="py-5" id="features">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <!-- Contact form-->
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-envelope"></i></div>
                        <h1 class="fw-bolder">Get in touch</h1>
                        <p class="lead fw-normal text-muted mb-0">We'd love to hear from you</p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            {{  Form::open([
                                'method' => 'POST',
                                'id' => 'create-contact',
                                'route' => ['contact.store'],
                                'class' => '',
                                ])
                            }}
                                @if ($success = session('success'))
                                    <div class="form-floating mb-3">
                                        <div class="flash-success">{{ $success }}</div>
                                    </div>
                                @endif
                                
                                
                                @if (count($errors))
                                    <ul class="errors">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>    
                                @endif
                                <!-- Name input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control {{ $errors->has('name') ? 'invalid' : '' }}"            
                                    value="{{ old('name') }}" name="name" id="name" type="text" placeholder="Enter your name..." required />
                                    <label for="name">Full name</label>
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <!-- Email address input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control {{ $errors->has('email') ? 'invalid' : '' }}"            
                                    value="{{ old('email') }}" name="email" id="email" type="email" placeholder="name@example.com" required />
                                    <label for="email">Email address</label>
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <!-- Phone number input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control {{ $errors->has('phone') ? 'invalid' : '' }}"            
                                    value="{{ old('phone') }}" name="phone" id="phone" type="tel" placeholder="(123) 456-7890" required" />
                                    <label for="phone">Phone number</label>
                                    @if($errors->has('phone'))
                                        <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                                <!-- Subject input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control {{ $errors->has('subject') ? 'invalid' : '' }}"            
                                    value="{{ old('subject') }}" name="subject" id="subject" type="text" placeholder="Enter Subject..." required />
                                    <label for="name">Subject</label>
                                    @if($errors->has('subject'))
                                        <span class="invalid-feedback">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                                <!-- Message input-->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control {{ $errors->has('message') ? 'invalid' : '' }}"            
                                    name="message" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" required>{{ old('message') }}</textarea>
                                    <label for="message">Message</label>
                                    @if($errors->has('message'))
                                        <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                                <div class="form-floating mb-3">
                                    {!! NoCaptcha::display() !!}
                                    @if($errors->has('g-recaptcha-response'))
                                        <span class="invalid-feedback">{{ $errors->first('g-recaptcha-response') }}</span>
                                    @endif
                                </div>
                                
                                <div class="d-grid"><button class="btn btn-primary btn-lg" type="submit">Submit</button></div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <!-- Contact cards-->
                <div class="row gx-5 row-cols-2 row-cols-lg-4 py-5">
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-chat-dots"></i></div>
                        <div class="h5 mb-2">Chat with us</div>
                        <p class="text-muted mb-0">Chat live with one of our support specialists.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-people"></i></div>
                        <div class="h5">Ask the community</div>
                        <p class="text-muted mb-0">Explore our community forums and communicate with other users.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-question-circle"></i></div>
                        <div class="h5">Support center</div>
                        <p class="text-muted mb-0">Browse FAQ's and support articles to find solutions.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-telephone"></i></div>
                        <div class="h5">Call us</div>
                        <p class="text-muted mb-0">Call us during normal business hours at {{ getSystemSetting('BJCDL_008')->value }}.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    {!! NoCaptcha::renderJs() !!}
@endsection