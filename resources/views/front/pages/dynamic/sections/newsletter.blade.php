<aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
    <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
        <div class="mb-4 mb-xl-0">
            @if ($success = session('success'))
                <div class="fs-3 fw-bold text-white">{{ $success }}</div>
                <div class="text-white-50">We'll update you for an awesome incoming feature.</div>
            @else 
                <div class="fs-3 fw-bold text-white">New features, delivered to you.</div>
                <div class="text-white-50">Sign up for our newsletter for the latest updates.</div>
            @endif
        </div>
        {{  
            Form::open([
                'method' => 'POST',
                'id' => 'create-newsletter',
                'route' => ['newsletters.store'],
                'class' => '',
            ])
        }}
            <div class="ms-xl-4">
                <div class="input-group mb-2">
                    <input class="form-control" name="email" type="text" placeholder="Email address..." aria-label="Email address..." aria-describedby="button-newsletter" required />
                    <button class="btn btn-outline-light" id="button-newsletter" type="submit">Sign up</button>
                </div>
                @if (count($errors))
                    @foreach ($errors->all() as $error)
                        <div class="small text-white-50"><b>{{ $error }}</b></div>
                    @endforeach
                @else
                <div class="small text-white-50">We care about privacy, and will never share your data.</div>
                @endif
            </div>
        {{ Form::close() }}
    </div>
</aside>