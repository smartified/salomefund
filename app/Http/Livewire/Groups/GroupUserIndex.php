<?php

namespace App\Http\Livewire\Groups;

use App\Models\Group;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GroupUserIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Group $group;
    public $selecteduser;

    public $rules = [
        'selecteduser' => 'required'
    ];

    public function save()
    {
        $this->group->users()->attach($this->selecteduser);
    }

    public function render()
    {
        $users = $this->group->users()->paginate(10);
        $non_members = User::where('is_admin', false)->whereNotIn('id', $users->pluck('id'))->get();

        return view('livewire.groups.group-user-index', compact('users', 'non_members'));
    }

    public function remove(User $user)
    {
        $this->group->users()->detach($user->id);
    }
}
