<?php

namespace App\Models;

use App\Database\Category as DatabaseCategory;
use App\Facades\Response;

class Category extends Model
{
    public int $id;
    public string $name;
    public string|null $created_at;
    public string|null $updated_at;

    public static function all(): array
    {
        return DatabaseCategory::all();
    }

    public static function find(int $id): Category|bool
    {
        $category = self::_find($id);

        if ($category) {
            $category = (new Category())->load($category);
            return $category;
        }
        return false;
    }

    private static function _find(int $id): array|bool
    {
        $category = (new DatabaseCategory())->get_by_id($id);

        return $category;
    }

    private function load(array $category): Category
    {
        foreach ($category as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function toString(): array
    {
        return [
            "id"             => $this->id ?? 0,
            "name"           => $this->name,
            "created_at"     => $this->created_at,
            "updated_at"     => $this->updated_at
        ];
    }

    public function __toString()
    {
        return Response::json($this->toString());
    }
}
