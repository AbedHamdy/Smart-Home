@if(session('error'))
    <div class="form-message error">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="form-message success">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="form-message error">
        <ul class="mb-0 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
