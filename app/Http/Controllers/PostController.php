<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {

        //TODO: add filter by tags

        $posts = Post::paginate(5);
        return view('post.list', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('post.add', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $_POST;

        $validator = Validator::make($data, [
            'title' => 'required',
            'description'  => 'required',
            'body'  => 'required',
            'category_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $title_too_long = false;
        $description_too_long = false;

        if (strlen($data['title']) > 100) {
            $title_too_long = true;
        }

        if (strlen($data['description']) > 250) {
            $description_too_long = true;
        }

        $category_exists = DB::table('categories')->get()->filter(function ($value) use ($data) {
                return $value->id == $data['category_id'];
        })->count() > 0;

        $errors = [];

        if ($title_too_long) {
            $errors['title'] = 'The Title is more than 100 characters. Try something shorter.';
        }

        if ($description_too_long) {
            $errors['description'] = 'The Description is more than 250 characters. Try something shorter.';
        }

        if ($category_exists) {
            $errors['category_id'] = 'Category not found.';
        }

        if (count($errors) > 0) {
            throw @ValidationException::withMessages($errors);
        }

        $post = new Post();

        $post->title = $data['title'];
        $post->slug = Str::slug($data['title']);
        $post->description = $data['description'];
        $post->body = $data['body'];
        $post->category_id = $data['category_id'];

        $newImage = $request->image;

        $path = null;

        if (!empty($newImage)) {
            $path = $newImage->store('post-thumbnails', 'public');


            if ($path) {
                $newImage = $path;
            }
        }

        $post->image = $newImage;

        $post->save();

        $post->tags()->attach($data['tags']);

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
        $categories = Category::all();
        $post = Post::whereId($postId)->first();

        if ($post) {
            return view('post.edit', compact('post', 'categories'));
        }

        return redirect()
            ->route('posts.index');
    }

    public function update(Request $request)
    {
        $data = $_POST;

        $post = Post::whereId($data['id'])->first();

        $validator = Validator::make($data, [
            'title' => 'required',
            'category_id'  => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $title_too_long = false;

        if (strlen($data['title']) > 100) {
            $title_too_long = true;
        }

        $category_exists = DB::table('categories')->get()->filter(function ($value) use ($data) {
                return $value->id == $data['category_id'];
            })->count() > 0;

        $errors = [];

        if ($title_too_long) {
            $errors['title'] = 'The Title is more than 100 characters. Try something shorter.';
        }

        if (! $category_exists) {
            $errors['category_id'] = 'Category not found.';
        }

        if (count($errors) > 0) {
            throw @ValidationException::withMessages($errors);
        }

        if ($post != null) {
            $post->update([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'description' => $data['description'],
                'body' => $data['body'],
                'category_id' => $data['category_id']
            ]);

            $newImage = $request->image;

            $path = null;
            if (!empty($newImage)) {
                $path = $newImage->store('post-thumbnails', 'public');
                // $path = $newImage->storeAs('post-thumbnails', $post->id() . '.png', 'public');

                if ($path) {
                    if (!empty($post->image)) {
                        Storage::disk('public')->delete($post->image);
                    }
                    $newImage = $path;
                }

                $post->update([
                    'image' => $newImage
                ]);
            }
        }

        if (!empty($post)) {
            return redirect()
                ->route('posts.index')
                ->with('success', 'updated');
        }

        return redirect()
            ->route('posts.index')
            ->with('error', 'something went wrong');
    }

    public function destroy(int $postId)
    {
        $post = Post::whereId($postId)->first();

        if (!empty($post)) {

            $path = null;
            if (!empty($post->image)) {
                Storage::disk('public')->delete($post->image);
                $post->image = $path;
            }

            // $post->tags()->detach();

            $post->delete();

            return redirect()
                ->route('posts.index')
                ->with('success', 'deleted');
        }

        return redirect()
            ->route('posts.index')
            ->with('error', 'something went wrong');
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->first();

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
