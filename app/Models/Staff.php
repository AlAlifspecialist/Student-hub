<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Staff extends Model
{
    public function all(): array
    {
        return $this->db()->query('SELECT StaffID, Name, JobTitle, Department, Bio FROM Staff ORDER BY Name')->fetchAll();
    }
}
