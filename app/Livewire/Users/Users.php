<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Users extends Component
{
    public ?string $search;
    public $deleteId;
    public $showDeleteModal = false;
    public function confirm($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }
    public function deleteUser()
    {
        $user = User::findOrFail($this->deleteId);
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('users.index')->with(['error', 'Error deleting user :' . $th->getMessage()]);
        }
    }

    public function render()
    {
        // $users = User::query()
        //     ->orderByDesc('id')
        //     ->when(
        //         ! empty($this->search),
        //         fn(Builder $q) => $q->where('email', 'like', "%{$this->search}%")
        //     )->
        //     get();
        // ->paginate(10);
        $users = User::all();
        return view('livewire.users.users', [
            'users' => $users
        ]);
    }
}
