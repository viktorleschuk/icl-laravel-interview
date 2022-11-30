<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.html">
                    <h2 class="post-title">Tags:</h2>
                </a>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nazwa</th>
                            <th>Opcje</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Nazwa</th>
                            <th>Opcje</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            @include('shared.messages')
                            @error('id')
                                <div class="error alert alert-danger">{{ $message }}</div>
                            @enderror
                            @foreach($tags ?? [] as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>
                                        <a class="btn btn-secondary mb-2" href="{{ route('tags.edit', ['tagId' => $tag->id]) }}">Edytuj</a>
                                        <a class="btn btn-danger mb-2" href="{{ route('tags.remove', ['tagId' => $tag->id]) }}">Usuń</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-left">{{ $tags->links() }}</div>
                </div>

            </div>
            <!-- Divider-->
            <hr class="my-4" />
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="{{ route('tags.form') }}">Dodaj tag</a></div>
        </div>
    </div>
</div>
