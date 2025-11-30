<?php

namespace App\Livewire\Features;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Category as CategoryModel;

class Category extends Component
{
    use WithPagination;

    public $search = '';
    protected $paginationTheme = 'bootstrap';

    public $categoryId, $name, $description;


    public function updatingSearch()
    {
        $this->resetPage();
    }


    private function resetInput()
    {
        $this->reset(['categoryId', 'name', 'description']);
        $this->resetValidation();
    }

    public function create()
    {
        $this->resetInput();
        $this->dispatch('showModal');
    }


    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        CategoryModel::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Category added successfully.');


        $this->dispatch('closeModal');
        $this->resetInput();
        $this->resetPage();
    }


    public function edit($id)
    {
        $category = CategoryModel::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;

        $this->dispatch('showModal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $category = CategoryModel::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Category updated successfully.');

        $this->dispatch('closeModal');
        $this->resetInput();
        $this->resetPage();
    }


public function delete($id)
{
    $category = CategoryModel::find($id);
    if ($category) {
        $category->delete();
    }
}
    public function cancel()
{
    $this->resetInput();
    $this->dispatch('closeModal');
}


    #[Layout('layouts.app')]
    public function render()
    {
        $categories = CategoryModel::query()
            ->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.features.category', compact('categories'));
    }
}
