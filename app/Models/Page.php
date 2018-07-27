<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $type
 * @property Collection $scripts
 * @property Collection $styles
 * @property Collection $tabs
 */
class Page extends Model
{
    public $timestamps = false;

    public function scripts()
    {
        return $this->hasManyThrough(Script::class, ScriptsToPage::class, 'page_id', 'id', 'id', 'script_id')
            ->select('script', 'position_head');
    }

    public function styles()
    {
        return $this->hasManyThrough(Style::class, StylesToPage::class, 'page_id', 'id', 'id', 'style_id')
            ->select('style')->orderBy('styles_to_pages.order', 'asc');
    }

    public function tabs()
    {
        return $this->hasMany(Tab::class)->with('tabItems')
            ->orderBy('tabs.order', 'asc');
    }
}
