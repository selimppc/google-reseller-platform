<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $title;
    public $description;
    public $keywords;
    public $author;
    public $og_image;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null, $description = null, $keywords = null, $author = null, $ogImage = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->author = $author;
        $this->og_image = $ogImage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.app-layout');
    }
}
