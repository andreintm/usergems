<?php

namespace App\Repositories;

use App\Models\Attendee;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Services\Person\Data\Company as PersonCompanyData;

class CompanyRepository implements CompanyRepositoryInterface
{

    public function all(): Collection
    {
        return Company::all();
    }

    public function find(int $id): Model
    {
        return Company::query()->find($id);
    }
}
