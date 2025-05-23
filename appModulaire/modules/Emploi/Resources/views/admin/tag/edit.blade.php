@extends('Blog::layouts.admin')
    @section('content')
        <div class="card card-primary">
            <div class="container-fluid">
                <div class="row mb-2 pt-4 justify-content-end">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{Route('dashboard')}}">Accueil</a></li>
                            <li class="breadcrumb-item active"><a href="{{Route('tag.index')}}">Tag</a></li>
                            <li class="breadcrumb-item active">Modifier</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h3 class="card-title">modifier un tag</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ Route('tag.update',$tag) }}" method="POST">
                @csrf <!-- Pour la sécurité CSRF -->
                @method('put')
                <div class="card-body">
                    <!-- Champ Nom -->
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Entrez le Nom" value="{{ $tag->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Champ slug -->
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" class="form-control" id="slug" placeholder="Entrez le slug" value="{{ $tag->slug }}">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    @endsection
