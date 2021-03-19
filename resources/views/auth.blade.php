<div>
    @if(request()->user())
        <div class="mb-3">
            <h4>Hello, {{request()->user()->name}}!</h4>
        </div>
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('logout') }}">Log out</a>
        </div>
    @else
        <div class="mb-3">
            <a class="btn btn-secondary" href="{{ route('login') }}">Login</a>
        </div>
    @endif
</div>
