<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabObat extends Component
{
    public $obatKunjungans;
    public $kunjungans;
    public $obats;

    /**
     * Create a new component instance.
     */
    public function __construct($obatKunjungans, $kunjungans, $obats)
    {
        $this->obatKunjungans = $obatKunjungans;
        $this->kunjungans = $kunjungans;
        $this->obats = $obats;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tab-obat');
    }
}
