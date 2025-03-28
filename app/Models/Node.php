<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Node extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Родительский элемент
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'parent_id');
    }

    // Дочерние элементы
    public function children(): HasMany
    {
        return $this->hasMany(Node::class, 'parent_id')->orderBy('id');
    }

    // Получение всего дерева
    public static function getTree(int $parentId = null): array
    {
        $nodes = self::where('parent_id', $parentId)->get();
        $tree = [];

        foreach ($nodes as $node) {
            $tree[] = [
                'id' => $node->id,
                'name' => $node->name,
                'children' => self::getTree($node->id)
            ];
        }

        return $tree;
    }

    // Плоский список с отступами
    public static function getFlatTree(int $parentId = null, int $level = 0): array
    {
        $nodes = self::where('parent_id', $parentId)->get();
        $result = [];

        foreach ($nodes as $node) {
            $result[] = [
                'id' => $node->id,
                'name' => str_repeat('--', $level) . ' ' . $node->name,
                'level' => $level
            ];

            $result = array_merge(
                $result,
                self::getFlatTree($node->id, $level + 1)
            );
        }

        return $result;
    }
}
