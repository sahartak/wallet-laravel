<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item @if(\request()->route()->uri == 'transaction/create')active @endif">
                <a class="nav-link" href="{{route('transaction.create')}}">Add transaction</a>
            </li>
            <li class="nav-item @if(\request()->route()->uri == 'transaction')active @endif">
                <a class="nav-link" href="{{route('transaction.index')}}">Wallet transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('transactions-chart')}}">Transactions chart</a>
            </li>
        </ul>
        <span class="navbar-text"> Wallet balance -
                $ {{ number_format($currentUser->balance, 2)}}
        </span>
        <input id="user_balance" type="hidden" value="{{$currentUser->balance}}">
    </div>
</nav>
