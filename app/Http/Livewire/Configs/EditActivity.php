<?php

namespace App\Http\Livewire\Configs;

use App\Models\Activities;
use App\Models\Companies;
use App\Models\Countries;
use Livewire\Component;

class EditActivity extends Component
{
    public $activity;
    public $loading = false;

    public function mount($id)
    {
        $activity = Activities::findOrFail($id);
        $this->activity = $activity->toArray();

        $this->countries = Countries::all();
        $this->companies = Companies::where('type', 'activities')->get();
    }

    public function update()
    {
         $this->loading = true;

        $this->validate([
            'activity.activity_code' => 'required|string',
            'activity.title' => 'string|max:255',
            'activity.city' => 'string|max:255',
            'activity.company_id' => 'nullable|exists:companies,id',
            'activity.country_id' => 'nullable|exists:countries,id',
            'activity.period' => 'integer|min:1',
            'activity.description' => 'string|max:1000',
        ]);

        $activity = Activities::findOrFail($this->activity['id']);

        $activity->update($this->activity);

        $this->loading = false;

        return redirect()->route('activity-config')->with('success', 'Activity edited successfully.'); // Adjust if your list route is different
    }

    public function render()
    {
        return view('livewire.configs.edit-activity');
    }
}
