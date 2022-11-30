<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $fillable = [
        'name'
    ];

    public function index(): View
    {
        $categories = Category::paginate(5);

        return view('category.list', [
            'categories' => $categories
        ]);
    }

    public function create(): View
    {
        return view('category.add');
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        $categoryName = $data['name'];

        $category = new Category;

        $category->name = $categoryName;
        $category->save();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategoria została dodana do bazy danych.');
    }

    public function edit(int $categoryId)
    {
        $category = Category::find($categoryId);

        if($category)
        {
            return view('category.edit', [
                'category' => $category
            ]);
        }

        return redirect()
            ->route('categories.index');
    }

    public function update(Request $request)
    {
        $category = Category::find($request['id']);

        if($category)
        {
            $category->name = $request['name'];

            $category->save();

            return redirect()
            ->route('categories.index')
            ->with('success', 'Nazwa kategorii została zmieniona.');
        }
    }

    public function destroy(int $categoryId)
    {
        $category = Category::find($categoryId);

        if($category)
        {
            $category->delete();

            return redirect()
            ->route('categories.index')
            ->with('error', 'Kategoria została usunięta');
        }
        else
        {
            return redirect()
            ->route('categories.index')
            ->with('error', 'Wystąpił błąd. Kategoria nie została usunięta');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }
}
