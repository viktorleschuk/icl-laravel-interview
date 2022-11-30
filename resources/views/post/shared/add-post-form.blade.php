<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <!-- Post preview-->
            <div class="post-preview">
                <a href="post.html">
                    <h2 class="post-title">Posts</h2>
                </a>
                <div class="card">
                    <div class="card-header text-center font-weight-bold">
                        Add new post:
                    </div>
                    <div class="card-body">
                      <form name="add-blog-post-form" enctype="multipart/form-data" id="add-blog-post-form" method="post" action="{{ route('posts.add') }}">
                       @csrf

                        <div class="form-group mb-4">
                            @error('title')
                                <div class="error alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required="" value="{{ old('title') }}">

                            @error('slug')
                            <div class="error alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                            <label for="slug">Slug</label>
                            <input type="text" id="slug" name="slug" class="form-control" required="" value="{{ old('slug') }}">

                            @error('description')
                                <div class="error alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" class="form-control" required="" value="{{ old('description') }}">

                            @error('body')
                                <div class="error alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                            <label for="body">Body</label>
                            <input type="text" id="body" name="body" class="form-control" required="" value="{{ old('body') }}">

                            <div class="form-group mt-4">
                                <label for="image">Post thumbnail </label>
                                <input
                                    type="file"
                                    class="form-control-file"
                                    id="image"
                                    name="image"
                                >
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group mb-3">
                            @error('category_id')
                                <div class="error alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                            <strong>Kategoria:</strong>
                            <select name="category_id" class="form-control custom-select">
                              <option value="">Select category</option>
                              @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @if(old('category_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="tags">Select Tags</label>
                            <select multiple class="form-control" name="tags[]" id="tags">
                                @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Zapisz</button>

                      </form>
                    </div>
                </div>
            <!-- Divider-->
            <hr class="my-4" />
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4"><a class="btn btn-primary text-uppercase" href="{{ route('posts.index') }}">Powrót do listy postów →</a></div>
        </div>
    </div>
</div>
