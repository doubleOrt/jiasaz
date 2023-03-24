@extends("admin.app")

@section("page_title")
    Users
@endsection

@php
    $user = auth()->user();

    $PAGE_MAIN_TEXT = "View Users"
@endphp

@include("php-utils")


@section("content")
    <!-- PAGE CONTENT-->
    <div class="page-content--bgf7">
        <!-- BREADCRUMB-->
        <section class="au-breadcrumb2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="au-breadcrumb-content">
                            <div class="au-breadcrumb-left">
                                <span class="au-breadcrumb-span">You are here:</span>
                                <ul class="list-unstyled list-inline au-breadcrumb__list">
                                    <li class="list-inline-item active">
                                        <a href="/">Home</a>
                                    </li>
                                    <li class="list-inline-item seprate">
                                        <span>/</span>
                                    </li>
                                    <li class="list-inline-item">View Users</li>
                                </ul>
                            </div>
                            <form class="au-form-icon--sm" action="" method="post">
                                <input class="au-input--w300 au-input--style2" type="text" placeholder="Search for datas &amp; reports...">
                                <button class="au-btn--submit2" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row px-3 mt-4">
                    <div class="col-md-12 text-left">
                            <h3>{{ $PAGE_MAIN_TEXT }}</h3>
                        </div>
                        <div class="col md-12"><hr /></div>
                    </div>
                </div>
                @php
                    $roles = Spatie\Permission\Models\Role::all();
                @endphp
                @component('admin.components.users-table')
                    @slot("users_rows")
                        @foreach ($users as $user) 
                            @include("admin.components.users-table-single-row")
                        @endforeach
                    @endslot
                @endcomponent
            </div>
        </section>
    </div>

    @include("components.map-modal")


@endsection
