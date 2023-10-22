@extends('front.layouts.basev2')
@section('content')

<style>
    .settings-nav.active {
        color: #2170A0;
        background-color: #13212F;
        border-radius: 5px;
        border: 1px solid #2170A0;
    }
    .settings-nav:hover {
        color: #2170A0;
        background-color: #13212F;
        border-radius: 5px;
        border: 1px solid #2170A0;
    }
    .settings-card {
        border-radius: 5px;
        background-color: #13212F;
        padding: 2%;
    }
    input {
        background-color: #202F42 !important;
        border: 1px solid #364558 !important;
        color: #fff !important;
    }
    select {
        background-color: #202F42 !important;
        border: 1px solid #364558 !important;
        color: #fff !important;
    }
    .saveChangesBtn {
        background-color: #156077;
    }
    .settingsColor {
        color: #2E6B92;
    }

    .settingsCard {
        border-radius: 5px;
        border: 1px solid #364558 !important;
        background-color: #202F42;
        padding: 2%;
    }

    .successBadge {
        background-color: #324E1C;
        padding: 5px;
        border-radius: 15px;
        border: 1px solid #B3DA7E !important;
        color: #B3DA7E;
        font-weight: bold;
    }

    .dangerBadge {
        background-color: #6F1313;
        padding: 5px;
        border-radius: 15px;
        border: 1px solid #FFADA2 !important;
        color: #FFADA2;
        font-weight: bold;
    }
    .settingsBtn {
        background-color: #1D2F41;
        border: 1px solid #0099D2;
        color: #0099D2;
        border-radius: 5px;
        padding: 5px;
    }
    .settingsBtn:hover {
        background-color: #09131E;
        transition-delay: 0.2s;
    }
    .settingsCard table tr td {
        padding: 10px;
    }
    .settingsCard table tr {
        border-bottom: 1px solid gray;
    }

    .tagsinput,.tagsinput *{box-sizing:border-box}
.tagsinput{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-wrap:wrap;-ms-flex-wrap:wrap;flex-wrap:wrap;background:#fff;font-family:sans-serif;font-size:14px;line-height:20px;color:#556270;padding:5px 5px 0;border:1px solid #e6e6e6;border-radius:2px}
.tagsinput.focus{border-color:#ccc}
.tagsinput .tag{position:relative;background:#556270;display:block;max-width:100%;word-wrap:break-word;color:#fff;padding:5px 30px 5px 5px;border-radius:2px;margin:0 5px 5px 0}
.tagsinput .tag .tag-remove{position:absolute;background:0 0;display:block;width:30px;height:30px;top:0;right:0;cursor:pointer;text-decoration:none;text-align:center;color:#fff;line-height:30px;padding:0;border:0}
.tagsinput .tag .tag-remove:after,.tagsinput .tag .tag-remove:before{background:#fff;position:absolute;display:block;width:10px;height:2px;top:14px;left:10px;content:''}
.tagsinput .tag .tag-remove:before{-webkit-transform:rotateZ(45deg);transform:rotateZ(45deg)}
.tagsinput .tag .tag-remove:after{-webkit-transform:rotateZ(-45deg);transform:rotateZ(-45deg)}
.tagsinput div{-webkit-box-flex:1;-webkit-flex-grow:1;-ms-flex-positive:1;flex-grow:1}
.tagsinput div input{background:0 0;display:block;width:100%;font-size:14px;line-height:20px;padding:5px;border:0;margin:0 5px 5px 0}
.tagsinput div input.error{color:#fff}
.tagsinput div input::-ms-clear{display:none}
.tagsinput div input::-webkit-input-placeholder{color:#ccc;opacity:1}
.tagsinput div input:-moz-placeholder{color:#ccc;opacity:1}
.tagsinput div input::-moz-placeholder{color:#ccc;opacity:1}
.tagsinput div input:-ms-input-placeholder{color:#ccc;opacity:1}
</style>

<div class="flex">
    <!-- filter -->
    <div class="flex-none w-0 sm:w-14 ">
        @include('front.pages.dashboard.sections.profile-nav')
    </div>
    <!-- end filter -->

    <div class="flex-1">
        <div class="p-4 sm:ml-64">
            @include('front.pages.dashboard.profile.' . $view)
        </div>
    </div>
</div>
@endsection


@section('extra-script')
<script src="{{ asset('public/js/bjcdl/libraries/manage-filters.js') }}"></script>
<script>
    $(function() {
	$('#form-tags-1').tagsInput();

	$('#form-tags-2').tagsInput({
		'onAddTag': function(input, value) {
			console.log('tag added', input, value);
		},
		'onRemoveTag': function(input, value) {
			console.log('tag removed', input, value);
		},
		'onChange': function(input, value) {
			console.log('change triggered', input, value);
		}
	});

	$('#form-tags-3').tagsInput({
		'unique': true,
		'minChars': 2,
		'maxChars': 10,
		'limit': 5,
		'validationPattern': new RegExp('^[a-zA-Z]+$')
	});

	$('#form-tags-4').tagsInput({
		'autocomplete': {
			source: [
				'apple',
				'banana',
				'orange',
				'pizza'
			]
		}
	});

	$('#form-tags-5').tagsInput({
		'delimiter': ';'
	});

	$('#form-tags-6').tagsInput({
		'delimiter': [',', ';']
	});
});



</script>


@endsection