<?php

namespace App\Livewire;

use App\Models\GalleryItem;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class GalleryGrid extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public string $category = '';

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $items = GalleryItem::query()
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->latest()
            ->paginate(16);

        return view('livewire.gallery-grid', [
            'items' => $items,
            'categories' => [
                'events' => 'Events',
                'meetups' => 'Meetups',
                'conventions' => 'Conventions',
                'cosplay' => 'Cosplay',
                'behind-the-scenes' => 'Behind the Scenes',
            ],
        ]);
    }
}
