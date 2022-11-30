<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    protected $fillable = [
        'name'
    ];

    public function index(): View
    {
        $tags = Tag::paginate(5);

        return view('tag.list', [
            'tags' => $tags
        ]);
    }

    public function create(): View
    {
        return view('tag.add');
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        $tagName = $data['name'];

        $tag = new Tag;

        $tag->name = $tagName;
        $tag->save();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag został dodany do bazy danych.');
    }

    public function edit(int $tagId)
    {
        $tag = Tag::find($tagId);

        if($tag)
        {
            return view('tag.edit', [
                'tag' => $tag
            ]);
        }

        return redirect()
            ->route('tags.index');
    }

    public function update(Request $request)
    {
        $tag = Tag::find($request['id']);

        if($tag)
        {
            $tag->name = $request['name'];

            $tag->save();

            return redirect()
            ->route('tags.index')
            ->with('success', 'Nazwa tagu została zmieniona.');
        }
    }

    public function destroy(int $tagId)
    {
        $tag = Tag::find($tagId);

        if($tag)
        {
            $tag->delete();

            return redirect()
            ->route('tags.index')
            ->with('error', 'Tag został usunięty.');
        }
        else
        {
            return redirect()
            ->route('tags.index')
            ->with('error', 'Wystąpił błąd. Tag nie został usunięty.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }
}
