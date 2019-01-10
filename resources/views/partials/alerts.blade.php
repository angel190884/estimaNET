@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p class="text-lg-left">
            ¡¡¡ Se han encontrado algunos errores favor de solucionarlos antes de continuar !!!
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </p>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p class="text-lg-left">
            {{ session("success") }}
        </p>
    </div>
@endif
@if(session('danger'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p class="text-lg-left">
            {{ session("danger") }}
        </p>
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p class="text-lg-left">
            {{ session("warning") }}
        </p>
    </div>
@endif
@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p class="text-lg-left">
            {{ session("info") }}
        </p>
    </div>
@endif
