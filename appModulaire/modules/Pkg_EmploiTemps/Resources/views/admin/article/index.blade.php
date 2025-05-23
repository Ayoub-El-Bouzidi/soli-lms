@extends('Blog::layouts.admin')
    @section('content')
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{-- <h1>Liste des Articles</h1> --}}
                        <h1>{{ __('message.List of articles') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ __('message.home') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('message.Articles') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row mb-2 justify-content-end">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            {{-- <form action="{{route('articles.import')}}" method="POST" class="mr-2" enctype="multipart/form-data">
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
                            </form> --}}
                            <a href="{{ route('articles.export') }}" class="text-white">
                                <div class="mr-2 d-flex align-items-center btn btn-danger btn-s">
                                    <i class="fas fa-download"></i> <span class="ml-2">Exporter</span>
                                </div>
                            </a>
                            <a href="{{ Route('article.create') }}" class="text-white">
                                <div class="mr-2 d-flex align-items-center btn btn-primary btn-s">
                                        <i class="fas fa-plus"></i><span class="ml-2">{{ __('message.add article') }}</span>
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
                        <h3 class="card-title">{{ __('message.table of articles') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('message.title') }}</th>
                                    <th>{{ __('message.category') }}</th>
                                    <th>{{ __('message.user') }}</th>
                                    <th>{{ __('message.post date') }}</th>
                                    <th>{{ __('message.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->category->name }}</td>
                                        <td>{{ $article->user->name }}</td>
                                        <td>{{ $article->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{Route('article.show',$article)}}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{Route('article.edit',$article)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                                            <form action="{{ route('article.destroy', $article) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                <!-- Plus de lignes ici -->
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            {{ $articles->links('pagination::bootstrap-5') }}
        </section>
    @endsection
