<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Node;
use Illuminate\Http\Request;

class NodeController extends BaseController
{
    // Получить дерево
    public function tree()
    {
        return response()->json(Node::getTree());
    }

    // Получить плоский список
    public function flat()
    {
        return response()->json(Node::getFlatTree());
    }

    // Добавить узел
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|integer|exists:nodes,id'
        ]);

        $node = Node::create($validated);

        return response()->json($node, 201);
    }

    // Удалить узел (с потомками)
    public function destroy(Node $node)
    {
        $node->delete();
        return response()->noContent();
    }
}
