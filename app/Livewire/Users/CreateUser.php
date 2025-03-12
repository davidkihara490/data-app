<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $email;
    public $user;
    public $name;
    public $roles;
    public $role;
    public $role_id;
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'role' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'email.email' => 'This field should be an email',
        ];
    }
    public function mount()
    {
        $this->roles = Role::all();
    }

    public function submit()
    {
        $this->validate();
        try {
            $this->user->name = $this->name;
            $this->user->password = Hash::make('password');
            $this->user->email = $this->email;
            $this->user->save();
            $this->user->assignRole($this->role);

            return redirect()->route('users.index')->with(['success' => 'User created successfully.']);
        } catch (\Exception $e) {
            dd(vars: $e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.users.create-user');
    }
}
