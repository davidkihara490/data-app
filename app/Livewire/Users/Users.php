<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Users extends Component
{    use WithPagination;

    public ?string $search;

    public $deleteId;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }
    public function delete()
    {
        $user = User::findOrFail($this->deleteId);
        $user->delete();
        return redirect()->route('users.index')->with(['success', 'User has been deleted successfully']);
    }

    public function render()
    {
        $users = User::query()
            ->orderByDesc('id')
            ->when(
                ! empty($this->search),
                fn(Builder $q) => $q->where('email', 'like', "%{$this->search}%")
            )->
            get();
            // ->paginate(10);
        return view('livewire.users.users', [
            'users' => $users
        ]);
    }
}
