<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class UserService
{
    private $perPage = 10;

    public function __construct(
        private readonly Request $request
    ) {
    }

    public function getList(): LengthAwarePaginator
    {
        $query = User::query();

        if ($this->request->has('search')) {
            $query->where('name', 'like', '%' . $this->request->input('search') . '%');
        }

        if ($this->request->has('sort')) {
            if ($this->request->sort === 'asc' || $this->request->sort === 'desc') {
                $query->orderBy('name', $this->request->input('sort', 'asc'));
            }
        }

        $users = $query->paginate($this->perPage);

        return $users;
    }
}
