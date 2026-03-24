<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Level extends Model
{
    public function all(): array
    {
        return $this->db()->query('SELECT LevelID, LevelName FROM Levels ORDER BY LevelID')->fetchAll();
    }
}
