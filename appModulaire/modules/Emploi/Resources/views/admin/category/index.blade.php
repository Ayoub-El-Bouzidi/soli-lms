@extends('Blog::layouts.admin')
    @section('content')
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Liste des catégories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{Route('dashboard')}}">Accueil</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row mb-2 justify-content-end">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            
                            <form action="{{route('categories.import')}}" method="POST" class="mr-2" enctype="multipart/form-data">
                                @csrf
                                <div class="btn btn-success py-0 px-2 d-flex align-items-center">
                                    <label for="file" class="my-0 py-0" style="cursor: pointer; color: white">
                                        <i class="fas fa-upload"></i>
                                    </label>
                                    <input class="d-none" type="file" name="file" id="file" accept=".xlsx, .csv" required>
                                    <button type="submit" class="btn btn-s text-white border-0">
                                        Import
                                    </button>
                                    @error('file')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </form>
                            <a href="{{ route('categories.export') }}" class="text-white">
                                <div class="mr-2 d-flex align-items-center btn btn-danger btn-s">
                                    <i class="fas fa-download"></i> <span class="ml-2">Exporter</span>
                                </div>
                            </a>
                            <a href="{{ Route('category.create') }}" class="text-white">
                                <div class="mr-2 d-flex align-items-center btn btn-primary btn-s">
                                        <i class="fas fa-plus"></i><span class="ml-2">Ajouter catégorie</span>
                                </div>
                            </a>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Table des catégories</h3>
                    </div>
                    <!-- /.card-header -->
                    @if($categories->isEmpty())
                        <p class="p-5 text-center">aucun article trouvé.</p>
                    @else
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom</th>
                                        <th>slug</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ Route('category.edit',$category) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                                            <form action="{{ Route('category.destroy',$category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> </button>
                                            </form>
                                            <a href="{{ Route('category.show',$category) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <!-- /.card-body -->
                </div>
                {{ $categories->links('pagination::bootstrap-5') }}
                <!-- /.card -->
            </div>
        </section>
    @endsection
