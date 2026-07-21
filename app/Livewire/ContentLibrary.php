<?php

namespace App\Livewire;

use App\Models\Video;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ContentLibrary extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $type = '';

    #[Url(history: true)]
    public string $category = '';

    public function updating($property): void
    {
        if (in_array($property, ['search', 'type', 'category'], true)) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'type', 'category']);
    }

    public function categories()
    {
        return Video::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    public function render()
    {
        $videos = Video::query()
            ->when($this->search, fn ($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->when($this->type, fn ($query) => $query->where('type', $this->type))
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('livewire.content-library', [
            'videos' => $videos,
            'categories' => $this->categories(),
        ]);
    }
}
