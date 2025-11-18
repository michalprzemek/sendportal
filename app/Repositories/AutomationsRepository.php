<?php

namespace App\Repositories;

use App\Models\Automation;
use Illuminate\Database\Eloquent\Collection;

class AutomationsRepository
{
    public function all(): Collection
    {
        return Automation::all();
    }

    public function find(int $id): ?Automation
    {
        return Automation::find($id);
    }

    public function create(array $data): Automation
    {
        return Automation::create($data);
    }

    public function update(int $id, array $data): ?Automation
    {
        $automation = $this->find($id);

        if ($automation) {
            $automation->update($data);
        }

        return $automation;
    }

    public function delete(int $id): bool
    {
        $automation = $this->find($id);

        if ($automation) {
            return $automation->delete();
        }

        return false;
    }
}
