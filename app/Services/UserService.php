<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Contracts\Database\Eloquent\Builder;

final class UserService
{

    const ALLOWED_FIELDS = ['id', 'name', 'email', 'company_name', '-id', '-name', '-email', '-company_name',];

    public function index(array $data): Builder
    {
        $orderBy = self::transformOrderBy($data['sort'] ?? 'id');
        $query = User::with('company')
                ->select(['users.*', 'companies.name as company_name'])
                ->when(static fn(Builder $q) => $orderBy[1] ? $q->orderByDesc($orderBy[0]) : $q->orderBy($orderBy[0]))
                ->leftJoin('companies', 'users.company_id', '=', 'companies.id');

        return $query;
    }

    private static function transformOrderBy(string $orderBy): array
    {
        return Str::startsWith($orderBy, '-') ?
                [Str::replaceFirst('-', '', $orderBy), true] :
                [Str::replaceFirst('-', '', $orderBy), false];
    }
}
