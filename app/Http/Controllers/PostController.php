<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostHandlerService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{

    protected PostHandlerService $postHandlerService;

    public function __construct(PostHandlerService $postHandlerService)
    {
        $this->postHandlerService = $postHandlerService;
    }

    public function index(Request $request): View
    {
        // TODO: add filter by tags

        $posts = Post::query()
            ->whereHas('tags', function (Builder $builder) use ($request) {
                if ($request->has('tags')) {
                    $builder->whereIn('name', $request->tags);
                }
            })
            ->with('tags')
            ->paginate(5);

        return view('post.list', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('post.add', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $post = $this->postHandlerService->storePost($data, $request->image);

        if (!empty($post)) {
            return redirect()
                ->route('posts.index')
                ->with('success', 'added');
        }

        return redirect()
            ->route('posts.index')
            ->with('error', 'something went wrong');
    }

    public function edit(int $postId)
    {
        // Also could use route binding, but it`s a bad practice

        $categories = Category::all();

        $post = Post::query()->firstOrFail($postId);

        return view('post.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request)
    {
        // TODO: Incorrect USE ! 'PATH' is better for this realisation

        $post = Post::query()->firstOrFail($request->id);

        $this->postHandlerService->updatePost($post, $request->validated(), $request->image);

        return redirect()
            ->route('posts.index')
            ->with('success', 'updated');
    }

    public function destroy(int $postId)
    {
        // Also could use route binding, but it`s a bad practice

        $post = Post::query()->firstOrFail($postId);

        if (!empty($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->tags()->detach();

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'deleted');

    }

    public function show(string $slug)
    {
        $post = Post::query()->where('slug', $slug)->first();

        if (!empty($post)) {
            return view('blog.show', compact('post'));
        }

        return redirect()
            ->route('posts.index');
    }

    public function postIndex()
    {
        $posts = Post::paginate(5);

        return view('blog.index', compact('posts'));
    }

    public function welcomePage()
    {
        $posts = Post::paginate(5);

        return view('blog.welcome', compact('posts'));
    }
}
