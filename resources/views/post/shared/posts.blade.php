<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.html">
                    <h2 class="post-title">Posts:</h2>
                </a>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tytuł</th>
                            <th>Treść</th>
                            <th>Data modyfikacji</th>
                            <th>Opcje</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Tytuł</th>
                            <th>Treść</th>
                            <th>Data modyfikacji</th>
                            <th>Opcje</th>
                        </tr>
                        </tfoot>
                        <tbody>
                            @include('shared.messages')
                            @error('id')
                                <div class="error alert alert-danger">{{ $message }}</div>
                            @enderror
                            @foreach($posts ?? [] as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->body }}</td>
                                    <td>{{ $post->updated_at }}</td>
                                    <td>
                                        <a class="btn btn-secondary mb-2" href="{{ route('posts.edit', ['postId' => $post->id]) }}">Edytuj</a>
                                        <a class="btn btn-danger mb-2" href="{{ route('posts.remove', ['postId' => $post->id]) }}">Usuń</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-left">{{ $posts->links() }}</div>
                </div>

            </div>
            <!-- Divider-->
            <hr class="my-4" />
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="{{ route('posts.form') }}">Dodaj post</a></div>
        </div>
    </div>
</div>
