<?php

namespace App\Models\Search;

use App\Models\Professor;

class ProfessorSeach extends Professor
{
    public function search($request)
    {
        $id_usuario = ! empty($request->query('id_usuario')) ? $request->query('id_usuario') : null;
        $id_escola = ! empty($request->query('id_escola')) ? $request->query('id_escola') : null;

        $professores = self::query()
            ->with(['usuario', 'escola'])
            ->when($id_usuario, function ($query, $id_usuario) {
                return $query->where('id_usuario', $id_usuario);
            })
            ->when($id_escola, function ($query, $id_escola) {
                return $query->where('id_escola', (int) $id_escola);
            })
            ->paginate(6);

        return $professores;
    }
}
